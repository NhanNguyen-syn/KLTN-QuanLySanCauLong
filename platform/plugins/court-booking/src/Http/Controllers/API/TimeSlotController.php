<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;

class TimeSlotController extends BaseController
{
    /**
     * Get all time slots
     * @group Time Slots
     */
    public function index(Request $request)
    {
        if (!Schema::hasTable('time_slots')) {
            return response()->json(['data' => []]);
        }

        $timeSlots = TimeSlot::query()
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function (TimeSlot $slot) {
                return [
                    'id' => $slot->id,
                    'label' => $slot->label,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'days_of_week' => $slot->days_of_week,
                    'duration_minutes' => $slot->duration_minutes ?? 30,
                ];
            });

        return response()->json(['data' => $timeSlots->values()]);
    }
}
