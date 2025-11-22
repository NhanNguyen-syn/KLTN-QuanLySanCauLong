<?php

namespace Botble\CourtBooking\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;


class CourtBookingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/court-booking')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api'])
            ->loadAndPublishViews()
            ->loadMigrations();

            // Register console commands for slot generation and cleanup
            if ($this->app->runningInConsole()) {
                $this->commands([
                    \Botble\CourtBooking\Commands\GenerateSlotsCommand::class,
                    \Botble\CourtBooking\Commands\CleanupHoldsCommand::class,
                ]);
            }

            // Register admin menu after routes are matched
            $this->app['events']->listen(\Illuminate\Routing\Events\RouteMatched::class, function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-court-booking',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'Court Booking',
                    'icon' => 'ti ti-calendar',
                    'url' => route('court-booking.index'),
                    'permissions' => ['court-booking.index'],
                ]);

                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-court-slots',
                    'priority' => 6,
                    'parent_id' => 'cms-plugins-court-booking',
                    'name' => 'Court Slots',
                    'icon' => 'ti ti-clock',
                    'url' => route('court-slot.index'),
                    'permissions' => ['court-slot.index'],
                ]);
            });
    }
}
