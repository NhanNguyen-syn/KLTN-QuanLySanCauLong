@php
    // Tạo một ID duy nhất cho container để có thể dùng nhiều shortcode trên cùng một trang
    $containerId = 'shortcode-banner-page-' . $shortcode->hash;

    // Chuẩn bị dữ liệu (props) để truyền cho component TSX
    $props = [
        'title' => $shortcode->title,
        'description' => $shortcode->description,
        'backgroundImage' => $shortcode->background_image ? RvMedia::getImageUrl($shortcode->background_image) : null,
        'buttonText' => $shortcode->button_text,
        'buttonUrl' => $shortcode->button_url,
        'satisfiedText' => $shortcode->satisfied_text,
    ];


@endphp

{{-- Container rỗng để Vue component có thể mount vào --}}
<div id="{{ $containerId }}" data-props="{{ json_encode($props) }}"></div>

