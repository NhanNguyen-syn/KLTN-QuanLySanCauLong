<?php

namespace Botble\CourtBooking\Http\Controllers\Admin;

use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Services\BookingForecastService;
use Botble\CourtBooking\Services\InsightGeneratorService;
use Botble\CourtBooking\Models\AiInsight;

class ForecastingController extends BaseController
{
    protected BookingForecastService $forecastService;
    protected InsightGeneratorService $insightService;

    public function __construct(
        BookingForecastService $forecastService,
        InsightGeneratorService $insightService
    ) {
        $this->forecastService = $forecastService;
        $this->insightService = $insightService;
    }

    public function index()
    {
        $this->pageTitle('Dự báo & Thông tin');

        $peakHours = $this->forecastService->getPeakHours();
        $weeklyTrend = $this->forecastService->getWeeklyTrend();
        $heatmap = $this->forecastService->getDemandHeatmap();
        $accuracy = $this->forecastService->getForecastAccuracy();
        $insights = $this->insightService->getUnreadInsights();

        return view('plugins/court-booking::admin.forecasting.index', compact(
            'peakHours',
            'weeklyTrend',
            'heatmap',
            'accuracy',
            'insights'
        ));
    }

    public function markInsightRead(int $id)
    {
        $insight = AiInsight::findOrFail($id);
        $insight->markAsRead();

        return $this
            ->httpResponse()
            ->setMessage('Insight marked as read');
    }

