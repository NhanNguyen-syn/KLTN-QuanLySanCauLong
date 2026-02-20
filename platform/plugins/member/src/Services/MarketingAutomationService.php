<?php

namespace Botble\Member\Services;

use Botble\Member\Models\CustomerAnalytics;
use Botble\Member\Models\EmailCampaign;
use Botble\Member\Models\CampaignLog;
use Botble\Member\Models\Member;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MarketingAutomationService
{
    public function sendCampaign(EmailCampaign $campaign): int
    {
        if (!$campaign->isReady()) {
            return 0;
        }

        $recipients = $this->getRecipients($campaign);
        $sentCount = 0;

        foreach ($recipients as $member) {
            try {
                $this->sendToMember($campaign, $member);
                $sentCount++;
            } catch (\Exception $e) {
                Log::error("Campaign email failed: " . $e->getMessage());

                CampaignLog::create([
                    'campaign_id' => $campaign->id,
                    'member_id' => $member->id,
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                    'sent_at' => now(),
                ]);
            }
        }

        $campaign->increment('sent_count', $sentCount);

        return $sentCount;
    }

    protected function getRecipients(EmailCampaign $campaign)
    {
        $query = Member::query();

        // Filter by segment if specified
        if ($campaign->segment_target && $campaign->segment_target !== 'All') {
            $query->whereHas('analytics', function ($q) use ($campaign) {
                $q->where('segment', $campaign->segment_target);
            });
        }

        // Exclude already sent members
        $query->whereNotIn('id', function ($q) use ($campaign) {
            $q->select('member_id')
                ->from('campaign_logs')
                ->where('campaign_id', $campaign->id)
                ->whereIn('status', ['sent', 'opened', 'clicked']);
        });

        return $query->get();
    }

    protected function sendToMember(EmailCampaign $campaign, Member $member): void
    {
        $personalizedBody = $this->personalize($campaign->body, $member);

        Mail::send([], [], function ($message) use ($campaign, $member, $personalizedBody) {
            $message->to($member->email, $member->name)
                ->subject($campaign->subject)
                ->html($personalizedBody);
        });

        CampaignLog::create([
            'campaign_id' => $campaign->id,
            'member_id' => $member->id,
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    protected function personalize(string $body, Member $member): string
    {
        $replacements = [
            '{name}' => $member->first_name,
            '{full_name}' => $member->name,
            '{email}' => $member->email,
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $body);
    }

    public function checkTriggeredCampaigns(): int
    {
        $executedCount = 0;

        // Find active event-based campaigns
        $campaigns = EmailCampaign::where('status', 'active')
            ->where('trigger_type', 'event')
            ->get();

        foreach ($campaigns as $campaign) {
            if ($this->shouldTrigger($campaign)) {
                $this->sendCampaign($campaign);
                $executedCount++;
            }
        }

        return $executedCount;
    }

    protected function shouldTrigger(EmailCampaign $campaign): bool
    {
        $config = $campaign->trigger_config ?? [];

        // Example: Trigger if member hasn't booked in X days
        if (isset($config['no_booking_days'])) {
            $days = $config['no_booking_days'];

            $members = Member::whereHas('analytics', function ($q) use ($days) {
                $q->where('rfm_recency', '>=', $days);
            })->count();

            return $members > 0;
        }

        // Example: Trigger new member welcome
        if (isset($config['welcome_new'])) {
            $newMembers = Member::where('created_at', '>=', now()->subDay())->count();
            return $newMembers > 0;
        }

        return false;
    }

    public function getCampaignStats(EmailCampaign $campaign): array
    {
        return [
            'total_sent' => $campaign->sent_count,
            'total_opened' => $campaign->open_count,
            'total_clicked' => $campaign->click_count,
            'open_rate' => $campaign->getOpenRate(),
            'click_rate' => $campaign->getClickRate(),
            'failed' => $campaign->logs()->where('status', 'failed')->count(),
        ];
    }
}
