<?php

namespace Botble\Member\Console;

use Botble\Member\Services\CustomerSegmentationService;
use Illuminate\Console\Command;

class CalculateCustomerSegments extends Command
{
    protected $signature = 'customer:calculate-segments';

    protected $description = 'Calculate RFM metrics and customer segments';

    protected CustomerSegmentationService $segmentationService;

    public function __construct(CustomerSegmentationService $segmentationService)
    {
        parent::__construct();
        $this->segmentationService = $segmentationService;
    }

    public function handle(): int
    {
        $this->info('Calculating customer segments...');

        $this->segmentationService->calculateForAllMembers();

        $stats = $this->segmentationService->getSegmentStats();

        $this->info('Segmentation complete:');
        foreach ($stats as $segment => $count) {
            $this->line("  {$segment}: {$count} customers");
        }

        return Command::SUCCESS;
    }
}
