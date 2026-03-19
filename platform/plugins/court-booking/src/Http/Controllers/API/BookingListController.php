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
    public function store(Request $request, \Botble\CourtBooking\Services\BookingService $bookingService)
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
            'email'              => 'nullable|email',
            'notes'              => 'nullable|string',
            'paid_amount'        => 'nullable|numeric',
            'status'             => 'nullable|in:processing,paid,failed,completed',
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
            return \Illuminate\Support\Facades\Cache::lock('court_booking_process', 10)->block(7, function () use ($request, $validator) {
                $items = $validator->validated()['items'];

            $requestedOrderCode = trim((string) $request->input('order_code', ''));
            if ($requestedOrderCode !== '') {
                $existingRows = BookingList::query()
                    ->where('order_code', $requestedOrderCode)
                    ->get(['court_id', 'court_name', 'date', 'start_time', 'end_time', 'price', 'status']);

                if ($existingRows->isNotEmpty()) {
                    $normalizeItem = function (array $item): array {
                        return [
                            'court_id' => $item['court_id'] ?? null,
                            'court_name' => $item['court_name'] ?? null,
                            'date' => (string) ($item['date'] ?? ''),
                            'start_time' => (string) ($item['start_time'] ?? ''),
                            'end_time' => (string) ($item['end_time'] ?? ''),
                            'price' => (float) ($item['price'] ?? 0),
                        ];
                    };

                    $normalizeRow = function (BookingList $row): array {
                        return [
                            'court_id' => $row->court_id,
                            'court_name' => $row->court_name,
                            'date' => (string) $row->date,
                            'start_time' => (string) $row->start_time,
                            'end_time' => (string) $row->end_time,
                            'price' => (float) ($row->price ?? 0),
                        ];
                    };

                    $incoming = array_map($normalizeItem, $items);
                    $stored = $existingRows->map($normalizeRow)->toArray();

                    $makeKey = function (array $item): string {
                        return implode('|', [
                            (string) ($item['court_id'] ?? ''),
                            (string) ($item['court_name'] ?? ''),
                            (string) ($item['date'] ?? ''),
                            (string) ($item['start_time'] ?? ''),
                            (string) ($item['end_time'] ?? ''),
                            number_format((float) ($item['price'] ?? 0), 2, '.', ''),
                        ]);
                    };

                    $incomingKeys = array_map($makeKey, $incoming);
                    $storedKeys = array_map($makeKey, $stored);
                    sort($incomingKeys);
                    sort($storedKeys);

                    $hasFinalStatus = $existingRows->contains(function (BookingList $row): bool {
                        return in_array($row->status, ['paid', 'failed', 'completed'], true);
                    });

                    if ($incomingKeys === $storedKeys) {
                        return response()->json([
                            'success' => true,
                            'order_code' => $requestedOrderCode,
                            'exists' => true,
                        ]);
                    }
                }
            }

            // Bắt đầu transaction TRƯỚC khi tạo mã để lockForUpdate có hiệu lực
            DB::beginTransaction();
            $orderCode = '';
            $requestedOrderCode = trim((string) $request->input('order_code', ''));
            if ($requestedOrderCode !== '') {
                $exists = BookingList::query()
                    ->where('order_code', $requestedOrderCode)
                    ->lockForUpdate()
                    ->exists();

                if (! $exists) {
                    $orderCode = $requestedOrderCode;
                }
            }

            if ($orderCode === '') {
                // Lấy ngày của đơn hàng (theo item đầu tiên) để tạo mã BD-YYYYMMDD-XXX
                $dateForOrder = Carbon::parse($items[0]['date']);
                $orderCode = $this->generateSequentialOrderCodeForDate($dateForOrder);
            }

            // TÍNH PHÂN BỔ TIỀN CỌC THEO TỶ LỆ GIÁ TRỊ TỪNG MỤC
            $totalPrice = collect($items)->sum(fn($it) => (float)($it['price'] ?? 0));
            $totalPaid  = (float) $request->input('paid_amount', 0);
            $allocatedSoFar = 0.0;

            $status = $request->input('status') ?: 'processing';

            // CHECK FOR CONFLICTS BEFORE CREATING ANY RECORDS
            // Query existing bookings in court_bookings_list to detect overlaps
            foreach ($items as $item) {
                $conflictingBookings = BookingList::where('court_id', $item['court_id'])
                    ->whereDate('date', $item['date'])
                    ->where(function ($query) use ($item) {
                        // Overlap condition: StartA < EndB && EndA > StartB
                        $query->where('start_time', '<', $item['end_time'])
                              ->where('end_time', '>', $item['start_time']);
                    })
                    ->whereIn('status', ['processing', 'paid', 'completed', 'confirmed'])
                    ->lockForUpdate()
                    ->first();

                if ($conflictingBookings) {
                    $timeStr = \Carbon\Carbon::createFromFormat('H:i:s', $item['start_time'])->format('H:i') . ' - ' . 
                               \Carbon\Carbon::createFromFormat('H:i:s', $item['end_time'])->format('H:i');
                    throw new \RuntimeException("⚠️ Rất tiếc, Khung giờ {$timeStr} đã bị người khác giữ hoặc đặt trước đó 1 xíu. Vui lòng chọn giờ khác.");
                }
            }

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

                $newItem = BookingList::create([
                    'order_code'      => $orderCode,
                    'court_id'        => $item['court_id'] ?? null,
                    'court_name'      => $item['court_name'] ?? null,
                    'date'            => $item['date'],
                    'start_time'      => $item['start_time'],
                    'end_time'        => $item['end_time'],
                    'status'          => $status,
                    'customer_name'   => $request->input('customer_name'),
                    'contact'         => $request->input('contact'),
                    'email'           => $request->input('email'),
                    'price'           => $price,
                    'paid_amount'     => $allocated,
                    'notes'           => $request->input('notes'),
                    'invoice_created_at' => null,
                    'invoice_updated_at' => null,
                ]);

                // NOTE: court_slots table was removed by migration 2025_12_18_183700
                // Conflict detection now handled by checking existing court_bookings_list records
                // No need to call blockSlotsForBookingList() anymore
            }

            DB::commit();

            // Gửi email hóa đơn:
            // - Bank transfer (payment_method != 'vnpay'): gửi ngay dù status='processing'
            // - VNPay pending (payment_method='vnpay' + status='processing'): SKIP, sẽ gửi khi VNPay callback trả về
            // - VNPay thành công (status='paid'/'completed'): gửi luôn
            $emailSent = false;
            $paymentMethod = $request->input('payment_method', 'bank-transfer');
            $isVnpayPending = ($status === 'processing' && $paymentMethod === 'vnpay');

            if ($request->input('email') && !$isVnpayPending) {
                try {
                    $createdBookings = BookingList::query()
                        ->where('order_code', $orderCode)
                        ->get();
                    error_log('[BOOKING] Calling sendGroupedEmail: order=' . $orderCode . ' email=' . $request->input('email') . ' status=' . $status . ' method=' . $paymentMethod . ' found=' . $createdBookings->count());
                    \Botble\CourtBooking\Services\InvoicePdfService::sendGroupedEmail($createdBookings, $request->input('email'));
                    $emailSent = true;
                    error_log('[BOOKING] sendGroupedEmail completed OK');
                } catch (\Throwable $emailErr) {
                    error_log('[BOOKING EMAIL ERROR] ' . $emailErr->getMessage());
                    \Log::error('[BOOKING EMAIL ERROR]', ['message' => $emailErr->getMessage(), 'trace' => $emailErr->getTraceAsString()]);
                }
            } elseif ($isVnpayPending) {
                error_log('[BOOKING] Skipping email for VNPay pending order=' . $orderCode . ' (status=processing, method=vnpay)');
            }

            return response()->json([
                'success'    => true,
                'order_code' => $orderCode,
                'email_sent' => $emailSent,
            ]);
            }); // End Cache::lock

        } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hệ thống đang xử lý một giao dịch khác cùng lúc, vui lòng thử lại sau vài giây.',
            ], 409);
        } catch (\RuntimeException $e) {
            if (DB::transactionLevel() > 0) { DB::rollBack(); }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 409); // Conflict
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) { DB::rollBack(); }

            // LOG lỗi chi tiết
            Log::error('[BOOKING LIST ERROR]', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile() . ':' . $e->getLine(),
                'trace'   => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi tạo booking: ' . $e->getMessage(),
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
