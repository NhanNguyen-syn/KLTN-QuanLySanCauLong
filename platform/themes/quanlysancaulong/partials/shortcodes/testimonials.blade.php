@php
    $items = [];
    if (isset($testimonials)) {
        foreach ($testimonials as $it) {
            $items[] = [
                'name' => $it['name'] ?? '',
                'role' => $it['role'] ?? '',
                'avatar' => $it['avatar'] ?? '',
                'content' => $it['content'] ?? '',
                'stars' => (int)($it['stars'] ?? 5),
            ];
        }
    }

    $itemsRow1 = array_slice($items, 0, 10);
    $itemsRow2 = array_slice($items, 10, 10);

    $props = [
        'title' => $shortcode->title ?: 'What our members say',
        'subtitle' => $shortcode->subtitle ?: 'Our students love the coaching, fun training sessions, and the chance to improve their skills while enjoying every moment on the court.',
        'titleColor' => $shortcode->title_color ?: '#153E35',
        'subtitleColor' => $shortcode->subtitle_color ?: '#6b7280',
        'bgColor' => $shortcode->bg_color ?: '#F3F7F5',
        'cardBgColor' => $shortcode->card_bg_color ?: '#ffffff',
        'starColor' => $shortcode->star_color ?: '#C6F432',
        'speed' => (int)($shortcode->speed ?: 5000),
        'secondRowSpeed' => (int)($shortcode->second_row_speed ?: 7000),
        'buttonText' => $shortcode->button_text ?: 'See more',
        'buttonUrl' => $shortcode->button_url ?: '#',
        'buttonBgColor' => $shortcode->button_bg_color ?: '#C6F432',
        'buttonTextColor' => $shortcode->button_text_color ?: '#153E35',
        'itemsRow1' => $itemsRow1,
        'itemsRow2' => $itemsRow2,
    ];
@endphp

<div id="shortcode-testimonials-{{ Str::random(8) }}" data-props="{{ json_encode($props) }}"></div>