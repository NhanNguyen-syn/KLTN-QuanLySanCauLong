@php
    $title = $props['title'] ?? 'Page Title';
    $subtitle = $props['subtitle'] ?? '';
    $backgroundColor = $props['background_color'] ?? 'linear-gradient(to right, #0E6B5C, #1DB9A2)';
@endphp

<section class="page-header-section" style="background: {{ $backgroundColor }};">
    <style>
        .page-header-section {
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .page-header-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .page-header-section .page-title {
            font-size: 42px;
            font-weight: 700;
            margin: 0 0 15px 0;
            line-height: 1.2;
        }

        .page-header-section .page-subtitle {
            font-size: 18px;
            font-weight: 400;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .page-header-section {
                padding: 40px 0;
            }
            .page-header-section .page-title {
                font-size: 32px;
            }
            .page-header-section .page-subtitle {
                font-size: 16px;
            }
        }
    </style>

    <div class="container">
        <h1 class="page-title">{{ $title }}</h1>
        @if(!empty($subtitle))
            <p class="page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</section>

