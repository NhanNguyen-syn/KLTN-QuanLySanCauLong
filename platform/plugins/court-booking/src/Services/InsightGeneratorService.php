<?php

namespace Botble\CourtBooking\Services;

use Botble\CourtBooking\Models\AiInsight;
use Botble\CourtBooking\Models\BookingForecast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InsightGeneratorService
{
    public function generateAllInsights(): void
    {
        // Clear old insights first to avoid duplicates
        AiInsight::where('is_read', false)->delete();

        $this->generatePeakHoursInsight();
        $this->generateTrendInsight();
        $this->generateRecommendations();
        $this->detectAnomalies();
    }

    protected function generatePeakHoursInsight(): void
    {
        $peakHours = BookingForecast::where('forecast_date', '>=', now()->toDateString())
            ->where('forecast_date', '<=', now()->addDays(7)->toDateString())
            ->where('predicted_bookings', '>', 0)
            ->selectRaw('hour, AVG(predicted_bookings) as avg_bookings')
            ->groupBy('hour')
            ->orderByDesc('avg_bookings')
            ->limit(3)
            ->get();

        if ($peakHours->isNotEmpty()) {
            $hoursList = $peakHours->pluck('hour')->map(fn($h) => $h . ':00')->implode(', ');

            AiInsight::create([
                'insight_type' => 'peak_hours',
                'title' => 'Giờ cao điểm tuần tới',
                'description' => "Các khung giờ dự kiến đông khách nhất trong tuần tới: {$hoursList}. Đây là thời điểm cần đảm bảo đầy đủ nhân lực phục vụ, kiểm tra tình trạng sân và trang thiết bị. Nên ưu tiên bố trí nhân viên trực ca đông trong các khung giờ này để đảm bảo chất lượng dịch vụ và tối đa hóa công suất sân.",
                'data' => ['peak_hours' => $peakHours->toArray()],
                'priority' => 'high',
            ]);
        }
    }

    protected function generateTrendInsight(): void
    {
        // Compare this week vs last week using the 'date' column
        $thisWeek = DB::table('court_bookings_list')
            ->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])
            ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
            ->count();

        $lastWeek = DB::table('court_bookings_list')
            ->whereBetween('date', [now()->subWeek()->startOfWeek()->toDateString(), now()->subWeek()->endOfWeek()->toDateString()])
            ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
            ->count();

        if ($lastWeek > 0) {
            $change = (($thisWeek - $lastWeek) / $lastWeek) * 100;
            $direction = $change > 0 ? 'tăng' : 'giảm';
            $priority = abs($change) > 20 ? 'high' : 'medium';

            AiInsight::create([
                'insight_type' => 'trend',
                'title' => 'Xu hướng đặt sân',
                'description' => "Lượt đặt sân tuần này {$direction} " . abs(round($change, 1)) . "% so với tuần trước (tuần này: {$thisWeek} lượt, tuần trước: {$lastWeek} lượt). " . ($change > 0 ? "Xu hướng tăng cho thấy nhu cầu đang phát triển tốt, nên duy trì chất lượng dịch vụ và cân nhắc mở rộng khung giờ hoạt động." : "Xu hướng giảm có thể do thay đổi thời tiết, mùa vụ hoặc cạnh tranh. Nên xem xét triển khai các chương trình khuyến mãi để kích cầu."),
                'data' => [
                    'this_week' => $thisWeek,
                    'last_week' => $lastWeek,
                    'change_percent' => round($change, 2),
                ],
                'priority' => $priority,
            ]);
        } elseif ($thisWeek > 0) {
            AiInsight::create([
                'insight_type' => 'trend',
                'title' => 'Thống kê tuần này',
                'description' => "Tuần này ghi nhận {$thisWeek} lượt đặt sân. Chưa có dữ liệu tuần trước để so sánh xu hướng. Hệ thống sẽ tự động cập nhật phân tích xu hướng khi có thêm dữ liệu lịch sử trong các tuần tiếp theo.",
                'data' => ['this_week' => $thisWeek, 'last_week' => 0],
                'priority' => 'low',
            ]);
        }
    }

    protected function generateRecommendations(): void
    {
        // Find low-demand hours from forecast
        $lowDemandHours = BookingForecast::where('forecast_date', '>=', now()->toDateString())
            ->where('forecast_date', '<=', now()->addDays(7)->toDateString())
            ->selectRaw('hour, AVG(predicted_bookings) as avg_bookings')
            ->groupBy('hour')
            ->having('avg_bookings', '<', 2)
            ->whereRaw('hour BETWEEN 6 AND 22')
            ->get();

        if ($lowDemandHours->isNotEmpty()) {
            $hoursList = $lowDemandHours->pluck('hour')->map(fn($h) => $h . ':00')->implode(', ');

            AiInsight::create([
                'insight_type' => 'recommendation',
                'title' => 'Khuyến nghị khuyến mãi',
                'description' => "Các khung giờ dự kiến vắng khách trong tuần tới: {$hoursList}. Đây là cơ hội để triển khai chương trình khuyến mãi giảm giá 20-30% hoặc ưu đãi đặt sân theo gói để lấp đầy các khung giờ trống. Việc tận dụng hiệu quả các giờ vắng sẽ giúp tối ưu hóa công suất sân và tăng doanh thu tổng thể.",
                'data' => ['low_demand_hours' => $lowDemandHours->toArray()],
                'priority' => 'medium',
            ]);
        }
    }

    protected function detectAnomalies(): void
    {
        // Detect sudden drops in bookings using 'date' column
        $yesterday = DB::table('court_bookings_list')
            ->where('date', now()->subDay()->toDateString())
            ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
            ->count();

        $avg7Days = DB::table('court_bookings_list')
            ->whereBetween('date', [now()->subDays(8)->toDateString(), now()->subDays(2)->toDateString()])
            ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
            ->selectRaw('COUNT(*) / GREATEST(COUNT(DISTINCT date), 1) as avg')
            ->value('avg');

        if ($avg7Days > 0 && $yesterday < ($avg7Days * 0.5)) {
            AiInsight::create([
                'insight_type' => 'anomaly',
                'title' => '⚠️ Giảm lượt đặt bất thường',
                'description' => "Hôm qua chỉ ghi nhận {$yesterday} lượt đặt sân, giảm hơn 50% so với trung bình 7 ngày trước đó (" . round($avg7Days, 1) . " lượt/ngày). Nguyên nhân có thể do thời tiết xấu, sự kiện đặc biệt hoặc vấn đề về dịch vụ. Cần kiểm tra lại hệ thống đặt sân, đánh giá phản hồi khách hàng và cân nhắc triển khai khuyến mãi đặc biệt để phục hồi lượng đặt.",
                'data' => [
                    'yesterday' => $yesterday,
                    'avg_7days' => round($avg7Days, 1),
                ],
                'priority' => 'high',
            ]);
        }
    }

    public function clearOldInsights(int $daysToKeep = 30): int
    {
        return AiInsight::where('created_at', '<', now()->subDays($daysToKeep))->delete();
    }

    public function getUnreadInsights()
    {
        return AiInsight::unread()
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderByDesc('created_at')
            ->get();
    }

    public function getInsightsByType(string $type)
    {
        return AiInsight::byType($type)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
    }
}
