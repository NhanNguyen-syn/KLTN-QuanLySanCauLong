<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\CourtSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends BaseController
{
    public function index(Request $request)
    {
        $date = $request->get('date');

        // If no date is provided, return empty
        if (!$date) {
            return response()->json(['data' => []]);
        }

        // 1. Generate a full grid of time slots for all active courts.
        $allCourts = \Botble\CourtBooking\Models\Court::query()->where('status', 'published')->get(['id', 'name']);
        // Sinh các mốc thời gian 30-phút, từ 05:00 tới 22:30 (bao gồm cả 22:30)
        // range() cần +30 phút để lấy thêm mốc 22:30 (22*60 + 30 = 1350)
        $times = collect(range(5 * 60, 22 * 60 + 30, 30))
            ->map(fn($m) => sprintf('%02d:%02d', intdiv($m, 60), $m % 60));

        $availabilityGrid = collect();

        foreach ($allCourts as $court) {
            foreach ($times as $time) {
                $start = Carbon::parse("{$date} {$time}", 'Asia/Ho_Chi_Minh');
                $availabilityGrid->push((object) [
                    'court_id' => $court->id,
                    'court'    => $court,
                    'start_at' => $start,
                    'end_at'   => $start->copy()->addMinutes(30),
                    'status'   => 'available', // Default to available
                ]);
            }
        }

        // 2. Lấy các slot đã được đặt thực sự trong DB của NGÀY đang yêu cầu.
        if (Schema::hasTable('court_bookings_list')) {
            $bookedSlots = DB::table('court_bookings_list')
                ->whereDate('date', $date) // dùng whereDate để so khớp đúng ngày & tối ưu index
                ->where(function ($query) {
                    $query->whereIn('status', ['paid', 'completed', 'confirmed'])
                          ->orWhere(function ($sub) {
                              $sub->where('status', 'processing')
                                  ->where('created_at', '>=', now()->subMinutes(15));
                          });
                })
                ->get();

            // 3. Đánh dấu tương ứng trong grid là "booked".
            foreach ($bookedSlots as $booking) {
                // Sử dụng Carbon::parse để tự động nhận diện định dạng (H:i hoặc H:i:s) tránh lỗi parse
                $bookingStart = Carbon::parse("{$booking->date} {$booking->start_time}", 'Asia/Ho_Chi_Minh');
                $bookingEnd   = Carbon::parse("{$booking->date} {$booking->end_time}",   'Asia/Ho_Chi_Minh');

                // Nếu vì lý do nào đó parse thất bại thì bỏ qua booking này để tránh đánh dấu sai
                if (!$bookingStart || !$bookingEnd) {
                    continue;
                }

                $availabilityGrid = $availabilityGrid->map(function ($slot) use ($booking, $bookingStart, $bookingEnd) {
                    if (
                        $slot->court_id === (int) $booking->court_id &&
                        $slot->start_at >= $bookingStart &&
                        $slot->start_at <  $bookingEnd
                    ) {
                        $slot->status = $booking->status === 'processing' ? 'processing' : 'booked';
                    }
                    return $slot;
                });
            }
        }

        // 4. Chuẩn hoá dữ liệu trả về thành chuỗi thuần để tránh lệch múi giờ khi JSON hoá.
        $response = $availabilityGrid->map(function ($slot) {
            return [
                'court_id'    => $slot->court_id,
                'court'       => $slot->court, // giữ lại thông tin sân (id, name)
                'date'        => $slot->start_at->format('Y-m-d'),
                // Giữ nguyên trường start_time & end_time (HH:mm) cho tiện hiển thị nhanh
                'start_time'  => $slot->start_at->format('H:i'),
                'end_time'    => $slot->end_at->format('H:i'),
                // Thêm start_at dạng Y-m-d H:i:s để frontend có thể parse Date nhanh chóng
                'start_at'    => $slot->start_at->format('Y-m-d H:i:s'),
                'status'      => $slot->status,
            ];
        })->values();

        return response()->json(['data' => $response]);
    }
}

