<?php

namespace Botble\RevenueStatistics\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;

class RevenueStatisticsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/revenue-statistics')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-revenue-statistics',
                'priority' => 15,
                'parent_id' => null,
                'name' => 'Thống kê doanh thu',
                'icon' => 'ti ti-chart-bar',
                'url' => route('revenue-statistics.index'),
                'permissions' => ['revenue-statistics.index'],
            ]);
        });
    }
}
