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
        for ($i = 0; $i < $daysAhead; $i++) {
            $forecastDate = $date->copy()->addDays($i);

            for ($hour = 0; $hour < 24; $hour++) {
                $this->forecastForDateTime($forecastDate, $hour);
            }
        }
    }

    protected function forecastForDateTime(Carbon $date, int $hour): void
    {
        // Get historical data for same day of week and hour
        $historicalBookings = DB::table('booking_lists')
            ->selectRaw('COUNT(*) as count')
            ->whereRaw('DAYOFWEEK(created_at) = ?', [$date->dayOfWeek + 1])
            ->whereRaw('HOUR(created_at) = ?', [$hour])
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(3))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count');

        if ($historicalBookings->isEmpty()) {
            $predicted = 0;
            $confidence = 0;
        } else {
            // Simple moving average
            $predicted = round($historicalBookings->avg());

            // Confidence based on data consistency
            $stdDev = $this->calculateStandardDeviation($historicalBookings->toArray());
            $confidence = max(0, 100 - ($stdDev * 10));
        }

        BookingForecast::updateOrCreate(
            [
                'forecast_date' => $date->toDateString(),
                'hour' => $hour,
                'court_id' => null,
            ],
            [
                'predicted_bookings' => $predicted,
                'confidence_score' => round($confidence, 2),
                'created_at' => now(),
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

    public function updateActualBookings(Carbon $date): void
    {
        for ($hour = 0; $hour < 24; $hour++) {
            $actual = DB::table('booking_lists')
                ->whereDate('created_at', $date)
                ->whereRaw('HOUR(created_at) = ?', [$hour])
                ->where('status', 'completed')
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
            ->selectRaw('hour, AVG(predicted_bookings) as avg_bookings')
            ->groupBy('hour')
            ->orderByDesc('avg_bookings')
            ->limit(5)
            ->get();

        return $forecasts->pluck('avg_bookings', 'hour')->toArray();
    }

    public function getWeeklyTrend(): array
    {
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = now()->addDays($i);
            $total = BookingForecast::whereDate('forecast_date', $date)
                ->sum('predicted_bookings');

            $data[$date->format('D')] = $total;
        }

        return $data;
    }

    public function getForecastAccuracy(): float
    {
        $forecasts = BookingForecast::whereNotNull('actual_bookings')
            ->where('created_at', '>=', now()->subDays(30))
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
            $heatmap[$date->format('D')] = [];

            for ($hour = 6; $hour <= 22; $hour++) {
                $bookings = BookingForecast::where('forecast_date', $date->toDateString())
                    ->where('hour', $hour)
                    ->value('predicted_bookings') ?? 0;

                $heatmap[$date->format('D')][$hour] = $bookings;
            }
        }

        return $heatmap;
    }
}
