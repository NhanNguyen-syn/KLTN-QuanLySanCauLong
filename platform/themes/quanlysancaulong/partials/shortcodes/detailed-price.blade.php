@php
    $containerId = 'shortcode-detailed-price-' . $shortcode->hash;
    $props = [
        'sectionTitle' => $shortcode->section_title ?: 'Bảng Giá Chi Tiết',
        'sectionSubtitle' => $shortcode->section_subtitle ?: 'Lựa chọn gói phù hợp với nhu cầu và cấu hình của bạn',
        'titleColor' => $shortcode->title_color ?: '#0f3d2e',
        'labelColor' => $shortcode->label_color ?: '#0d5e43',
        'plans' => $plans ?? [],
    ];
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>

