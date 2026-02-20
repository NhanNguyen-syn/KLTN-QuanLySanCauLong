<?php

namespace Botble\Member\Http\Controllers\Admin;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Member\Services\CustomerSegmentationService;
use Illuminate\Http\Request;

class CustomerAnalyticsController extends BaseController
{
    protected CustomerSegmentationService $segmentationService;

    public function __construct(CustomerSegmentationService $segmentationService)
    {
        $this->segmentationService = $segmentationService;
    }

    public function index()
    {
        $this->pageTitle('Customer Analytics');

        $stats = $this->segmentationService->getSegmentStats();

        return view('plugins/member::admin.analytics.index', compact('stats'));
    }

    public function segment(string $segment)
    {
        $this->pageTitle(ucfirst($segment) . ' Customers');

        $customers = $this->segmentationService->getMembersBySegment($segment);

        return view('plugins/member::admin.analytics.segment', compact('customers', 'segment'));
    }

    public function recalculate(Request $request)
    {
        $this->segmentationService->calculateForAllMembers();

        return $this
            ->httpResponse()
            ->setMessage('Customer segments recalculated successfully');
    }
}
