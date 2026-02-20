<?php

namespace Botble\AiChatbot\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelExpiredBookingsCommand extends Command
{
    protected $signature = 'chatbot:cancel-expired';
    protected $description = 'Cancel chatbot bookings that have expired (15 min unpaid)';

    public function handle(): int
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        // Find chatbot bookings with expires_at in notes
        $expiredBookings = DB::table('court_bookings_list')
            ->where('status', 'processing')
            ->where('notes', 'LIKE', 'chatbot_booking|expires_at:%')
            ->get(['id', 'order_code', 'notes']);

        $cancelledCount = 0;

        foreach ($expiredBookings as $booking) {
            // Parse expires_at from notes: "chatbot_booking|expires_at:2026-02-13 19:30:00"
            if (preg_match('/expires_at:(.+)$/', $booking->notes, $matches)) {
                $expiresAt = trim($matches[1]);
                if ($expiresAt <= $now) {
                    // Cancel all items with this order_code
                    DB::table('court_bookings_list')
                        ->where('order_code', $booking->order_code)
                        ->where('status', 'processing')
                        ->update([
                            'status' => 'cancelled',
                            'notes' => $booking->notes . '|auto_cancelled:' . $now,
                            'updated_at' => $now,
                        ]);
                    $cancelledCount++;
                    $this->info("Cancelled: {$booking->order_code}");
                }
            }
        }

        $this->info("Done. Cancelled {$cancelledCount} expired booking(s).");
        return self::SUCCESS;
    }
}
