<?php

use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Support\Facades\File;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    // Tự động load tất cả các file shortcode trong thư mục `shortcodes`
    $shortcodesPath = __DIR__ . '/shortcodes';
    if (File::isDirectory($shortcodesPath)) {
        foreach (File::files($shortcodesPath) as $file) {
            if ($file->getExtension() === 'php') {
                require_once $file->getPathname();
            }
        }
    }
});
