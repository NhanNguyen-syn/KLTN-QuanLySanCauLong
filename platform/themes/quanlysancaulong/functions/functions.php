<?php

use Botble\Media\Facades\RvMedia;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;


foreach (glob(__DIR__ . '/shortcodes/*.php') as $filename) {
    include_once $filename;
}

register_page_template([
    'default' => __('Default'),
    'layouts.full-width' => __('Full Width'),
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


    // Enqueue style & script
    Theme::asset()
        ->usePath()
        ->add('quanlysancaulong-style', 'css/style.css');

    Theme::asset()
        ->container('footer')
        ->usePath()
        ->add('quanlysancaulong-script', 'js/main.js');
});
