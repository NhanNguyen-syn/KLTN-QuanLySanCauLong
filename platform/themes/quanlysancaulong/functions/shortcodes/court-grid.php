<?php

use Botble\Shortcode\Compilers\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\CourtBooking\Models\Court;
use Botble\Theme\Facades\Theme;
use Botble\Base\Enums\BaseStatusEnum;

add_shortcode('court-grid', __('Court Grid'), __('Display available badminton courts in a grid layout'), function (Shortcode $shortcode) {
    // Fetch courts from database
    $courts = Court::query()
        ->with(['type', 'courtStatus'])
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->orderBy('order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    return Theme::partial('shortcodes.court-grid.index', compact('courts', 'shortcode'));
});

shortcode()->setAdminConfig('court-grid', function ($attributes) {
    // Simple admin form - no configuration needed for this shortcode
    return ShortcodeForm::createFromArray($attributes);
});
