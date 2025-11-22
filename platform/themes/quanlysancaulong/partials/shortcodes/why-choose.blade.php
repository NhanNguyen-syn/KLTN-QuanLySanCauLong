@php
    $containerId = 'shortcode-why-choose-' . $shortcode->hash;

    $items = [];
    if (!empty($tabs)) {
        $tabs = array_slice($tabs, 0, 12);
        foreach ($tabs as $tab) {
            $items[] = [
                'title' => $tab['item_title'] ?? '',
                'desc' => $tab['item_desc'] ?? '',
                'titleColor' => $tab['item_title_color'] ?? null,
                'descColor' => $tab['item_desc_color'] ?? null,
            ];
        }
    }

    $props = [
        'title' => $shortcode->title,
        'subtitle' => $shortcode->subtitle,
        'items' => $items,
        'titleColor' => $shortcode->title_color,
        'subtitleColor' => $shortcode->subtitle_color,
    ];
@endphp

<div id="{{ $containerId }}" data-props='@json($props)'></div>