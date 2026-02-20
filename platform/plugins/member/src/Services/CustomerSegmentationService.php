<?php

namespace Botble\Member\Services;

use Botble\Member\Models\CustomerAnalytics;
use Botble\Member\Models\CustomerSegment;
use Botble\Member\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerSegmentationService
{
    const SEGMENT_VIP = 'VIP';
    const SEGMENT_REGULAR = 'Regular';
    const SEGMENT_AT_RISK = 'At-Risk';
    const SEGMENT_NEW = 'New';
    const SEGMENT_CHURNED = 'Churned';

    public function calculateForMember(Member $member): CustomerAnalytics
    {
        // Get completed bookings via BookingList (cart bookings)
        $bookings = DB::table('booking_lists')
            ->where('member_id', $member->id)
            ->where('status', 'completed')
            ->get();

        $analytics = CustomerAnalytics::firstOrNew(['member_id' => $member->id]);

        // RFM Calculation
        $analytics->rfm_frequency = $bookings->count();
        $analytics->rfm_monetary = $bookings->sum('total_amount');

        $lastBooking = $bookings->sortByDesc('created_at')->first();
        $analytics->rfm_recency = $lastBooking
            ? Carbon::parse($lastBooking->created_at)->diffInDays(now())
            : 9999;

        $analytics->lifetime_value = $analytics->rfm_monetary;

        // Segmentation
        $analytics->segment = $this->determineSegment($analytics);
        $analytics->last_calculated_at = now();
        $analytics->save();

        // Update segment record
        $this->updateSegmentRecord($member, $analytics);

        return $analytics;
    }

    protected function determineSegment(CustomerAnalytics $analytics): string
    {
        // VIP: High frequency + high monetary + recent
        if (
            $analytics->rfm_frequency >= 10 &&
            $analytics->rfm_monetary >= 5000000 &&
            $analytics->rfm_recency <= 30
        ) {
            return self::SEGMENT_VIP;
        }

        // Churned: Not booked in 90+ days
        if ($analytics->rfm_recency >= 90) {
            return self::SEGMENT_CHURNED;
        }

        // At-Risk: Used to book but slowing down
        if ($analytics->rfm_recency > 45 && $analytics->rfm_frequency >= 3) {
            return self::SEGMENT_AT_RISK;
        }

        // New: Less than 3 bookings
        if ($analytics->rfm_frequency < 3) {
            return self::SEGMENT_NEW;
        }

        // Regular: Everything else
        return self::SEGMENT_REGULAR;
    }

    protected function updateSegmentRecord(Member $member, CustomerAnalytics $analytics): void
    {
        $score = $this->calculateScore($analytics);

        CustomerSegment::updateOrCreate(
            ['member_id' => $member->id],
            [
                'segment_type' => $analytics->segment,
                'score' => $score,
                'metadata' => $this->buildMetadata($member, $analytics),
                'assigned_at' => now(),
            ]
        );
    }

    protected function calculateScore(CustomerAnalytics $analytics): int
    {
        $score = 0;

        // Frequency score (0-40)
        $score += min(40, $analytics->rfm_frequency * 4);

        // Monetary score (0-40)
        $score += min(40, ($analytics->rfm_monetary / 100000) * 2);

        // Recency score (0-20)
        if ($analytics->rfm_recency <= 7)
            $score += 20;
        elseif ($analytics->rfm_recency <= 30)
            $score += 15;
        elseif ($analytics->rfm_recency <= 60)
            $score += 10;
        elseif ($analytics->rfm_recency <= 90)
            $score += 5;

        return min(100, $score);
    }

    protected function buildMetadata(Member $member, CustomerAnalytics $analytics): array
    {
        $bookings = DB::table('booking_lists')
            ->where('member_id', $member->id)
            ->where('status', 'completed')
            ->get();

        if ($bookings->isEmpty()) {
            return [
                'preferred_day' => null,
                'preferred_hour' => null,
                'avg_booking_value' => 0,
                'last_booking_date' => null,
            ];
        }

        // Most booked day of week
        $dayOfWeek = $bookings->pluck('created_at')
            ->map(fn($date) => Carbon::parse($date)->dayOfWeek)
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first();

        return [
            'preferred_day' => $dayOfWeek,
            'preferred_hour' => null, // Can't determine from cart system
            'avg_booking_value' => $analytics->rfm_frequency > 0
                ? $analytics->rfm_monetary / $analytics->rfm_frequency
                : 0,
            'last_booking_date' => $bookings->sortByDesc('created_at')->first()?->created_at,
        ];
    }

    public function calculateForAllMembers(): void
    {
        Member::chunk(100, function ($members) {
            foreach ($members as $member) {
                $this->calculateForMember($member);
            }
        });
    }

    public function getSegmentStats(): array
    {
        return CustomerAnalytics::select('segment', DB::raw('count(*) as count'))
            ->groupBy('segment')
            ->pluck('count', 'segment')
            ->toArray();
    }

    public function getMembersBySegment(string $segment)
    {
        return CustomerAnalytics::with('member')
            ->where('segment', $segment)
            ->orderBy('lifetime_value', 'desc')
            ->get();
    }
}
