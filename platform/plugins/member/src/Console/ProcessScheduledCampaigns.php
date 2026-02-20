<?php

namespace Botble\Member\Console;

use Botble\Member\Services\MarketingAutomationService;
use Botble\Member\Models\EmailCampaign;
use Illuminate\Console\Command;

class ProcessScheduledCampaigns extends Command
{
    protected $signature = 'campaigns:process';

    protected $description = 'Process scheduled email campaigns';

    protected MarketingAutomationService $marketingService;

    public function __construct(MarketingAutomationService $marketingService)
    {
        parent::__construct();
        $this->marketingService = $marketingService;
    }

    public function handle(): int
    {
        $this->info('Processing scheduled campaigns...');

        // Send scheduled campaigns
        $scheduled = EmailCampaign::where('status', 'active')
            ->where('trigger_type', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($scheduled as $campaign) {
            $sent = $this->marketingService->sendCampaign($campaign);
            $this->info("Campaign '{$campaign->name}': {$sent} emails sent");

            $campaign->update(['status' => 'completed']);
        }

        // Check event-triggered campaigns
        $triggered = $this->marketingService->checkTriggeredCampaigns();
        $this->info("Triggered campaigns: {$triggered}");

        return Command::SUCCESS;
    }
}
