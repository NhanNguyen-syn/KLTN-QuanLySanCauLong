<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\CourtBooking\Models\BookingList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookingListController extends BaseController
{
    public function store(Request $request)
    {
        // Ghi log để xác nhận API được gọi
        Log::info('[BOOKING LIST STORE] hit', ['payload' => $request->all()]);

        // VALIDATE (court_id có thể null vì dữ liệu front-end có thể chỉ có court_name)
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.court_id'   => 'nullable|integer',
            'items.*.court_name' => 'nullable|string',
            'items.*.date'       => 'required|date',
            'items.*.start_time' => 'required',
            'items.*.end_time'   => 'required',
            'items.*.price'      => 'nullable|numeric',
            'customer_name'      => 'nullable|string',
            'contact'            => 'nullable|string',
            'notes'              => 'nullable|string',
            'paid_amount'        => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            Log::warning('[BOOKING LIST VALIDATION FAILED]', [
                'errors' => $validator->errors()->toArray(),
                'payload' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'VALIDATION_FAILED',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $items = $validator->validated()['items'];

            // Bắt đầu transaction TRƯỚC khi tạo mã để lockForUpdate có hiệu lực
            DB::beginTransaction();

            // Lấy ngày của đơn hàng (theo item đầu tiên) để tạo mã BD-YYYYMMDD-XXX
            $dateForOrder = Carbon::parse($items[0]['date']);
            $orderCode = $this->generateSequentialOrderCodeForDate($dateForOrder);

            // TÍNH PHÂN BỔ TIỀN CỌC THEO TỶ LỆ GIÁ TRỊ TỪNG MỤC
            $totalPrice = collect($items)->sum(fn($it) => (float)($it['price'] ?? 0));
            $totalPaid  = (float) $request->input('paid_amount', 0);
            $allocatedSoFar = 0.0;

            foreach ($items as $idx => $item) {
                $price = (float) ($item['price'] ?? 0);

                // Nếu là item cuối: nhận phần còn lại để đảm bảo tổng đúng
                if ($idx === array_key_last($items)) {
                    $allocated = max(0, round($totalPaid - $allocatedSoFar, 2));
                } else {
                    // Phân bổ theo tỷ lệ
                    $allocated = $totalPrice > 0 ? round($totalPaid * ($price / $totalPrice), 2) : 0;
                    $allocatedSoFar += $allocated;
                }

                BookingList::create([
                    'order_code'      => $orderCode,
                    'court_id'        => $item['court_id'] ?? null,
                    'court_name'      => $item['court_name'] ?? null,
                    'date'            => $item['date'],
                    'start_time'      => $item['start_time'],
                    'end_time'        => $item['end_time'],
                    'status'          => 'processing',
                    'customer_name'   => $request->input('customer_name'),
                    'contact'         => $request->input('contact'),
                    'price'           => $price,
                    'paid_amount'     => $allocated,
                    'notes'           => $request->input('notes'),
                    'invoice_created_at' => null,
                    'invoice_updated_at' => null,
                ]);
            }

            DB::commit();

            return response()->json([
                'success'    => true,
                'order_code' => $orderCode,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            // LOG lỗi
            Log::error('[BOOKING LIST ERROR]', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi tạo booking',
            ], 500);
        }
    }

    protected function generateSequentialOrderCodeForDate(Carbon $date): string
    {
        $prefix = 'BD-' . $date->format('Ymd') . '-'; // Format: BD-YYYYMMDD-

        // Khóa hàng để tránh trùng số khi nhiều request cùng lúc
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
    }
}

