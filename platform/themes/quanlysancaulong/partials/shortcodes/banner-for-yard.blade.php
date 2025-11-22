@php
    $containerId = 'shortcode-banner-for-yard-' . $shortcode->hash;
    $props = [
        'title' => $shortcode->title,
        'titleColor' => $shortcode->title_color,
        'description' => $shortcode->description,
        'backgroundImage' => $shortcode->background_image ? RvMedia::getImageUrl($shortcode->background_image) : null,
        'buttonText' => $shortcode->button_text,
        'buttonUrl' => $shortcode->button_url,
        'buttonBgColor' => $shortcode->button_bg_color,
        'buttonTextColor' => $shortcode->button_text_color,
        'overlayColor' => $shortcode->overlay_color,
    ];
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>

