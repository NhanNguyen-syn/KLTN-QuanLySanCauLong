<?php

use Botble\Media\Facades\RvMedia;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;


// Load all shortcodes
foreach (glob(__DIR__ . '/shortcodes/*.php') as $filename) {
    include_once $filename;
}

// Load theme widgets
if (file_exists($widgetFile = theme_path('widgets/register-widgets.php'))) {
    require_once $widgetFile;
}

// Register footer widget areas
register_sidebar([
    'id' => 'footer_sidebar',
    'name' => __('Footer Sidebar'),
    'description' => __('Main footer widget area - widgets display horizontally'),
]);

register_sidebar([
    'id' => 'footer_bottom_bar',
    'name' => __('Footer Bottom Bar'),
    'description' => __('Footer copyright and links area (below main footer)'),
]);



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

    $version = time();
    Theme::asset()
        ->container('footer')
        ->usePath()
        ->add('quanlysancaulong-script', 'js/main.js?v=' . $version);

    Theme::asset()
        ->container('footer')
        ->usePath()
        ->add('personal-info-form-script', 'js/personal-info-form.js');
});

add_action('admin_enqueue_scripts', function () {
    Theme::asset()->usePath()->add('admin-form-enhancements', 'js/admin-form-enhancements.js');
});

