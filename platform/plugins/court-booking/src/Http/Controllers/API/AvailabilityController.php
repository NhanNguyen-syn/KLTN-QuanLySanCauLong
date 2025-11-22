<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\CourtSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AvailabilityController extends BaseController
{
    public function index(Request $request)
    {
        $query = CourtSlot::query()->with('court')
            ->where('status', 'available');

        if ($request->filled('court_id')) {
            $query->where('court_id', (int) $request->get('court_id'));
        }

        $date = $request->get('date');
        $from = $request->get('from');
        $to = $request->get('to');

        if ($date) {
            $start = Carbon::parse($date)->startOfDay();
            $end = Carbon::parse($date)->endOfDay();
            $query->whereBetween('start_at', [$start, $end]);
        } elseif ($from && $to) {
            $query->whereBetween('start_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        if ($request->filled('time_from') && $request->filled('time_to')) {
            $tf = $request->get('time_from');
            $tt = $request->get('time_to');
            $query->whereRaw('TIME(start_at) >= ?', [$tf])
                  ->whereRaw('TIME(end_at) <= ?', [$tt]);
        }

        $query->orderBy('start_at');

        return response()->json($query->paginate(50));
    }
}

