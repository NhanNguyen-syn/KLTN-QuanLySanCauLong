<?php

namespace Botble\ReceptionistPortal\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Models\BookingList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReceptionistDashboardController extends BaseController
{
    /**
     * Display the receptionist dashboard
     */
    public function index(Request $request)
    {
        $this->pageTitle('Cổng Lễ tân - Dashboard');

        Assets::addScriptsDirectly('vendor/core/plugins/receptionist-portal/js/dashboard.js')
            ->addStylesDirectly('vendor/core/plugins/receptionist-portal/css/dashboard.css');

        $today = Carbon::today();

        // Get today's bookings
        $todayBookings = BookingList::whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        // Statistics
        $stats = [
            'total_today' => $todayBookings->count(),
            'checked_in' => $todayBookings->whereIn('status', ['completed', 'paid'])->count(),
            'pending_payment' => $todayBookings->filter(function ($b) {
                return !$b->isFullyPaid() && !in_array($b->status, ['cancelled']);
            })->count(),
            'waiting_checkin' => $todayBookings->where('status', 'confirmed')->count(),
        ];

        // Revenue today
        $stats['revenue_today'] = $todayBookings
            ->whereIn('status', ['completed', 'paid'])
            ->sum('paid_amount');

        // Upcoming bookings (next 2 hours) - Exclude checked-in/completed/cancelled
        $upcomingBookings = $todayBookings->filter(function ($booking) {
            if (in_array($booking->status, ['confirmed', 'completed', 'cancelled'])) {
                return false;
            }
            $startTime = Carbon::parse($booking->date->format('Y-m-d') . ' ' . $booking->start_time);
            $now = Carbon::now();
            return $startTime->isFuture() && $startTime->diffInMinutes($now) <= 120;
        });

        // Pending payments (All bookings today that are NOT fully paid and NOT cancelled)
        $pendingPayments = $todayBookings->filter(function ($booking) {
            return !$booking->isFullyPaid() && !in_array($booking->status, ['cancelled']);
        });

        return view('plugins/receptionist-portal::dashboard', compact(
            'todayBookings',
            'stats',
            'upcomingBookings',
            'pendingPayments'
        ));
    }

    /**
     * Get today's bookings via AJAX
     */
    public function getTodayBookings(Request $request): JsonResponse
    {
        $today = Carbon::today();
        $status = $request->input('status');

        $query = BookingList::whereDate('date', $today)->orderBy('start_time');

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->get();

        return response()->json([
            'success' => true,
            'data' => $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'order_code' => $booking->order_code,
                    'court_name' => $booking->court_name,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'customer_name' => $booking->customer_name,
                    'contact' => $booking->contact,
                    'status' => $booking->status,
                    'price' => $booking->price,
                    'paid_amount' => $booking->paid_amount,
                    'remaining' => $booking->remaining_amount,
                    'services_total' => $booking->services_total ?? 0,
                    'grand_total' => $booking->grand_total,
                ];
            }),
        ]);
    }

    /**
     * Get pending payments via AJAX
     */
    public function getPendingPayments(): JsonResponse
    {
        $today = Carbon::today();

        // We can't easily filter by computed properties in SQL, so get potential candidates and filter in PHP
        // Get all active bookings for today
        $activeBookings = BookingList::whereDate('date', $today)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('start_time')
            ->get();

        $pending = $activeBookings->filter(function ($booking) {
            return !$booking->isFullyPaid();
        })->values();

        return response()->json([
            'success' => true,
            'data' => $pending,
        ]);
    }

    /**
     * Check-in a booking
     */
    public function checkin(BookingList $booking): JsonResponse
    {
        if ($booking->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Đơn đã bị hủy, không thể check-in.',
            ], 400);
        }

        $booking->update([
            'status' => 'confirmed',
            'notes' => ($booking->notes ?? '') . "\n[Check-in: " . Carbon::now()->format('H:i d/m/Y') . "]",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in thành công!',
            'booking' => $booking->fresh(),
        ]);
    }

    /**
     * Check-out a booking (mark as completed)
     */
    public function checkout(BookingList $booking): JsonResponse
    {
        if (!$booking->isFullyPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn chưa thanh toán đủ. Vui lòng thanh toán trước khi check-out.',
                'remaining' => $booking->remaining_amount,
            ], 400);
        }

        $booking->update([
            'status' => 'completed',
            'notes' => ($booking->notes ?? '') . "\n[Check-out: " . Carbon::now()->format('H:i d/m/Y') . "]",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out thành công!',
            'booking' => $booking->fresh(),
        ]);
    }

    /**
     * Process payment for a booking
     */
    public function processPayment(Request $request, BookingList $booking): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,card',
        ]);

        $amount = (float) $request->input('amount');
        $newPaidAmount = ($booking->paid_amount ?? 0) + $amount;

        $booking->update([
            'paid_amount' => $newPaidAmount,
            'status' => $newPaidAmount >= $booking->grand_total ? 'paid' : $booking->status,
            'notes' => ($booking->notes ?? '') . "\n[Thanh toán: " . number_format($amount) . "đ - " . strtoupper($request->payment_method) . " - " . Carbon::now()->format('H:i d/m/Y') . "]",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thanh toán thành công!',
            'booking' => $booking->fresh(),
            'is_fully_paid' => $newPaidAmount >= $booking->grand_total,
        ]);
    }
}
