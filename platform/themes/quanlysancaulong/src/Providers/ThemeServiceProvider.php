<?php

namespace Theme\Quanlysancaulong\Providers;

use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;
use Theme\Quanlysancaulong\ViewComposers\HeaderViewComposer;

class ThemeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('themes/quanlysancaulong')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadHelpers();

        view()->composer('themes.quanlysancaulong.partials.header', HeaderViewComposer::class);
    }
}

