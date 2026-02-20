<?php

namespace Botble\CourtBooking\Console;

use Botble\CourtBooking\Services\BookingForecastService;
use Botble\CourtBooking\Services\InsightGeneratorService;
use Illuminate\Console\Command;

class GenerateForecast extends Command
{
    protected $signature = 'forecast:generate {--days=7}';

    protected $description = 'Generate booking forecasts and AI insights';

    protected BookingForecastService $forecastService;
    protected InsightGeneratorService $insightService;

    public function __construct(
        BookingForecastService $forecastService,
        InsightGeneratorService $insightService
    ) {
        parent::__construct();
        $this->forecastService = $forecastService;
        $this->insightService = $insightService;
    }

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $this->info("Generating forecasts for next {$days} days...");

        $this->forecastService->generateForecast(now(), $days);

        $this->info('Updating actual bookings for yesterday...');
        $this->forecastService->updateActualBookings(now()->subDay());

        $this->info('Generating AI insights...');
        $this->insightService->generateAllInsights();

        $accuracy = $this->forecastService->getForecastAccuracy();
        $this->info("Current forecast accuracy: {$accuracy}%");

        return Command::SUCCESS;
    }
}
