<?php

namespace Botble\CourtBooking\Commands;

use Botble\CourtBooking\Models\{Court, CourtSlot, PricingRule, TimeSlot, Holiday};
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateSlotsCommand extends Command
{
    protected $signature = 'slots:generate {--days=30}';
    protected $description = 'Generate court slots for next N days and apply pricing rules';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $from = Carbon::today();
        $to = Carbon::today()->addDays($days);

        $this->info("Generating slots from {$from->toDateString()} to {$to->toDateString()}");

        $courts = Court::all();
        $timeSlots = TimeSlot::all();
        $guestRules = PricingRule::where('active', true)->whereIn('audience', ['guest','all'])->orderBy('priority')->get();
        $memberRules = PricingRule::where('active', true)->whereIn('audience', ['member','all'])->orderBy('priority')->get();
        $holidays = Holiday::pluck('date')->all();

        DB::transaction(function () use ($courts, $timeSlots, $from, $to, $guestRules, $memberRules, $holidays) {
            foreach ($courts as $court) {
                foreach (CarbonPeriod::create($from, $to) as $date) {
                    $dow = (int) $date->format('N'); // 1..7
                    foreach ($timeSlots as $ts) {
                        $daysOfWeek = array_map('intval', explode(',', $ts->days_of_week));
                        if (! in_array($dow, $daysOfWeek, true)) {
                            continue;
                        }
                        $start = Carbon::parse($date->toDateString() . ' ' . $ts->start_time);
                        $end = Carbon::parse($date->toDateString() . ' ' . $ts->end_time);

                        if (CourtSlot::where('court_id', $court->id)->where('start_at', $start)->exists()) {
                            continue;
                        }

                        $guest = $this->resolvePrice($guestRules, $holidays, $date, $start, $end);
                        $member = $this->resolvePrice($memberRules, $holidays, $date, $start, $end);

                        CourtSlot::create([
                            'court_id' => $court->id,
                            'start_at' => $start,
                            'end_at' => $end,
                            'status' => 'available',
                            'base_price' => $guest['price'],
                            'member_price' => $member['price'],
                            'applied_rule_id' => $guest['rule_id'],
                        ]);
                    }
                }
            }
        });

        $this->info('Done.');
        return self::SUCCESS;
    }

    private function resolvePrice($rules, $holidays, Carbon $date, Carbon $start, Carbon $end): array
    {
        $isHoliday = in_array($date->toDateString(), array_map(fn($d) => (string) $d, $holidays), true);
        foreach ($rules as $rule) {
            if ($rule->type === 'holiday' && ! $isHoliday) continue;
            if ($rule->type === 'weekday' && ($date->isWeekend() || $isHoliday)) continue;
            if ($rule->type === 'weekend' && (! $date->isWeekend() || $isHoliday)) continue;

            if ($start->format('H:i:s') >= $rule->from_time && $end->format('H:i:s') <= $rule->to_time) {
                return ['price' => (float) $rule->price, 'rule_id' => $rule->id];
            }
        }
        return ['price' => 0.0, 'rule_id' => null];
    }
}

