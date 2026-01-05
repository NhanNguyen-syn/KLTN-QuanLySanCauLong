<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;

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
            $query->where('status', 'published');
        }

        if (Schema::hasColumn('courts', 'order')) {
            $query->orderBy('order', 'asc');
        }

        $courts = $query
            ->orderBy('id', 'asc')
            ->get()
            ->map(function (Court $court) {
                return [
                    'id' => (string) $court->getKey(),
                    'name' => $court->name,
                    // Giá hiển thị mặc định; giá thực tính khi đặt
                    'price' => 150000,
                    'memberPrice' => 120000,
                    'type' => optional($court->type)->name ?? 'Sân tiêu chuẩn',
                    'icon' => '🏸',
                    'features' => [],
                    'capacity' => 4,
                    'status' => $court->status ?? 'published',
                    'court_status' => optional($court->courtStatus)->name, // active/maintenance/closed
                ];
            });

        return response()->json(['data' => $courts->values()]);
    }
}

