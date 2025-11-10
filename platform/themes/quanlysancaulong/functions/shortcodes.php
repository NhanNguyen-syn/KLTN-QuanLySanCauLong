<?php

use Botble\Theme\Supports\ThemeSupport;

app()->booted(function () {
    // Register built-in theme shortcodes
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    // Autoload all shortcodes placed in this folder: functions/shortcodes/*.php
    $dir = __DIR__ . '/shortcodes';
    foreach (glob($dir . '/*.php') as $file) {
        require_once $file;
    }
});
