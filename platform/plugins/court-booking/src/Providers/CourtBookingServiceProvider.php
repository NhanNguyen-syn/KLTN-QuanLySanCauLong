<?php

namespace Botble\CourtBooking\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;

class CourtBookingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;


    public function register(): void
    {
        $this->app->singleton(\Botble\CourtBooking\Services\BookingService::class, function () {
            return new \Botble\CourtBooking\Services\BookingService();
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/court-booking')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api'])
            ->loadAndPublishViews()
            ->loadMigrations()
            ->loadHelpers();

            // Register console commands for slot generation and cleanup
            if ($this->app->runningInConsole()) {
                $this->commands([
                    \Botble\CourtBooking\Commands\GenerateSlotsCommand::class,
                    \Botble\CourtBooking\Commands\CleanupHoldsCommand::class,
                ]);
            }

            // Register admin menu after routes are matched
            $this->app["events"]->listen(\Illuminate\Routing\Events\RouteMatched::class, function () {
                // Root group
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-court-booking',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'Quản lý Sân',
                    'icon' => 'ti ti-ball-basketball',
                    'url' => route('courts.index'),
                    'permissions' => ['courts.index'],
                ]);

                // Sân
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-courts',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-court-booking',
                    'name' => 'Sân',
                    'icon' => 'ti ti-photo',
                    'url' => route('courts.index'),
                    'permissions' => ['courts.index'],
                ]);

                // Danh sách đặt sân (new)
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-booking-list',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-court-booking',
                    'name' => 'Danh sách đặt sân',
                    'icon' => 'ti ti-calendar-event',
                    'url' => route('booking-list.index'),
                    'permissions' => ['booking-list.index'],
                ]);

                // Ẩn menu "Đặt sân" riêng lẻ vì đã gộp vào danh sách khung giờ
                // Nếu muốn bật lại, bỏ comment khối dưới đây
                /*
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-court-bookings',
                    'priority' => 3,
                    'parent_id' => 'cms-plugins-court-booking',
                    'name' => 'Đặt sân',
                    'icon' => 'ti ti-calendar-event',
                    'url' => route('court-booking.index'),
                    'permissions' => ['court-booking.index'],
                ]);
                */
            });
    }
}
