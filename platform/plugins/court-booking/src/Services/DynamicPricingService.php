<?php

namespace Botble\CourtBooking\Services;

use Botble\CourtBooking\Models\BookingForecast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DynamicPricingService
{
    protected float $basePrice = 200000; // 200k VND base price

    public function calculatePrice(
        ?int $courtId,
        Carbon $dateTime
    ): array {
        $basePrice = $this->getBasePrice($courtId);
        $dayOfWeek = $dateTime->dayOfWeek;
        $hour = $dateTime->hour;

        // Get applicable rules
        $rules = DB::table('pricing_rules')
            ->where('is_active', true)
            ->where(function ($q) use ($courtId) {
                $q->whereNull('court_id')
                    ->orWhere('court_id', $courtId);
            })
            ->where(function ($q) use ($dayOfWeek) {
                $q->whereNull('day_of_week')
                    ->orWhere('day_of_week', $dayOfWeek);
            })
            ->where(function ($q) use ($hour) {
                $q->whereNull('time_start')
                    ->orWhere(DB::raw('HOUR(time_start)'), '<=', $hour);
            })
            ->where(function ($q) use ($hour) {
                $q->whereNull('time_end')
                    ->orWhere(DB::raw('HOUR(time_end)'), '>=', $hour);
            })
            ->orderByDesc('priority')
            ->get();

        $totalMultiplier = 1.0;

        foreach ($rules as $rule) {
            $totalMultiplier *= $rule->base_multiplier;

            // Apply demand-based multiplier if exists
            if ($rule->demand_multiplier) {
                $demandLevel = $this->getDemandLevel($dateTime);

                if ($this->shouldApplyDemandMultiplier($demandLevel, $rule->demand_threshold)) {
                    $totalMultiplier *= $rule->demand_multiplier;
                }
            }
        }

        $finalPrice = $basePrice * $totalMultiplier;

        // Log price calculation
        $this->logPrice($courtId, $dateTime, $basePrice, $finalPrice, $totalMultiplier);

        return [
            'base_price' => $basePrice,
            'final_price' => round($finalPrice, -3), // Round to nearest 1000
            'multiplier' => round($totalMultiplier, 2),
            'applied_rules' => $rules->pluck('name')->toArray(),
        ];
    }

    protected function getBasePrice(?int $courtId): float
    {
        // Could fetch from courts table
        return $this->basePrice;
    }

    protected function getDemandLevel(Carbon $dateTime): int
    {
        $forecast = BookingForecast::where('forecast_date', $dateTime->toDateString())
            ->where('hour', $dateTime->hour)
            ->first();

        return $forecast ? $forecast->predicted_bookings : 0;
    }

    protected function shouldApplyDemandMultiplier(int $demandLevel, ?string $threshold): bool
    {
        if (!$threshold) {
            return false;
        }

        $thresholds = [
            'low' => 2,
            'medium' => 4,
            'high' => 6,
        ];

        return $demandLevel >= ($thresholds[$threshold] ?? 999);
    }

    protected function logPrice(
        ?int $courtId,
        Carbon $dateTime,
        float $basePrice,
        float $finalPrice,
        float $multiplier
    ): void {
        DB::table('price_history')->insert([
            'court_id' => $courtId,
            'date' => $dateTime->toDateString(),
            'hour' => $dateTime->hour,
            'base_price' => $basePrice,
            'final_price' => $finalPrice,
            'applied_multiplier' => $multiplier,
            'demand_level' => $this->getDemandLevel($dateTime),
            'created_at' => now(),
        ]);
    }

    public function createPeakHourRule(): void
    {
        // Create rule for peak hours (18:00-21:00)
        DB::table('pricing_rules')->insert([
            'name' => 'Peak Hours (6PM-9PM)',
            'court_id' => null,
            'day_of_week' => null,
            'time_start' => '18:00',
            'time_end' => '21:00',
            'base_multiplier' => 1.5,
            'demand_multiplier' => null,
            'is_active' => true,
            'priority' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function createWeekendRule(): void
    {
        // Saturday & Sunday
        foreach ([6, 0] as $day) {
            DB::table('pricing_rules')->insert([
                'name' => 'Weekend Pricing',
                'court_id' => null,
                'day_of_week' => $day,
                'time_start' => null,
                'time_end' => null,
                'base_multiplier' => 1.3,
                'demand_multiplier' => null,
                'is_active' => true,
                'priority' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function createHighDemandRule(): void
    {
        DB::table('pricing_rules')->insert([
            'name' => 'High Demand Surge',
            'court_id' => null,
            'day_of_week' => null,
            'time_start' => null,
            'time_end' => null,
            'base_multiplier' => 1.0,
            'demand_multiplier' => 1.2,
            'demand_threshold' => 'high',
            'is_active' => true,
            'priority' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getPriceHeatmap(Carbon $startDate, int $days = 7): array
    {
        $heatmap = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $heatmap[$date->format('Y-m-d')] = [];

            for ($hour = 6; $hour <= 22; $hour++) {
                $datetime = $date->copy()->setTime($hour, 0);
                $pricing = $this->calculatePrice(null, $datetime);

                $heatmap[$date->format('Y-m-d')][$hour] = $pricing['final_price'];
            }
        }

        return $heatmap;
    }
}
