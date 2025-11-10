<?php

use Botble\Media\Facades\RvMedia;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Theme\Facades\Theme;

register_page_template([
    'default' => __('Default'),
]);

app()->booted(function () {
    RvMedia::addSize('medium', 800, 800)
        ->addSize('thumb', 400, 400);

    ThemeSupport::registerSocialLinks();
    ThemeSupport::registerToastNotification();
    ThemeSupport::registerPreloader();
    ThemeSupport::registerSiteCopyright();
    ThemeSupport::registerDateFormatOption();
    ThemeSupport::registerLazyLoadImages();
    ThemeSupport::registerSocialSharing();
    ThemeSupport::registerSiteLogoHeight();

    // Enqueue compiled Vue (TSX) bundle
    Theme::asset()->usePath()->add('theme-main', 'js/main.js');
});
