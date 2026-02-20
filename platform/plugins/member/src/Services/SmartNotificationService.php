<?php

namespace Botble\Member\Services;

use Botble\Member\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SmartNotificationService
{
    public function queueNotification(
        Member $member,
        string $type,
        string $title,
        string $message,
        array $data = [],
        string $priority = 'medium',
        Carbon $scheduledFor = null
    ): void {
        // Check member preferences
        $prefs = DB::table('notification_preferences')
            ->where('member_id', $member->id)
            ->first();

        if (!$prefs) {
            $this->createDefaultPreferences($member->id);
            $prefs = DB::table('notification_preferences')
                ->where('member_id', $member->id)
                ->first();
        }

        $subscriptions = json_decode($prefs->subscriptions, true);

        // Check if subscribed to this type
        if (!($subscriptions[$type] ?? true)) {
            return;
        }

        // Queue email if enabled
        if ($prefs->email_enabled) {
            DB::table('notification_queue')->insert([
                'member_id' => $member->id,
                'type' => $type,
                'channel' => 'email',
                'title' => $title,
                'message' => $message,
                'data' => json_encode($data),
                'priority' => $priority,
                'status' => 'pending',
                'scheduled_for' => $scheduledFor ?? now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    protected function createDefaultPreferences(int $memberId): void
    {
        DB::table('notification_preferences')->insert([
            'member_id' => $memberId,
            'email_enabled' => true,
            'sms_enabled' => false,
            'push_enabled' => true,
            'subscriptions' => json_encode([
                'booking_reminder' => true,
                'promotional' => true,
                'weather_alert' => true,
                'court_updates' => true,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function sendPendingNotifications(): int
    {
        $notifications = DB::table('notification_queue')
            ->where('status', 'pending')
            ->where('scheduled_for', '<=', now())
            ->orderBy('priority', 'desc')
            ->limit(100)
            ->get();

        $sentCount = 0;

        foreach ($notifications as $notification) {
            try {
                $this->sendNotification($notification);

                DB::table('notification_queue')
                    ->where('id', $notification->id)
                    ->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);

                $sentCount++;
            } catch (\Exception $e) {
                DB::table('notification_queue')
                    ->where('id', $notification->id)
                    ->update([
                        'status' => 'failed',
                        'error' => $e->getMessage(),
                    ]);
            }
        }

        return $sentCount;
    }

    protected function sendNotification($notification): void
    {
        $member = Member::find($notification->member_id);

        if (!$member) {
            throw new \Exception('Member not found');
        }

        if ($notification->channel === 'email') {
            Mail::send([], [], function ($message) use ($member, $notification) {
                $message->to($member->email, $member->name)
                    ->subject($notification->title)
                    ->html($notification->message);
            });
        }
    }

    public function scheduleBookingReminder(int $memberId, int $bookingId, Carbon $bookingTime): void
    {
        $member = Member::find($memberId);

        if (!$member) {
            return;
        }

        // Send reminder 24 hours before booking
        $reminderTime = $bookingTime->copy()->subHours(24);

        $this->queueNotification(
            $member,
            'booking_reminder',
            'Nhắc nhở đặt sân',
            "Xin chào {$member->first_name}, bạn có lịch đặt sân vào ngày mai lúc {$bookingTime->format('H:i')}. Hãy đến đúng giờ nhé!",
            ['booking_id' => $bookingId],
            'high',
            $reminderTime
        );
    }

    public function sendWeatherAlert(string $weatherCondition): int
    {
        // Get members with upcoming bookings
        $members = DB::table('members')
            ->join('booking_lists', 'members.id', '=', 'booking_lists.member_id')
            ->where('booking_lists.created_at', '>=', now())
            ->where('booking_lists.created_at', '<=', now()->addDay())
            ->select('members.*')
            ->distinct()
            ->get();

        $message = $this->getWeatherMessage($weatherCondition);
        $count = 0;

        foreach ($members as $member) {
            $memberObj = Member::find($member->id);

            $this->queueNotification(
                $memberObj,
                'weather_alert',
                'Cảnh báo thời tiết',
                $message,
                ['weather' => $weatherCondition],
                'high',
                now()
            );

            $count++;
        }

        return $count;
    }

    protected function getWeatherMessage(string $condition): string
    {
        $messages = [
            'rain' => 'Dự báo mưa trong 24h tới. Vui lòng cân nhắc lịch đặt sân của bạn.',
            'storm' => '⚠️ Cảnh báo bão! Chúng tôi khuyên bạn nên hủy/dời lịch đặt sân.',
            'hot' => '☀️ Trời nắng nóng! Nhớ mang nước và kem chống nắng nhé!',
        ];

        return $messages[$condition] ?? 'Cập nhật thời tiết cho lịch đặt sân của bạn.';
    }
}
