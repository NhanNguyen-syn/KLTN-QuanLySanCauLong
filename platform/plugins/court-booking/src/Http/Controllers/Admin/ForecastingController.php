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

            return $this
                ->httpResponse()
                ->setMessage('Forecasts and insights regenerated successfully');
        } catch (\Exception $e) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage('Error: ' . $e->getMessage());
        }
    }
}
