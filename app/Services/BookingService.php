<?php

namespace App\Services;

use App\Models\{Booking, BookingHold, BookingItem, CourtSlot, Invoice, Payment};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    public int $holdTtlMinutes = 120; // 2 hours

    public function holdSlots(int $userId, array $slotIds): Booking
    {
        return DB::transaction(function () use ($userId, $slotIds) {
            $slots = CourtSlot::whereIn('id', $slotIds)
                ->where('status', 'available')
                ->lockForUpdate()
                ->get();

            if ($slots->count() !== count($slotIds)) {
                throw new \RuntimeException('Một hoặc nhiều slot đã không còn trống.');
            }

            $expiresAt = Carbon::now()->addMinutes($this->holdTtlMinutes);

            // Tạo booking pending
            $booking = Booking::create([
                'user_id' => $userId,
                'code' => $this->generateBookingCode(),
                'status' => 'pending',
                'held_until' => $expiresAt,
            ]);

            foreach ($slots as $slot) {
                $slot->status = 'reserved';
                $slot->save();

                BookingItem::create([
                    'booking_id' => $booking->id,
                    'court_slot_id' => $slot->id,
                    'price' => $slot->base_price ?? 0,
                ]);

                BookingHold::create([
                    'court_slot_id' => $slot->id,
                    'user_id' => $userId,
                    'expires_at' => $expiresAt,
                ]);
            }

            return $booking->load('items');
        });
    }

    public function payBooking(int $bookingId, string $provider, float $amount, array $meta = []): array
    {
        return DB::transaction(function () use ($bookingId, $provider, $amount, $meta) {
            /** @var Booking $booking */
            $booking = Booking::lockForUpdate()->findOrFail($bookingId);
            if ($booking->status !== 'pending') {
                throw new \RuntimeException('Đơn không ở trạng thái chờ thanh toán.');
            }
            if ($booking->held_until && Carbon::parse($booking->held_until)->isPast()) {
                throw new \RuntimeException('Giữ chỗ đã hết hạn.');
            }

            $booking->load('items');
            $slotIds = $booking->items->pluck('court_slot_id')->all();

            $slots = CourtSlot::whereIn('id', $slotIds)->lockForUpdate()->get();
            foreach ($slots as $slot) {
                if ($slot->status !== 'reserved') {
                    throw new \RuntimeException('Slot không còn ở trạng thái giữ chỗ.');
                }
            }

            $total = (float) $booking->items->sum('price');

            // Lưu payment (giả lập đã thanh toán thành công). Tích hợp VNPay/MoMo sẽ cập nhật ở đây.
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'provider' => strtolower($provider),
                'amount' => $amount,
                'status' => 'success',
                'transaction_ref' => $meta['transaction_ref'] ?? null,
                'meta' => $meta,
            ]);

            foreach ($slots as $slot) {
                $slot->status = 'booked';
                $slot->save();
            }

            $booking->update([
                'status' => 'paid',
                'total_amount' => $total,
            ]);

            // Xóa holds
            BookingHold::whereIn('court_slot_id', $slotIds)->delete();

            $invoice = Invoice::create([
                'booking_id' => $booking->id,
                'invoice_no' => $this->generateInvoiceNo(),
                'issued_at' => Carbon::now(),
                'total' => $total,
            ]);

            return [
                'booking' => $booking->fresh('items'),
                'payment' => $payment,
                'invoice' => $invoice,
            ];
        });
    }

    public function cancelPending(int $bookingId): void
    {
        DB::transaction(function () use ($bookingId) {
            /** @var Booking $booking */
            $booking = Booking::lockForUpdate()->findOrFail($bookingId);
            if ($booking->status !== 'pending') {
                return; // nothing
            }

            $booking->load('items');
            $slotIds = $booking->items->pluck('court_slot_id')->all();

            CourtSlot::whereIn('id', $slotIds)
                ->lockForUpdate()
                ->update(['status' => 'available']);

            BookingHold::whereIn('court_slot_id', $slotIds)->delete();

            $booking->update(['status' => 'cancelled']);
        });
    }

    public function generateBookingCode(): string
    {
        $prefix = 'BK' . now()->format('ymd');
        do {
            $code = $prefix . strtoupper(Str::substr(base_convert(bin2hex(random_bytes(5)), 16, 36), 0, 6));
        } while (Booking::where('code', $code)->exists());
        return $code;
    }

    public function generateInvoiceNo(): string
    {
        $prefix = 'INV' . now()->format('ymd');
        do {
            $code = $prefix . strtoupper(Str::substr(base_convert(bin2hex(random_bytes(6)), 16, 36), 0, 8));
        } while (Invoice::where('invoice_no', $code)->exists());
        return $code;
    }
}

