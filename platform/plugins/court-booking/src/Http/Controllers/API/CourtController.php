<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\Court;
use Botble\CourtBooking\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
use Botble\Base\Enums\BaseStatusEnum;
use RvMedia;

class CourtController extends BaseController
{
    public function index(Request $request)
    {
        // Nếu bảng chưa tồn tại (chưa migrate) thì trả về mảng rỗng để frontend vẫn render được
        if (!Schema::hasTable('courts')) {
            return response()->json(['data' => []]);
        }

        $query = Court::query()->with(['type', 'courtStatus']);

        // Tránh lỗi SQL khi thiếu cột do môi trường chưa chạy hết migration
        if (Schema::hasColumn('courts', 'status')) {
            $query->where('status', BaseStatusEnum::PUBLISHED);
        }

        if (Schema::hasColumn('courts', 'order')) {
            $query->orderBy('order', 'asc');
        }

        // Lấy time slots để hiển thị
        $timeSlots = TimeSlot::query()->orderBy('start_time')->get();

        $courts = $query
            ->orderBy('id', 'asc')
            ->get()
            ->map(function (Court $court) use ($timeSlots) {
                // Lấy image URL nếu có
                $imageUrl = null;
                if ($court->image) {
                    $imageUrl = class_exists('RvMedia')
                        ? RvMedia::getImageUrl($court->image)
                        : asset('storage/' . $court->image);
                }

                return [
                    'id' => (string) $court->getKey(),
                    'name' => $court->name,
                    // Lấy giá từ database thay vì hardcode
                    'price' => (float) ($court->default_price ?? 150000),
                    'memberPrice' => (float) ($court->member_price ?? 120000),
                    'type' => optional($court->type)->name ?? 'Sân tiêu chuẩn',
                    'icon' => '🏸',
                    'features' => [],
                    'capacity' => 4,
                    'status' => $court->status ?? 'published',
                    'court_status' => optional($court->courtStatus)->name,
                    // Thêm các fields mới
                    'location' => $court->location,
                    'address' => $court->address ?? $court->location,
                    'image' => $imageUrl,
                    'booking_url' => $court->booking_url ?? '/dat-san',
                    // Trả về time slots
                    'time_slots' => $timeSlots->map(function ($slot) {
                        return [
                            'id' => $slot->id,
                            'label' => $slot->label,
                            'start_time' => $slot->start_time,
                            'end_time' => $slot->end_time,
                        ];
                    })->take(2)->values(), // Chỉ lấy 2 slots đầu để hiển thị trên card
                ];
            });

        return response()->json(['data' => $courts->values()]);
    }
}

