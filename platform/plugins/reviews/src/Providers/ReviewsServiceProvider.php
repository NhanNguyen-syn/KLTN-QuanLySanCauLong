<?php

namespace Botble\Reviews\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;

class ReviewsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/reviews')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadMigrations();

        $this->app['events']->listen(\Illuminate\Routing\Events\RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-reviews',
                'priority' => 50,
                'parent_id' => null,
                'name' => 'Quản lý đánh giá',
                'icon' => 'ti ti-star',
                'url' => route('reviews.index'),
                'permissions' => ['reviews.index'],
            ]);
        });
    }
}
