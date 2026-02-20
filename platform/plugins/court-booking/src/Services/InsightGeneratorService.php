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
        $this->generatePeakHoursInsight();
        $this->generateTrendInsight();
        $this->generateRecommendations();
        $this->detectAnomalies();
    }

    protected function generatePeakHoursInsight(): void
    {
        $peakHours = BookingForecast::where('forecast_date', '>=', now()->toDateString())
            ->where('forecast_date', '<=', now()->addDays(7)->toDateString())
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
                'description' => "Khung giờ dự kiến đông nhất: {$hoursList}. Hãy chuẩn bị nhân lực và sân đầy đủ.",
                'data' => ['peak_hours' => $peakHours->toArray()],
                'priority' => 'high',
                'created_at' => now(),
            ]);
        }
    }

    protected function generateTrendInsight(): void
    {
        // Compare this week vs last week
        $thisWeek = DB::table('booking_lists')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'completed')
            ->count();

        $lastWeek = DB::table('booking_lists')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->where('status', 'completed')
            ->count();

        if ($lastWeek > 0) {
            $change = (($thisWeek - $lastWeek) / $lastWeek) * 100;
            $direction = $change > 0 ? 'tăng' : 'giảm';
            $priority = abs($change) > 20 ? 'high' : 'medium';

            AiInsight::create([
                'insight_type' => 'trend',
                'title' => 'Xu hướng đặt sân',
                'description' => "Tuần này {$direction} " . abs(round($change, 1)) . "% so với tuần trước ({$thisWeek} vs {$lastWeek} bookings).",
                'data' => [
                    'this_week' => $thisWeek,
                    'last_week' => $lastWeek,
                    'change_percent' => round($change, 2),
                ],
                'priority' => $priority,
                'created_at' => now(),
            ]);
        }
    }

    protected function generateRecommendations(): void
    {
        // Find low-demand hours
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
                'description' => "Khung giờ sepi dự kiến: {$hoursList}. Nên tung khuyến mãi để tối ưu doanh thu.",
                'data' => ['low_demand_hours' => $lowDemandHours->toArray()],
                'priority' => 'medium',
                'created_at' => now(),
            ]);
        }
    }

    protected function detectAnomalies(): void
    {
        // Detect sudden drops in bookings
        $yesterday = DB::table('booking_lists')
            ->whereDate('created_at', now()->subDay())
            ->where('status', 'completed')
            ->count();

        $avg7Days = DB::table('booking_lists')
            ->whereBetween('created_at', [now()->subDays(8), now()->subDays(2)])
            ->where('status', 'completed')
            ->selectRaw('COUNT(*) / 7 as avg')
            ->value('avg');

        if ($avg7Days > 0 && $yesterday < ($avg7Days * 0.5)) {
            AiInsight::create([
                'insight_type' => 'anomaly',
                'title' => '⚠️ Giảm booking bất thường',
                'description' => "Hôm qua chỉ có {$yesterday} bookings, giảm hơn 50% so với trung bình ({$avg7Days}). Cần kiểm tra nguyên nhân.",
                'data' => [
                    'yesterday' => $yesterday,
                    'avg_7days' => round($avg7Days, 1),
                ],
                'priority' => 'high',
                'created_at' => now(),
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
            ->orderByDesc('priority')
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
