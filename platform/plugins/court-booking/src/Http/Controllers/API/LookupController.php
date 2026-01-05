<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\BookingList;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class LookupController extends BaseController
{
    public function showByOrderCode(Request $request)
    {
        $orderCode = trim((string) $request->query('order_code', ''));

        if ($orderCode === '') {
            return response()->json([
                'success' => false,
                'message' => 'ORDER_CODE_REQUIRED',
            ], 422);
        }

        $items = BookingList::query()
            ->where('order_code', $orderCode)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'NOT_FOUND',
            ], 404);
        }

        $orderInfo = $items->firstWhere(fn ($it) => ! empty($it->customer_name) || ! empty($it->contact))
            ?: $items->first();

        // trạng thái theo mã đơn: đồng bộ theo admin update, lấy từ item đầu
        $status = (string) ($items->first()->status ?? 'processing');

        return response()->json([
            'success' => true,
            'data' => [
                'order_code' => $orderCode,
                'status' => $status,
                'customer_name' => $orderInfo->customer_name,
                'contact' => $orderInfo->contact,
                'notes' => $orderInfo->notes,
                'created_at' => optional($items->min('created_at'))->toDateTimeString(),
                'updated_at' => optional($items->max('updated_at'))->toDateTimeString(),
                'total_price' => (float) $items->sum('price'),
                'total_paid' => (float) $items->sum('paid_amount'),
                'items' => $items->map(function ($it) {
                    return [
                        'court_name' => $it->court_name,
                        'date' => $it->date,
                        'start_time' => $it->start_time,
                        'end_time' => $it->end_time,
                        'price' => (float) $it->price,
                        'paid_amount' => (float) $it->paid_amount,
                    ];
                })->values(),
            ],
        ]);
    }
}

