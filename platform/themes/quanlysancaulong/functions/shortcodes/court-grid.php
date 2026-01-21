<?php

use Botble\Shortcode\Compilers\Shortcode;
use Botble\CourtBooking\Models\Court;
use Botble\Theme\Facades\Theme;

add_shortcode('court-grid', __('Court Grid'), __('Display available badminton courts in a grid layout'), function (Shortcode $shortcode) {
    // Fetch courts from database
    $courts = Court::query()
        ->with(['type', 'courtStatus'])
        ->where('status', 'published')
        ->orderBy('order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    return Theme::partial('shortcodes.court-grid.index', compact('courts', 'shortcode'));
});

shortcode()->setAdminConfig('court-grid', function ($attributes) {
    return view('plugins/shortcode::forms.court-grid', compact('attributes'))->render();
});
