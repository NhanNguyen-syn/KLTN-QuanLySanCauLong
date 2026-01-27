<?php

namespace Botble\ProductsServices\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;

class ProductsServicesServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/products-services')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api'])
            ->loadAndPublishViews()
            ->loadMigrations();

        // Register admin menu after routes are matched
        $this->app['events']->listen(\Illuminate\Routing\Events\RouteMatched::class, function () {
            // Root menu: Dịch vụ & Sản phẩm
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-products-services',
                'priority' => 6,
                'parent_id' => null,
                'name' => 'Dịch vụ & Sản phẩm',
                'icon' => 'ti ti-bottle',
                'url' => route('product-categories.index'),
                'permissions' => ['product-categories.index'],
            ]);

            // Sub-menu: Danh mục sản phẩm
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-product-categories',
                'priority' => 1,
                'parent_id' => 'cms-plugins-products-services',
                'name' => 'Danh mục sản phẩm',
                'icon' => 'ti ti-category',
                'url' => route('product-categories.index'),
                'permissions' => ['product-categories.index'],
            ]);

            // Sub-menu: Sản phẩm
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-products',
                'priority' => 2,
                'parent_id' => 'cms-plugins-products-services',
                'name' => 'Sản phẩm',
                'icon' => 'ti ti-box',
                'url' => route('products.index'),
                'permissions' => ['products.index'],
            ]);

            // Sub-menu: Dịch vụ
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-services',
                'priority' => 3,
                'parent_id' => 'cms-plugins-products-services',
                'name' => 'Dịch vụ thêm',
                'icon' => 'ti ti-plus',
                'url' => route('services.index'),
                'permissions' => ['services.index'],
            ]);
        });
    }
}
