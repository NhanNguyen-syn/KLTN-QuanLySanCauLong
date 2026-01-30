@php
    // Tạo một ID duy nhất cho container để có thể dùng nhiều shortcode trên cùng một trang
    $containerId = 'shortcode-banner-for-yard-' . $shortcode->hash;

    // Chuẩn bị dữ liệu (props) để truyền cho component TSX
    $props = [
        'title' => $shortcode->title,
        'titleColor' => $shortcode->title_color,
        'description' => $shortcode->description,
        'textAlign' => $shortcode->text_align,
        'backgroundImage' => $shortcode->background_image ? RvMedia::getImageUrl($shortcode->background_image) : null,
        'overlayColor' => $shortcode->overlay_color,
        'buttonText' => $shortcode->button_text,
        'buttonUrl' => $shortcode->button_url,
        'buttonBgColor' => $shortcode->button_bg_color,
        'buttonTextColor' => $shortcode->button_text_color,
    ];

@endphp

{{-- Container rỗng để Vue component có thể mount vào --}}
<div id="{{ $containerId }}" data-props="{{ json_encode($props) }}"></div>
