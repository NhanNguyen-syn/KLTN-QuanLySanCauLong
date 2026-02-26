<?php

namespace Botble\CourtBooking\Services;

use Botble\CourtBooking\Models\AiInsight;
use Botble\CourtBooking\Models\BookingForecast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingForecastService
{
    public function generateForecast(Carbon $date, int $daysAhead = 7): void
    {
        // Step 1: Backfill past 14 days with forecasts + actuals for accuracy calculation
        $this->backfillPastForecasts(14);

        // Step 2: Generate future forecasts
        for ($i = 0; $i < $daysAhead; $i++) {
            $forecastDate = $date->copy()->addDays($i);

            // Only forecast for operating hours (5:00 - 22:00)
            for ($hour = 5; $hour <= 22; $hour++) {
                $this->forecastForDateTime($forecastDate, $hour);
            }
        }
    }

    /**
     * Backfill past forecasts and actual bookings for accuracy calculation.
     * Uses leave-one-out: excludes each date's own data when predicting for it.
     */
    protected function backfillPastForecasts(int $days): void
    {
        for ($i = 1; $i <= $days; $i++) {
            $pastDate = now()->subDays($i);

            for ($hour = 5; $hour <= 22; $hour++) {
                $this->forecastForDateTime($pastDate, $hour, $pastDate);
            }

            // Immediately fill actual bookings for this past date
            $this->updateActualBookings($pastDate);
        }
    }

    protected function forecastForDateTime(Carbon $date, int $hour, ?Carbon $excludeDate = null): void
    {
        // Use the actual booking columns: 'date' and 'start_time'
        $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
        $nextHourStr = str_pad($hour + 1, 2, '0', STR_PAD_LEFT);

        $query = DB::table('court_bookings_list')
            ->selectRaw('COUNT(*) as count')
            ->whereRaw('DAYOFWEEK(`date`) = ?', [$date->dayOfWeek + 1])
            ->where('start_time', '>=', "{$hourStr}:00:00")
            ->where('start_time', '<', "{$nextHourStr}:00:00")
            ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
            ->where('date', '>=', now()->subMonths(3)->toDateString());

        // For cross-validation: exclude the target date itself when backfilling
        if ($excludeDate) {
            $query->where('date', '!=', $excludeDate->toDateString());
        }

        $historicalBookings = $query->groupBy('date')->pluck('count');

        if ($historicalBookings->isEmpty()) {
            $predicted = 0;
            $confidence = 0;
        } else {
            // Simple moving average
            $predicted = round($historicalBookings->avg());

            // Confidence based on coefficient of variation
            $stdDev = $this->calculateStandardDeviation($historicalBookings->toArray());
            $mean = $historicalBookings->avg();
            if ($mean > 0) {
                $cv = ($stdDev / $mean) * 100;
                $confidence = max(0, min(100, 100 - $cv));
            } else {
                $confidence = 0;
            }
        }

        BookingForecast::updateOrCreate(
            [
                'forecast_date' => $date->toDateString(),
                'hour' => $hour,
                'court_id' => 0,
            ],
            [
                'predicted_bookings' => $predicted,
                'confidence_score' => round($confidence, 2),
            ]
        );
    }

    protected function calculateStandardDeviation(array $values): float
    {
        if (empty($values)) {
            return 0;
        }

        $mean = array_sum($values) / count($values);
        $variance = array_sum(array_map(fn($x) => ($x - $mean) ** 2, $values)) / count($values);

        return sqrt($variance);
    }

    /**
     * Update actual bookings for all past forecast dates
     */
    public function updateActualBookingsForPastDates(): void
    {
        $pastForecasts = BookingForecast::where('forecast_date', '<', now()->toDateString())
            ->whereNull('actual_bookings')
            ->select('forecast_date')
            ->distinct()
            ->pluck('forecast_date');

        foreach ($pastForecasts as $forecastDate) {
            $this->updateActualBookings(Carbon::parse($forecastDate));
        }
    }

    public function updateActualBookings(Carbon $date): void
    {
        for ($hour = 5; $hour <= 22; $hour++) {
            $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
            $nextHourStr = str_pad($hour + 1, 2, '0', STR_PAD_LEFT);

            $actual = DB::table('court_bookings_list')
                ->where('date', $date->toDateString())
                ->where('start_time', '>=', "{$hourStr}:00:00")
                ->where('start_time', '<', "{$nextHourStr}:00:00")
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->count();

            BookingForecast::where('forecast_date', $date->toDateString())
                ->where('hour', $hour)
                ->update(['actual_bookings' => $actual]);
        }
    }

    public function getPeakHours(Carbon $date = null): array
    {
        $date = $date ?? now();

        $forecasts = BookingForecast::where('forecast_date', '>=', $date->toDateString())
            ->where('forecast_date', '<=', $date->copy()->addDays(7)->toDateString())
            ->where('predicted_bookings', '>', 0)
            ->selectRaw('hour, AVG(predicted_bookings) as avg_bookings')
            ->groupBy('hour')
            ->orderByDesc('avg_bookings')
            ->limit(5)
            ->get();

        // If no forecast data, fall back to actual historical data
        if ($forecasts->isEmpty()) {
            $historicalPeaks = DB::table('court_bookings_list')
                ->selectRaw('HOUR(start_time) as hour, COUNT(*) / GREATEST(COUNT(DISTINCT date), 1) as avg_bookings')
                ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                ->where('date', '>=', now()->subMonths(1)->toDateString())
                ->groupByRaw('HOUR(start_time)')
                ->orderByDesc('avg_bookings')
                ->limit(5)
                ->get();

            return $historicalPeaks->pluck('avg_bookings', 'hour')->toArray();
        }

        return $forecasts->pluck('avg_bookings', 'hour')->toArray();
    }

    public function getWeeklyTrend(): array
    {
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = now()->addDays($i);
            $total = BookingForecast::whereDate('forecast_date', $date)
                ->sum('predicted_bookings');

            // If no forecast data for this date, estimate from historical
            if ($total == 0) {
                $total = DB::table('court_bookings_list')
                    ->whereRaw('DAYOFWEEK(`date`) = ?', [$date->dayOfWeek + 1])
                    ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                    ->where('date', '>=', now()->subMonths(2)->toDateString())
                    ->selectRaw('CEIL(COUNT(*) / GREATEST(COUNT(DISTINCT date), 1)) as avg_daily')
                    ->value('avg_daily') ?? 0;

                $total = round($total);
            }

            $data[$date->format('D d/m')] = $total;
        }

        return $data;
    }

    public function getForecastAccuracy(): float
    {
        $forecasts = BookingForecast::whereNotNull('actual_bookings')
            ->where('forecast_date', '>=', now()->subDays(30)->toDateString())
            ->get();

        if ($forecasts->isEmpty()) {
            return 0;
        }

        $accurateCount = $forecasts->filter(fn($f) => $f->isAccurate())->count();

        return round(($accurateCount / $forecasts->count()) * 100, 2);
    }

    public function getDemandHeatmap(): array
    {
        $heatmap = [];

        for ($day = 0; $day < 7; $day++) {
            $date = now()->startOfWeek()->addDays($day);
            $dayLabel = $date->format('D');
            $heatmap[$dayLabel] = [];

            for ($hour = 6; $hour <= 22; $hour++) {
                $bookings = BookingForecast::where('forecast_date', $date->toDateString())
                    ->where('hour', $hour)
                    ->value('predicted_bookings') ?? 0;

                // If no forecast, use historical average
                if ($bookings == 0) {
                    $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                    $nextHourStr = str_pad($hour + 1, 2, '0', STR_PAD_LEFT);
                    $bookings = DB::table('court_bookings_list')
                        ->whereRaw('DAYOFWEEK(`date`) = ?', [$date->dayOfWeek + 1])
                        ->where('start_time', '>=', "{$hourStr}:00:00")
                        ->where('start_time', '<', "{$nextHourStr}:00:00")
                        ->whereIn('status', ['completed', 'confirmed', 'paid', 'processing'])
                        ->where('date', '>=', now()->subMonths(2)->toDateString())
                        ->selectRaw('CEIL(COUNT(*) / GREATEST(COUNT(DISTINCT date), 1)) as avg_bookings')
                        ->value('avg_bookings') ?? 0;
                }

                $heatmap[$dayLabel][$hour] = $bookings;
            }
        }

        return $heatmap;
    }
}
