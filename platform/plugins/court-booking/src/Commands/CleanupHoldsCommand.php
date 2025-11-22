<?php

namespace Botble\CourtBooking\Commands;

use Botble\CourtBooking\Models\{Booking, BookingHold, CourtSlot};
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupHoldsCommand extends Command
{
    protected $signature = 'holds:cleanup';
    protected $description = 'Release expired holds and cancel pending bookings when TTL is over';

    public function handle(): int
    {
        $now = Carbon::now();
        $expiredHolds = BookingHold::where('expires_at', '<', $now)->get();
        $slotIds = $expiredHolds->pluck('court_slot_id')->all();

        DB::transaction(function () use ($slotIds, $now) {
            if ($slotIds) {
                CourtSlot::whereIn('id', $slotIds)->update(['status' => 'available']);
                BookingHold::whereIn('court_slot_id', $slotIds)->delete();
            }
            Booking::where('status', 'pending')->whereNotNull('held_until')->where('held_until', '<', $now)
                ->update(['status' => 'cancelled']);
        });

        $this->info('Expired holds cleaned.');
        return self::SUCCESS;
    }
}

