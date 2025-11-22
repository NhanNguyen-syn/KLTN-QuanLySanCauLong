@php
    $containerId = 'shortcode-court-pricing-' . $shortcode->hash;

    $cards = [];
    if (!empty($tabs)) {
        foreach ($tabs as $tab) {
            $cards[] = [
                'title' => $tab['title'],
                'price' => $tab['price'],
                'unit' => $tab['unit'],
                'tag' => $tab['tag'],
                'features' => preg_split('/\r\n|\r|\n/', $tab['features'], -1, PREG_SPLIT_NO_EMPTY),
                'button_text' => $tab['button_text'],
                'button_url' => $tab['button_url'],
                'card_bg_color' => $tab['card_bg_color'],
                'card_text_color' => $tab['card_text_color'],
                'tag_bg_color' => $tab['tag_bg_color'],
                'tag_text_color' => $tab['tag_text_color'],
                'button_bg_color' => $tab['button_bg_color'],
                'button_text_color' => $tab['button_text_color'],
            ];
        }
    }

    $props = [
        'title' => $shortcode->title,
        'subtitle' => $shortcode->subtitle,
        'cards' => $cards,
        'viewAllText' => $shortcode->view_all_text,
        'viewAllUrl' => $shortcode->view_all_url,
        'titleColor' => $shortcode->title_color,
        'subtitleColor' => $shortcode->subtitle_color,
        'viewAllColor' => $shortcode->view_all_color,
    ];
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>

