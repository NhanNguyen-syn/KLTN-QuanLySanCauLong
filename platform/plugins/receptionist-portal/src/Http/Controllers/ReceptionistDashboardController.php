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

        // Support date picker: use ?date= query param, default to today
        $selectedDate = $request->input('date')
            ? Carbon::parse($request->input('date'))->startOfDay()
            : Carbon::today();

        // Get bookings for selected date
        $todayBookings = BookingList::whereDate('date', $selectedDate)
            ->orderBy('start_time')
            ->get();

        // Group bookings by order_code for batch operations
        $groupedBookings = $todayBookings->groupBy('order_code');

        // Statistics
        $stats = [
            'total_today' => $todayBookings->count(),
            'checked_in' => $todayBookings->whereIn('status', ['completed', 'paid'])->count(),
            'pending_payment' => $todayBookings->filter(function ($b) {
                return !$b->isFullyPaid() && !in_array($b->status, ['cancelled']);
            })->count(),
            'waiting_checkin' => $todayBookings->whereIn('status', ['pending', 'processing'])->count(),
        ];

        // Revenue for selected date
        $stats['revenue_today'] = $todayBookings
            ->whereIn('status', ['completed', 'paid'])
            ->sum('paid_amount');

        // Upcoming bookings (next 2 hours) - only relevant for today
        $upcomingBookings = collect();
        if ($selectedDate->isToday()) {
            $upcomingBookings = $todayBookings->filter(function ($booking) {
                if (in_array($booking->status, ['confirmed', 'completed', 'cancelled'])) {
                    return false;
                }
                $startTime = Carbon::parse($booking->date->format('Y-m-d') . ' ' . $booking->start_time);
                $now = Carbon::now();
                return $startTime->isFuture() && $startTime->diffInMinutes($now) <= 120;
            });
        }

        // Pending payments (All bookings that are NOT fully paid and NOT cancelled)
        $pendingPayments = $todayBookings->filter(function ($booking) {
            return !$booking->isFullyPaid() && !in_array($booking->status, ['cancelled']);
        });

        return view('plugins/receptionist-portal::dashboard', compact(
            'todayBookings',
            'groupedBookings',
            'stats',
            'upcomingBookings',
            'pendingPayments',
            'selectedDate'
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
     * Batch check-in: check-in all bookings with the same order_code
     */
    public function batchCheckin(Request $request): JsonResponse
    {
        $request->validate(['order_code' => 'required|string']);
        $orderCode = $request->input('order_code');

        $bookings = BookingList::where('order_code', $orderCode)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hợp lệ để check-in.',
            ], 400);
        }

        $timestamp = Carbon::now()->format('H:i d/m/Y');
        foreach ($bookings as $booking) {
            $booking->update([
                'status' => 'confirmed',
                'notes' => ($booking->notes ?? '') . "\n[Check-in: {$timestamp}]",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check-in thành công cho ' . $bookings->count() . ' mục!',
        ]);
    }

    /**
     * Check-out a booking (mark as completed)
     */
    public function checkout(BookingList $booking): JsonResponse
    {
        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn không thể check-out.',
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
     * Batch check-out: check-out all bookings with the same order_code
     */
    public function batchCheckout(Request $request): JsonResponse
    {
        $request->validate(['order_code' => 'required|string']);
        $orderCode = $request->input('order_code');

        $bookings = BookingList::where('order_code', $orderCode)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hợp lệ để check-out.',
            ], 400);
        }

        // No longer require full payment for checkout

        $timestamp = Carbon::now()->format('H:i d/m/Y');
        foreach ($bookings as $booking) {
            $booking->update([
                'status' => 'completed',
                'notes' => ($booking->notes ?? '') . "\n[Check-out: {$timestamp}]",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check-out thành công cho ' . $bookings->count() . ' mục!',
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

        $newStatus = $booking->status;
        if ($newPaidAmount >= $booking->grand_total && in_array($booking->status, ['pending', 'processing'])) {
            $newStatus = 'paid';
        }

        $booking->update([
            'paid_amount' => $newPaidAmount,
            'status' => $newStatus,
            'notes' => ($booking->notes ?? '') . "\n[Thanh toán: " . number_format($amount) . "đ - " . strtoupper($request->payment_method) . " - " . Carbon::now()->format('H:i d/m/Y') . "]",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thanh toán thành công!',
            'booking' => $booking->fresh(),
            'is_fully_paid' => $newPaidAmount >= $booking->grand_total,
        ]);
    }

    /**
     * Batch payment: pay for all bookings with the same order_code at once
     */
    public function batchPayment(Request $request): JsonResponse
    {
        $request->validate([
            'order_code' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,card',
        ]);

        $orderCode = $request->input('order_code');
        $totalAmount = (float) $request->input('amount');
        $paymentMethod = $request->input('payment_method');

        $bookings = BookingList::where('order_code', $orderCode)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hợp lệ.',
            ], 400);
        }

        // Calculate total remaining across all bookings
        $totalRemaining = $bookings->sum(fn($b) => $b->remaining_amount);

        if ($totalAmount > $totalRemaining) {
            $totalAmount = $totalRemaining; // Cap at remaining
        }

        // Distribute payment completely greedily across bookings
        $amountLeftToAllocate = $totalAmount;
        $allocatedSoFar = 0;
        $timestamp = Carbon::now()->format('H:i d/m/Y');
        $count = $bookings->count();

        foreach ($bookings as $booking) {
            if ($amountLeftToAllocate <= 0) break;
            
            $remaining = $booking->remaining_amount;
            if ($remaining <= 0) continue;

            $alloc = min($remaining, $amountLeftToAllocate);
            $amountLeftToAllocate -= $alloc;
            $allocatedSoFar += $alloc;

            $newPaidAmount = ($booking->paid_amount ?? 0) + $alloc;
            
            $newStatus = $booking->status;
            if ($newPaidAmount >= $booking->grand_total && in_array($booking->status, ['pending', 'processing'])) {
                $newStatus = 'paid';
            }

            $booking->update([
                'paid_amount' => $newPaidAmount,
                'status' => $newStatus,
                'notes' => ($booking->notes ?? '') . "\n[Thanh toán: " . number_format($alloc) . "đ - " . strtoupper($paymentMethod) . " - {$timestamp}]",
            ]);
        }

        // Check if all bookings are now fully paid
        $allPaid = $bookings->fresh()->every(fn($b) => $b->isFullyPaid());

        return response()->json([
            'success' => true,
            'message' => 'Thanh toán thành công ' . number_format($allocatedSoFar) . 'đ cho ' . $count . ' mục!',
            'all_paid' => $allPaid,
        ]);
    }
}
