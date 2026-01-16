<?php

/**
 * Register all theme widgets
 * This file loads all widget registration files
 */

// Register all theme widgets
$widgets = [
    'custom-menu',
    'footer-about',
    'footer-copyright',
    'icons',
    'site-contact',
    'site-info',
    'text',
    'text-footer',
];

foreach ($widgets as $widget) {
    $widgetPath = __DIR__ . '/' . $widget . '/registration.php';
    
    if (file_exists($widgetPath)) {
        require_once $widgetPath;
    }
}