    public function regenerate()
    {
        try {
            $this->forecastService->generateForecast(now(), 7);
            $this->insightService->generateAllInsights();

            $accuracy = $this->forecastService->getForecastAccuracy();

            return $this
                ->httpResponse()
                ->setData([
                    'accuracy' => $accuracy,
                ])
                ->setMessage('Đã tạo lại dự báo và insights thành công! Độ chính xác: ' . $accuracy . '%');
        } catch (\Exception $e) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage('Lỗi: ' . $e->getMessage());
        }
    }

    public function generateAiAdvice()
    {
        try {
            // Get necessary metrics to feed the AI
            $peakHours = $this->forecastService->getPeakHours();
            $weeklyTrend = $this->forecastService->getWeeklyTrend();

            // Format data into a prompt
            $peakHoursStr = collect($peakHours)->map(fn($val, $key) => "{$key}:00 ({$val} lượt)")->implode(', ');
            $weeklyTrendStr = collect($weeklyTrend)->map(fn($val, $key) => "{$key}: {$val} lượt")->implode(', ');

            // Get REAL stats from database
            $totalBookingsThisWeek = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->count();
            $totalBookingsLastWeek = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->subWeek()->startOfWeek()->toDateString(), now()->subWeek()->endOfWeek()->toDateString()])
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->count();
            $totalCourts = \Illuminate\Support\Facades\DB::table('courts')->where('status', 'published')->count();

            // Bookings per day of week (real data from last 4 weeks)
            $bookingsByDay = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->subWeeks(4)->toDateString(), now()->toDateString()])
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->selectRaw('DAYNAME(date) as day_name, COUNT(*) as total')
                ->groupBy('day_name')
                ->orderByRaw('FIELD(day_name, "Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")')
                ->pluck('total', 'day_name');

            $dayNames = ['Monday' => 'Thứ Hai', 'Tuesday' => 'Thứ Ba', 'Wednesday' => 'Thứ Tư', 'Thursday' => 'Thứ Năm', 'Friday' => 'Thứ Sáu', 'Saturday' => 'Thứ Bảy', 'Sunday' => 'Chủ Nhật'];
            $bookingsByDayStr = $bookingsByDay->map(fn($val, $key) => ($dayNames[$key] ?? $key) . ": {$val}")->implode(', ');

            // Bookings per hour (real data)
            $bookingsByHour = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->subWeeks(4)->toDateString(), now()->toDateString()])
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->selectRaw('HOUR(start_time) as hour, COUNT(*) as total')
                ->groupBy('hour')
                ->orderBy('hour')
                ->pluck('total', 'hour');
            $bookingsByHourStr = $bookingsByHour->map(fn($val, $key) => "{$key}h({$val})")->implode(', ');

            // Cancellation rate
            $cancelledCount = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->subWeeks(4)->toDateString(), now()->toDateString()])
                ->where('status', 'cancelled')
                ->count();
            $totalAll = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->subWeeks(4)->toDateString(), now()->toDateString()])
                ->count();
            $cancelRate = $totalAll > 0 ? round(($cancelledCount / $totalAll) * 100, 1) : 0;

            // Total revenue this week
            $revenueThisWeek = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->sum('paid_amount');

            $avgPerDay = $totalAll > 0 ? round($totalAll / 28, 1) : 0;

            // Build concise data block
            $dataBlock = "Sân: {$totalCourts}. "
                . "Tuần này: {$totalBookingsThisWeek} lượt, tuần trước: {$totalBookingsLastWeek}. "
                . "TB/ngày: {$avgPerDay}. "
                . "Doanh thu tuần: " . number_format($revenueThisWeek) . "đ. "
                . "Hủy: {$cancelRate}%. "
                . "Theo thứ(4 tuần): " . ($bookingsByDayStr ?: 'N/A') . ". "
                . "Theo giờ(4 tuần): " . ($bookingsByHourStr ?: 'N/A') . ". "
                . "Cao điểm dự báo: " . ($peakHoursStr ?: 'N/A') . ".";

            $prompt = "Dữ liệu thực tế sân cầu lông: {$dataBlock}\n\n"
                . "YÊU CẦU: Phân tích dữ liệu trên, đưa ra ĐÚNG 3 gợi ý. "
                . "Tiếng Việt có dấu 100%. KHÔNG viết lời mở đầu hay giới thiệu. "
                . "BẮT ĐẦU NGAY bằng thẻ <div> đầu tiên. "
                . "Mỗi gợi ý dùng HTML:\n"
                . '<div style="background:#f8f9fa;border-left:4px solid #206bc4;padding:14px 18px;margin-bottom:14px;border-radius:6px">'
                . '<h5 style="margin:0 0 8px;color:#206bc4;font-size:15px">[emoji] Tiêu đề</h5>'
                . '<p style="margin:0 0 8px;line-height:1.9"><strong>📊 Vấn đề:</strong><br>• ý 1<br>• ý 2</p>'
                . '<p style="margin:0;line-height:1.9"><strong>💡 Giải pháp:</strong><br>• ý 1<br>• ý 2</p>'
                . "</div>\n"
                . "Quy tắc: Mỗi ý chỉ 1 câu ngắn, trích số liệu. KHÔNG markdown. Emoji tiêu đề: 🎯📈⚡🏸💰🔥.";

            // Determine which AI provider to use
            $provider = setting('ai_chatbot_llm_provider', 'gemini');
            $apiKey = \Botble\AiChatbot\Models\ApiKey::getKeyForProvider($provider);
            $model = \Botble\AiChatbot\Models\ApiKey::getModelForProvider($provider);

            if (empty($apiKey)) {
                return $this->httpResponse()->setError()
                    ->setMessage('Chưa cấu hình API Key AI. Vui lòng vào Trợ Lý AI > Cài Đặt để thiết lập.');
            }

            // Try up to 3 times to get a complete response
            $aiResponse = '';
            for ($attempt = 1; $attempt <= 3; $attempt++) {
                if ($provider === 'gemini') {
                    $aiResponse = $this->callGeminiApi($apiKey, $model, $prompt);
                } else {
                    $aiResponse = $this->callOpenAiApi($apiKey, $model, $prompt);
                }

                // Clean: strip any text before first <div
                $firstDiv = strpos($aiResponse, '<div');
                if ($firstDiv !== false && $firstDiv > 0) {
                    $aiResponse = substr($aiResponse, $firstDiv);
                }

                // Check completeness: need 3 opening AND 3 closing div tags
                $openDivs = substr_count($aiResponse, '<div');
                $closeDivs = substr_count($aiResponse, '</div>');
                if ($openDivs >= 3 && $closeDivs >= 3) {
                    break; // Complete response, stop retrying
                }
            }

            return $this->httpResponse()
                ->setData($aiResponse)
                ->setMessage('AI analysis completed');
        } catch (\Exception $e) {
            return $this->httpResponse()->setError()->setMessage('Lỗi AI: ' . $e->getMessage());
        }
    }

    protected function callGeminiApi(string $apiKey, string $model, string $prompt): string
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->connectTimeout(15)->timeout(90)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 4096,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $candidate = $data['candidates'][0] ?? [];
            $text = $candidate['content']['parts'][0]['text'] ?? '';
            $text = preg_replace('/^```html\s*/s', '', $text);
            $text = preg_replace('/```\s*$/s', '', $text);
            return trim($text);
        }

        throw new \Exception('Gemini API error: ' . $response->body());
    }

    protected function callOpenAiApi(string $apiKey, string $model, string $prompt): string
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->connectTimeout(15)->timeout(90)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là cố vấn kinh doanh sân cầu lông. Trả lời ĐÚNG 3 gợi ý bằng HTML. Tiếng Việt có dấu 100%. BẮT ĐẦU NGAY bằng thẻ <div>, không viết lời mở đầu. Dùng <br> và bullet (• ) xuống dòng, mỗi ý 1 câu ngắn.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 4096,
            'temperature' => 0.4,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['choices'][0]['message']['content'] ?? '';
            $text = preg_replace('/^```html\s*/s', '', $text);
            $text = preg_replace('/```\s*$/s', '', $text);
            return trim($text);
        }

        throw new \Exception('OpenAI API error: ' . $response->body());
    }
}
