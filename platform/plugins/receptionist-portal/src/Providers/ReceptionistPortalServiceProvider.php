<?php

namespace Botble\ReceptionistPortal\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;

class ReceptionistPortalServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/receptionist-portal')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-receptionist',
                'priority' => 10,
                'parent_id' => null,
                'name' => 'Lễ tân',
                'icon' => 'ti ti-user-check',
                'url' => route('receptionist.index'),
                'permissions' => ['receptionist.index'],
            ]);

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-receptionist-dashboard',
                'priority' => 1,
                'parent_id' => 'cms-plugins-receptionist',
                'name' => 'Dashboard',
                'icon' => 'ti ti-dashboard',
                'url' => route('receptionist.index'),
                'permissions' => ['receptionist.index'],
            ]);

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-receptionist-quick-booking',
                'priority' => 2,
                'parent_id' => 'cms-plugins-receptionist',
                'name' => 'Đặt sân nhanh',
                'icon' => 'ti ti-calendar-plus',
                'url' => route('receptionist.quick-booking'),
                'permissions' => ['receptionist.quick-booking'],
            ]);

            DashboardMenu::registerItem([
                'id' => 'cms-plugins-receptionist-vip',
                'priority' => 3,
                'parent_id' => 'cms-plugins-receptionist',
                'name' => 'Khách VIP',
                'icon' => 'ti ti-star',
                'url' => route('receptionist.vip.index'),
                'permissions' => ['receptionist.vip'],
            ]);
        });
    }
}
