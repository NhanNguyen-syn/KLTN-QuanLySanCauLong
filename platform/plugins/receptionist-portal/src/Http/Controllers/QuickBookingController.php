<?php

namespace Botble\ReceptionistPortal\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Models\BookingList;
use Botble\CourtBooking\Models\Court;
use Botble\CourtBooking\Models\Service;
use Botble\CourtBooking\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class QuickBookingController extends BaseController
{
    protected BookingService $bookingService;

    // Slot interval in minutes
    const SLOT_INTERVAL = 30;

    // Operating hours
    const OPEN_HOUR = 5;  // 5:00 AM
    const CLOSE_HOUR = 23; // 11:00 PM

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Show quick booking with time slot grid
     */
    public function index(Request $request)
    {
        $this->pageTitle('Đặt sân nhanh');

        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $courts = Court::where('status', 'published')
            ->orderBy('name')
            ->get();

        // Generate time slots
        $timeSlots = $this->generateTimeSlots();

        // Get booked slots for the date
        $bookedSlots = $this->getBookedSlots($date);

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get();

        return view('plugins/receptionist-portal::quick-booking', compact(
            'courts',
            'timeSlots',
            'bookedSlots',
            'services',
            'date'
        ));
    }

    /**
     * Generate time slots based on interval
     */
    private function generateTimeSlots(): array
    {
        $slots = [];
        $start = Carbon::createFromTime(self::OPEN_HOUR, 0);
        $end = Carbon::createFromTime(self::CLOSE_HOUR, 0);

        while ($start < $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(self::SLOT_INTERVAL);
        }

        return $slots;
    }

    /**
     * Get booked slots for a specific date
     */
    private function getBookedSlots(string $date): array
    {
        $bookings = BookingList::whereDate('date', $date)
            ->whereNotIn('status', ['cancelled', 'canceled'])
            ->get(['court_id', 'start_time', 'end_time', 'customer_name', 'status']);

        $bookedSlots = [];

        foreach ($bookings as $booking) {
            $courtId = $booking->court_id;
            $start = Carbon::parse($date . ' ' . $booking->start_time);
            $end = Carbon::parse($date . ' ' . $booking->end_time);

            // Mark all slots within the booking range
            $current = clone $start;
            while ($current < $end) {
                $slotKey = $current->format('H:i');
                if (!isset($bookedSlots[$courtId])) {
                    $bookedSlots[$courtId] = [];
                }
                $bookedSlots[$courtId][$slotKey] = [
                    'status' => $booking->status,
                    'customer' => $booking->customer_name,
                ];
                $current->addMinutes(self::SLOT_INTERVAL);
            }
        }

        return $bookedSlots;
    }

    /**
     * Get slots for a date via AJAX
     */
    public function getSlots(Request $request): JsonResponse
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $bookedSlots = $this->getBookedSlots($date);

        return response()->json([
            'success' => true,
            'date' => $date,
            'bookedSlots' => $bookedSlots,
        ]);
    }

    /**
     * Check availability via AJAX
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $result = $this->bookingService->checkBookingListAvailability(
            (int) $request->court_id,
            $request->date,
            $request->start_time,
            $request->end_time
        );

        return response()->json([
            'success' => true,
            'available' => $result['available'],
            'conflicts' => $result['conflicts'],
        ]);
    }

    /**
     * Store new quick booking
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
            'slots' => 'required|array|min:1',
            'customer_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'paid_amount' => 'nullable|numeric|min:0',
            'services' => 'nullable|array',
        ]);

        $court = Court::find($request->court_id);
        $slots = collect($request->slots)->sort()->values();

        // Calculate start and end time from selected slots
        $startTime = $slots->first();
        $lastSlot = Carbon::createFromFormat('H:i', $slots->last());
        $endTime = $lastSlot->addMinutes(self::SLOT_INTERVAL)->format('H:i');

        // Check availability again (race condition protection)
        $availability = $this->bookingService->checkBookingListAvailability(
            (int) $request->court_id,
            $request->date,
            $startTime,
            $endTime
        );

        if (!$availability['available']) {
            return response()->json([
                'success' => false,
                'message' => 'Một hoặc nhiều slot đã được đặt. Vui lòng chọn lại.',
                'conflicts' => $availability['conflicts'],
            ], 409);
        }

        $slotCount = $slots->count();
        // Standardize price: 70,000 VND per 30min slot (140,000 VND/hour)
        // Discount 15%: 60,000 VND per 30min slot (120,000 VND/hour) for >= 4 slots
        $pricePerSlot = $slotCount >= 4 ? 60000 : 70000;
        $totalPrice = $slotCount * $pricePerSlot;

        // Create booking
        $booking = BookingList::create([
            'order_code' => $this->generateOrderCode(),
            'court_id' => $request->court_id,
            'court_name' => $court->name,
            'date' => $request->date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'customer_name' => $request->customer_name,
            'contact' => $request->contact,
            'price' => $totalPrice,
            'paid_amount' => $request->paid_amount ?? 0,
            'status' => ($request->paid_amount ?? 0) >= $totalPrice ? 'paid' : 'processing',
            'notes' => '[Đặt tại quầy: ' . Carbon::now()->format('H:i d/m/Y') . '] - ' . $slotCount . ' slot(s)',
        ]);

        // Add services if any
        if ($request->has('services')) {
            foreach ($request->services as $serviceData) {
                if (!empty($serviceData['id']) && !empty($serviceData['quantity']) && $serviceData['quantity'] > 0) {
                    $service = Service::find($serviceData['id']);
                    if ($service) {
                        $booking->addService($service, $serviceData['quantity']);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Đặt sân thành công! Mã đơn: ' . $booking->order_code,
            'booking' => $booking->fresh(),
        ]);
    }

    /**
     * Generate unique order code
     */
    private function generateOrderCode(): string
    {
        return DB::transaction(function () {
            $prefix = 'BD-' . Carbon::now()->format('Ymd') . '-';
            $latest = BookingList::query()
                ->where('order_code', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderBy('order_code', 'desc')
                ->value('order_code');

            $nextSeq = 1;
            if ($latest) {
                $lastSeqStr = substr($latest, strrpos($latest, '-') + 1);
                $nextSeq = ((int) $lastSeqStr) + 1;
            }

            return $prefix . str_pad((string) $nextSeq, 3, '0', STR_PAD_LEFT);
        });
    }
}
