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

class QuickBookingController extends BaseController
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Show quick booking form
     */
    public function index(Request $request)
    {
        $this->pageTitle('Đặt sân nhanh');

        Assets::addScriptsDirectly('vendor/core/plugins/receptionist-portal/js/quick-booking.js')
            ->addStylesDirectly('vendor/core/plugins/receptionist-portal/css/dashboard.css');

        $courts = Court::where('status', 'published')
            ->orderBy('name')
            ->get(['id', 'name']);

        $services = Service::active()
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get();

        $today = Carbon::today()->format('Y-m-d');

        return view('plugins/receptionist-portal::quick-booking', compact(
            'courts',
            'services',
            'today'
        ));
    }

    /**
     * Check availability via AJAX
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'customer_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'services' => 'nullable|array',
            'services.*.id' => 'exists:services,id',
            'services.*.quantity' => 'integer|min:1',
        ]);

        // Check availability again (race condition protection)
        $availability = $this->bookingService->checkBookingListAvailability(
            (int) $request->court_id,
            $request->date,
            $request->start_time,
            $request->end_time
        );

        if (!$availability['available']) {
            return response()->json([
                'success' => false,
                'message' => 'Khung giờ này đã được đặt. Vui lòng chọn giờ khác.',
                'conflicts' => $availability['conflicts'],
            ], 409);
        }

        $court = Court::find($request->court_id);

        // Create booking
        $booking = BookingList::create([
            'order_code' => $this->generateOrderCode(),
            'court_id' => $request->court_id,
            'court_name' => $court->name,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'customer_name' => $request->customer_name,
            'contact' => $request->contact,
            'price' => $request->price,
            'paid_amount' => $request->paid_amount ?? 0,
            'status' => ($request->paid_amount ?? 0) >= $request->price ? 'paid' : 'pending',
            'notes' => '[Đặt tại quầy: ' . Carbon::now()->format('H:i d/m/Y') . ']',
        ]);

        // Add services if any
        if ($request->has('services')) {
            foreach ($request->services as $serviceData) {
                $service = Service::find($serviceData['id']);
                if ($service) {
                    $booking->addService($service, $serviceData['quantity'] ?? 1);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Đặt sân thành công!',
            'booking' => $booking->fresh()->load('bookingServices.service'),
        ]);
    }

    /**
     * Generate unique order code
     */
    private function generateOrderCode(): string
    {
        $prefix = 'LT' . Carbon::now()->format('ymd');
        do {
            $code = $prefix . strtoupper(Str::random(4));
        } while (BookingList::where('order_code', $code)->exists());
        return $code;
    }
}
