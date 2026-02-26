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
            $peakHoursStr = collect($peakHours)->map(fn($val, $key) => "{$key}:00 ({$val} luot)")->implode(', ');
            $weeklyTrendStr = collect($weeklyTrend)->map(fn($val, $key) => "{$key}: {$val} luot")->implode(', ');

            // Get additional stats from database
            $totalBookingsThisWeek = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
            $totalBookingsLastWeek = \Illuminate\Support\Facades\DB::table('court_bookings_list')
                ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
                ->count();
            $totalCourts = \Illuminate\Support\Facades\DB::table('courts')->where('status', 'published')->count();

            $prompt = 'Ban la chuyen gia co van kinh doanh san cau long. '
                . 'Dua vao so lieu ben duoi, dua ra DUNG 3 goi y chi tiet nhung ngan gon (moi goi y 3-4 cau, neu ro van de va giai phap cu the). '
                . 'Tra loi bang tieng Viet co dau. Dinh dang HTML thuan (chi dung <h5>, <ul>, <li>, <strong>). '
                . 'KHONG dung markdown. Di thang vao trong tam. '
                . "\n\nSo lieu:\n"
                . "- San hoat dong: {$totalCourts}\n"
                . "- Dat tuan nay: {$totalBookingsThisWeek} | Tuan truoc: {$totalBookingsLastWeek}\n"
                . "- Gio cao diem: " . ($peakHoursStr ?: 'Chua co') . "\n"
                . "- Du bao tuan toi: " . ($weeklyTrendStr ?: 'Chua co') . "\n";

            // Determine which AI provider to use (same as AI Chatbot settings)
            $provider = setting('ai_chatbot_llm_provider', 'gemini');
            $apiKey = \Botble\AiChatbot\Models\ApiKey::getKeyForProvider($provider);
            $model = \Botble\AiChatbot\Models\ApiKey::getModelForProvider($provider);

            if (empty($apiKey)) {
                return $this->httpResponse()->setError()
                    ->setMessage('Chua cau hinh API Key AI. Vui long vao Tro Ly AI > Cai Dat de thiet lap.');
            }

            if ($provider === 'gemini') {
                $aiResponse = $this->callGeminiApi($apiKey, $model, $prompt);
            } else {
                $aiResponse = $this->callOpenAiApi($apiKey, $model, $prompt);
            }

            return $this->httpResponse()
                ->setData($aiResponse)
                ->setMessage('AI analysis completed');
        } catch (\Exception $e) {
            return $this->httpResponse()->setError()->setMessage('Loi AI: ' . $e->getMessage());
        }
    }

    protected function callGeminiApi(string $apiKey, string $model, string $prompt): string
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->connectTimeout(10)->timeout(25)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1024,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
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
        ])->connectTimeout(10)->timeout(25)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'Ban la chuyen gia co van kinh doanh san cau long. Tra loi ngan gon, toi da 3 goi y. Tieng Viet co dau, HTML thuan (h5, ul, li, strong). Khong markdown.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 1024,
            'temperature' => 0.7,
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
