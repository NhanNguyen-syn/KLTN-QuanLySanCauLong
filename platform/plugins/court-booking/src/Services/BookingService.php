<?php

namespace Botble\CourtBooking\Services;

use Botble\CourtBooking\Models\{Booking, BookingHold, BookingItem, BookingList, CourtSlot, Invoice, Payment};
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    /**
     * Threshold for fixed customer (>= this number of slots = fixed)
     */
    public const FIXED_THRESHOLD = 10;

    /**
     * Hold time in minutes for casual customers
     */
    public const HOLD_TTL_CASUAL = 120; // 2 hours

    /**
     * Hold time in minutes for fixed customers
     */
    public const HOLD_TTL_FIXED = 240; // 4 hours

    /**
     * Priority levels
     */
    public const PRIORITY_CASUAL = 0;
    public const PRIORITY_FIXED = 1;

    /**
     * Determine booking type based on number of slots
     */
    public function determineBookingType(int $slotCount): string
    {
        return $slotCount >= self::FIXED_THRESHOLD ? 'fixed' : 'casual';
    }

    /**
     * Get hold TTL based on booking type
     */
    public function getHoldTtl(string $bookingType): int
    {
        return $bookingType === 'fixed' ? self::HOLD_TTL_FIXED : self::HOLD_TTL_CASUAL;
    }

    /**
     * Get priority level based on booking type
     */
    public function getPriority(string $bookingType): int
    {
        return $bookingType === 'fixed' ? self::PRIORITY_FIXED : self::PRIORITY_CASUAL;
    }

    /**
     * Find alternative available slots when conflict occurs
     */
    public function findAlternativeSlots(int $courtId, string $date, int $limit = 5): Collection
    {
        return CourtSlot::where('court_id', $courtId)
            ->whereDate('date', $date)
            ->where('status', 'available')
            ->orderBy('start_time')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if a time range is available for booking
     * Uses overlap formula: (StartA < EndB) && (EndA > StartB)
     * 
     * @param int $courtId Court ID to check
     * @param string $date Date to check (Y-m-d format)
     * @param string $startTime Start time (H:i format)
     * @param string $endTime End time (H:i format)
     * @param int|null $excludeBookingId Booking ID to exclude from check (for updates)
     * @return array ['available' => bool, 'conflicts' => array]
     */
    public function checkAvailability(
        int $courtId,
        string $date,
        string $startTime,
        string $endTime,
        ?int $excludeBookingId = null
    ): array {
        return DB::transaction(function () use ($courtId, $date, $startTime, $endTime, $excludeBookingId) {
            // Lock for update to prevent race condition
            $conflictingSlots = CourtSlot::where('court_id', $courtId)
                ->whereDate('date', $date)
                ->whereIn('status', ['reserved', 'booked'])
                // Overlap formula: (StartA < EndB) && (EndA > StartB)
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereRaw('start_time < ?', [$endTime])
                        ->whereRaw('end_time > ?', [$startTime]);
                })
                ->lockForUpdate()
                ->get();

            // If excludeBookingId is provided, filter out slots from that booking
            if ($excludeBookingId) {
                $excludeSlotIds = BookingItem::where('booking_id', $excludeBookingId)
                    ->pluck('court_slot_id')
                    ->toArray();
                $conflictingSlots = $conflictingSlots->filter(function ($slot) use ($excludeSlotIds) {
                    return !in_array($slot->id, $excludeSlotIds);
                });
            }

            $conflicts = $conflictingSlots->map(function ($slot) {
                return [
                    'slot_id' => $slot->id,
                    'court_id' => $slot->court_id,
                    'date' => $slot->date,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'status' => $slot->status,
                ];
            })->values()->all();

            return [
                'available' => empty($conflicts),
                'conflicts' => $conflicts,
            ];
        });
    }

    /**
     * Check availability for BookingList (direct booking without slots)
     * Used for receptionist/offline booking flow
     */
    public function checkBookingListAvailability(
        int $courtId,
        string $date,
        string $startTime,
        string $endTime,
        ?int $excludeBookingListId = null
    ): array {
        return DB::transaction(function () use ($courtId, $date, $startTime, $endTime, $excludeBookingListId) {
            $query = \Botble\CourtBooking\Models\BookingList::where('court_id', $courtId)
                ->whereDate('date', $date)
                ->whereNotIn('status', ['cancelled', 'canceled'])
                // Overlap formula: (StartA < EndB) && (EndA > StartB)
                ->where(function ($q) use ($startTime, $endTime) {
                    $q->whereRaw('start_time < ?', [$endTime])
                        ->whereRaw('end_time > ?', [$startTime]);
                });

            if ($excludeBookingListId) {
                $query->where('id', '!=', $excludeBookingListId);
            }

            $conflicts = $query->lockForUpdate()->get();

            return [
                'available' => $conflicts->isEmpty(),
                'conflicts' => $conflicts->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'order_code' => $booking->order_code,
                        'court_name' => $booking->court_name,
                        'date' => $booking->date,
                        'start_time' => $booking->start_time,
                        'end_time' => $booking->end_time,
                        'customer_name' => $booking->customer_name,
                        'status' => $booking->status,
                    ];
                })->values()->all(),
            ];
        });
    }

    /**
     * Check for conflicts and handle priority-based resolution
     * Returns: ['can_book' => bool, 'conflicts' => array, 'alternatives' => Collection]
     */
    public function checkConflictsWithPriority(array $slotIds, string $bookingType): array
    {
        $currentPriority = $this->getPriority($bookingType);
        $conflicts = [];
        $casualHoldsToCancel = [];

        $holds = BookingHold::whereIn('court_slot_id', $slotIds)
            ->where('expires_at', '>', Carbon::now())
            ->get();

        foreach ($holds as $hold) {
            if ($hold->priority >= $currentPriority) {
                // Higher or equal priority - cannot override
                $conflicts[] = [
                    'slot_id' => $hold->court_slot_id,
                    'held_by' => $hold->booking_type,
                    'expires_at' => $hold->expires_at,
                ];
            } else {
                // Lower priority - can override (casual hold, fixed customer booking)
                $casualHoldsToCancel[] = $hold;
            }
        }

        // Get alternatives if there are conflicts
        $alternatives = collect();
        if (!empty($conflicts)) {
            $firstSlot = CourtSlot::find($slotIds[0]);
            if ($firstSlot) {
                $alternatives = $this->findAlternativeSlots($firstSlot->court_id, $firstSlot->date);
            }
        }

        return [
            'can_book' => empty($conflicts),
            'conflicts' => $conflicts,
            'casual_holds_to_cancel' => $casualHoldsToCancel,
            'alternatives' => $alternatives,
        ];
    }

    /**
     * Hold slots with priority-based conflict resolution
     */
    public function holdSlots(int $userId, array $slotIds): array
    {
        return DB::transaction(function () use ($userId, $slotIds) {
            // Determine booking type
            $bookingType = $this->determineBookingType(count($slotIds));
            $holdTtl = $this->getHoldTtl($bookingType);
            $priority = $this->getPriority($bookingType);

            // Check for conflicts
            $conflictCheck = $this->checkConflictsWithPriority($slotIds, $bookingType);

            if (!$conflictCheck['can_book']) {
                return [
                    'success' => false,
                    'error' => 'SLOT_CONFLICT',
                    'message' => 'Một hoặc nhiều slot đã được giữ bởi khách hàng khác.',
                    'conflicts' => $conflictCheck['conflicts'],
                    'alternatives' => $conflictCheck['alternatives'],
                ];
            }

            // Cancel lower priority holds (casual holds when fixed customer books)
            foreach ($conflictCheck['casual_holds_to_cancel'] as $hold) {
                // Get the booking associated with this hold
                $bookingItem = BookingItem::where('court_slot_id', $hold->court_slot_id)->first();
                if ($bookingItem) {
                    $casualBooking = Booking::find($bookingItem->booking_id);
                    if ($casualBooking && $casualBooking->status === 'pending') {
                        // Cancel the casual booking
                        $this->cancelPending($casualBooking->id);
                        // TODO: Send notification to casual customer
                    }
                }
                // Delete the hold
                $hold->delete();
            }

            // Get available slots
            $slots = CourtSlot::whereIn('id', $slotIds)
                ->where('status', 'available')
                ->lockForUpdate()
                ->get();

            if ($slots->count() !== count($slotIds)) {
                return [
                    'success' => false,
                    'error' => 'SLOT_UNAVAILABLE',
                    'message' => 'Một hoặc nhiều slot đã không còn trống.',
                    'alternatives' => $this->findAlternativeSlots(
                        $slots->first()?->court_id ?? 0,
                        $slots->first()?->date ?? now()->toDateString()
                    ),
                ];
            }

            $expiresAt = Carbon::now()->addMinutes($holdTtl);

            // Create booking with type
            $booking = Booking::create([
                'user_id' => $userId,
                'code' => $this->generateBookingCode(),
                'status' => 'pending',
                'held_until' => $expiresAt,
                'booking_type' => $bookingType,
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
                    'booking_type' => $bookingType,
                    'priority' => $priority,
                ]);
            }

            return [
                'success' => true,
                'booking' => $booking->load('items'),
                'booking_type' => $bookingType,
                'hold_expires_at' => $expiresAt,
                'hold_duration_minutes' => $holdTtl,
            ];
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
                return;
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

    /**
     * Block court slots for a BookingList item (Receptionist booking)
     * Throws exception if slots are not available.
     */
    public function blockSlotsForBookingList(BookingList $bookingList): void
    {
        // Find overlapping slots
        $slots = CourtSlot::where('court_id', $bookingList->court_id)
            ->whereDate('date', $bookingList->date)
            ->where(function ($query) use ($bookingList) {
                // Overlap: StartA < EndB && EndA > StartB
                $query->where('start_time', '<', $bookingList->end_time)
                      ->where('end_time', '>', $bookingList->start_time);
            })
            ->lockForUpdate()
            ->get();

        if ($slots->isEmpty()) {
            // Note: If no slots found (e.g. slots not generated yet), we might want to warn
            // but usually slots exist for valid booking dates.
            // For now, proceed (assuming admin knows best or slots will be generated later)
            // Or typically: throw exception "System has not generated slots for this date".
            // Let's log warning but allow (or strict? let's be strict for safety)
            // throw new \RuntimeException('Hệ thống chưa tạo lịch cho ngày này.');
            return; 
        }

        foreach ($slots as $slot) {
            if ($slot->status !== 'available') {
                $timeStr = Carbon::createFromFormat('H:i:s', $slot->start_time)->format('H:i') . ' - ' . 
                           Carbon::createFromFormat('H:i:s', $slot->end_time)->format('H:i');
                throw new \RuntimeException("⚠️ Rất tiếc, Khung giờ {$timeStr} đã bị người khác giữ hoặc đặt trước đó 1 xíu. Vui lòng chọn giờ khác.");
            }
        }

        foreach ($slots as $slot) {
            $slot->status = 'booked'; // Mark as booked immediately
            $slot->save();
        }
    }

    /**
     * Release court slots for a BookingList item (Receptionist cancellation)
     */
    public function releaseSlotsForBookingList(BookingList $bookingList): void
    {
        $slots = CourtSlot::where('court_id', $bookingList->court_id)
            ->whereDate('date', $bookingList->date)
            ->where(function ($query) use ($bookingList) {
                $query->where('start_time', '<', $bookingList->end_time)
                      ->where('end_time', '>', $bookingList->start_time);
            })
            ->lockForUpdate()
            ->get();

        foreach ($slots as $slot) {
            // Only release if reserved/booked
            if (in_array($slot->status, ['booked', 'reserved'])) {
                $slot->status = 'available';
                $slot->save();
            }
        }
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
        $today = Carbon::now()->format('Ymd');
        $prefix = 'BD-' . $today . '-';

        $lastInvoice = Invoice::where('invoice_no', 'like', $prefix . '%')
            ->orderBy('invoice_no', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_no, -3);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
