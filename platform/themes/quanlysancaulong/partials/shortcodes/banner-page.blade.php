@php
    $title = $shortcode->title;
    $titleColor = $shortcode->title_color ?: '#ffffff';
    $titleAccent = $shortcode->title_accent_color ?: '#6fd3c3';
    $subtitle = $shortcode->subtitle;
    $subtitleColor = $shortcode->subtitle_color ?: '#a7f3d0';
    $bgColor = $shortcode->background_color ?: '#0f766e';

    $btn1Text = $shortcode->button_1_text;
    $btn1Link = $shortcode->button_1_link ?: '#';
    $btn1TextColor = $shortcode->button_1_text_color ?: '#0f766e';
    $btn1Bg = $shortcode->button_1_background_color ?: '#ffffff';

    $btn2Text = $shortcode->button_2_text;
    $btn2Link = $shortcode->button_2_link ?: '#';
    $btn2TextColor = $shortcode->button_2_text_color ?: '#ffffff';
    $btn2BorderColor = $shortcode->button_2_border_color ?: '#ffffff';

    $centeredBg = "radial-gradient(1200px 600px at 20% 0%, rgba(255,255,255,0.08), transparent 60%), radial-gradient(900px 500px at 90% 10%, rgba(255,255,255,0.06), transparent 60%), $bgColor";

    $props = [
        'title' => $title,
        'titleColor' => $titleColor,
        'titleAccentColor' => $titleAccent,
        'subtitle' => $subtitle,
        'subtitleColor' => $subtitleColor,
        'backgroundColor' => $bgColor,
        'btn1Text' => $btn1Text,
        'btn1Link' => $btn1Link,
        'btn1TextColor' => $btn1TextColor,
        'btn1Bg' => $btn1Bg,
        'btn2Text' => $btn2Text,
        'btn2Link' => $btn2Link,
        'btn2TextColor' => $btn2TextColor,
        'btn2BorderColor' => $btn2BorderColor,
        'stats' => $stats,
    ];

    $lines = preg_split("/(\r\n|\n|\r)/", trim((string) $title));
@endphp

<div class="banner-page-shortcode-root" data-props="{{ json_encode($props, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}">
    <!-- Server-side fallback render in case JS not loaded -->
    <section class="banner-page-shortcode" style="position: relative; padding: 90px 0 70px; background: {{ $centeredBg }}; width: 100vw; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; overflow: hidden;">
        <div class="container">
            <div class="text-center mx-auto" style="max-width: 900px;">
                @if (!empty($lines))
                    <h1 style="font-weight: 700; line-height: 1.2; font-size: clamp(32px, 5vw, 56px);">
                        @foreach ($lines as $i => $line)
                            <span style="color: {{ $i === 0 ? $titleColor : $titleAccent }}">{!! BaseHelper::clean($line) !!}</span>@if ($i < count($lines) - 1)<br>@endif
                        @endforeach
                    </h1>
                @endif

                @if ($subtitle)
                    <p class="mt-3" style="color: {{ $subtitleColor }}; font-size: 16px;">{!! BaseHelper::clean($subtitle) !!}</p>
                @endif

                <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
                    @if ($btn1Text)
                        <a href="{{ $btn1Link }}" class="btn px-4 py-2" style="background-color: {{ $btn1Bg }}; color: {{ $btn1TextColor }}; border: 1px solid {{ $btn1Bg }}; font-weight: 600;">
                            {{ $btn1Text }}
                        </a>
                    @endif

                    @if ($btn2Text)
                        <a href="{{ $btn2Link }}" class="btn px-4 py-2" style="background-color: transparent; color: {{ $btn2TextColor }}; border: 1px solid {{ $btn2BorderColor }}; font-weight: 600;">
                            {{ $btn2Text }}
                        </a>
                    @endif
                </div>
            </div>

            @if (!empty($stats))
                <div class="mt-5">
                    <div class="row g-4 justify-content-center row-cols-2 row-cols-md-4">
                        @foreach ($stats as $item)
                            @php($sTitle = data_get($item, 'title'))
                            @php($sDesc = data_get($item, 'description'))
                            <div class="col">
                                <div class="text-center">
                                    @if ($sTitle)
                                        <div style="color: #ffffff; font-weight: 800; font-size: 26px;">{{ $sTitle }}</div>
                                    @endif
                                    @if ($sDesc)
                                        <div class="mt-1" style="color: #a7f3d0; font-size: 13px;">{{ $sDesc }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
