@php
    $bgColor = $shortcode->background_color ?: 'rgba(236, 245, 241, 0.3)';
    
    // Phone Data
    $phoneTitle = $shortcode->phone_title ?: 'Điện Thoại';
    $phoneValue = $shortcode->phone_value ?: '(84) 0886 264 644';
    $phoneBorder = $shortcode->phone_border_color ?: '#065f46';
    $phoneText = $shortcode->phone_text_color ?: '#065f46';

    // Email Data
    $emailTitle = $shortcode->email_title ?: 'Email';
    $emailValue = $shortcode->email_value ?: 'info@badmintonpro.vn';
    $emailBorder = $shortcode->email_border_color ?: '#059669';
    $emailText = $shortcode->email_text_color ?: '#059669';
@endphp

<section class="py-10" style="background-color: {{ $bgColor }};">
    <div class="container" style="max-width: 700px;">
        {{-- Section Title --}}
        <div class="text-center mb-4">
            @if($shortcode->title)
                <h3 class="fw-bold mb-2" style="color: #0a2818; font-size: 1.5rem;">{{ $shortcode->title }}</h3>
            @endif
            @if($shortcode->subtitle)
                <p class="text-muted small mb-0">{{ $shortcode->subtitle }}</p>
            @endif
        </div>

        {{-- Contact Items --}}
        <div class="row g-3 justify-content-center">
            {{-- Phone Card --}}
            <div class="col-md-6">
                <div class="support-card text-center p-4 bg-white h-100 d-flex flex-column justify-content-center"
                     style="border: 1px solid {{ $phoneBorder }} !important; border-radius: 12px;">
                    <p class="fw-bold mb-2 text-dark" style="font-size: 0.95rem;">
                        {{ $phoneTitle }}
                    </p>
                    <p class="fw-bold mb-0" style="color: {{ $phoneText }}; font-size: 1.1rem;">
                        {{ $phoneValue }}
                    </p>
                </div>
            </div>

            {{-- Email Card --}}
            <div class="col-md-6">
                <div class="support-card text-center p-4 bg-white h-100 d-flex flex-column justify-content-center"
                     style="border: 1px solid {{ $emailBorder }} !important; border-radius: 12px;">
                    <p class="fw-bold mb-2 text-dark" style="font-size: 0.95rem;">
                        {{ $emailTitle }}
                    </p>
                    <p class="fw-bold mb-0" style="color: {{ $emailText }}; font-size: 1.1rem;">
                        {{ $emailValue }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
