<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $service)
    {
    }

    public function hold(Request $request)
    {
        $data = $request->validate([
            'slot_ids' => 'required|array|min:1',
            'slot_ids.*' => 'integer|distinct',
            'user_id' => 'nullable|integer'
        ]);

        $userId = $data['user_id'] ?? ($request->user()?->id ?? 1);

        try {
            $booking = $this->service->holdSlots($userId, $data['slot_ids']);
            return response()->json(['success' => true, 'booking' => $booking], 201);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function pay(Request $request, int $id)
    {
        $data = $request->validate([
            'provider' => 'required|in:vnpay,momo',
            'amount' => 'required|numeric|min:0',
            'meta' => 'array'
        ]);
        try {
            $result = $this->service->payBooking($id, $data['provider'], (float) $data['amount'], $data['meta'] ?? []);
            return response()->json(['success' => true] + $result);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function cancel(int $id)
    {
        $this->service->cancelPending($id);
        return response()->json(['success' => true]);
    }

    public function show(int $id)
    {
        $booking = Booking::with('items.slot.court')->findOrFail($id);
        return response()->json($booking);
    }
}

