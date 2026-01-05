<?php

namespace Botble\CourtBooking\Database\Seeders;

use Illuminate\Database\Seeder;
use Botble\CourtBooking\Models\{Court, TimeSlot, PricingRule};
use Carbon\Carbon;

class CourtBookingSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Courts
        foreach (['Sân 1','Sân 2','Sân 3'] as $name) {
            Court::firstOrCreate(['name' => $name], ['status' => 'published']);
        }

        // 2) Time slots: every 30 minutes from 05:00 to 23:00, all days
        $start = Carbon::createFromTimeString('05:00');
        $end = Carbon::createFromTimeString('23:00');
        $cursor = $start->copy();
        while ($cursor < $end) {
            $label = $cursor->format('H:i') . '-' . $cursor->copy()->addMinutes(30)->format('H:i');
            TimeSlot::updateOrCreate(
                ['label' => $label],
                [
                    'start_time' => $cursor->format('H:i:s'),
                    'end_time' => $cursor->copy()->addMinutes(30)->format('H:i:s'),
                    'days_of_week' => '1,2,3,4,5,6,7',
                    'duration_minutes' => 30,
                ]
            );
            $cursor->addMinutes(30);
        }

        // 3) Pricing: guest 150k/h (75k/30m), member 120k/h (60k/30m) from 05:00-23:00 everyday
        PricingRule::updateOrCreate(
            ['name' => 'Guest regular 05-23'],
            [
                'type' => 'custom',
                'audience' => 'guest',
                'from_time' => '05:00:00',
                'to_time' => '23:00:00',
                'price' => 75000,
                'priority' => 10,
                'active' => true,
            ]
        );

        PricingRule::updateOrCreate(
            ['name' => 'Member regular 05-23'],
            [
                'type' => 'custom',
                'audience' => 'member',
                'from_time' => '05:00:00',
                'to_time' => '23:00:00',
                'price' => 60000,
                'priority' => 10,
                'active' => true,
            ]
        );
    }
}

