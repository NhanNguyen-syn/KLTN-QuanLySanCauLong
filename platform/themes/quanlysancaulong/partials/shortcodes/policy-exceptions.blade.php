@php
    $bgColor = $shortcode->background_color ?: 'rgba(236, 245, 241, 0.3)';
    $primaryColor = $shortcode->primary_color ?: '#065f46';
    $textColor = $shortcode->text_color ?: '#0a2818';
@endphp

<section class="py-10" style="background-color: {{ $bgColor }};">
    <div class="container" style="max-width: 900px;">
        {{-- Section Title --}}
        @if($shortcode->title)
            <div class="text-center mb-4">
                <h3 class="fw-bold mb-2" style="color: #0a2818; font-size: 1.5rem;">{{ $shortcode->title }}</h3>
                @if($shortcode->subtitle)
                    <p class="text-muted small mb-0">{{ $shortcode->subtitle }}</p>
                @endif
            </div>
        @endif

        {{-- Items List --}}
        <div class="d-flex flex-column gap-3">
            @foreach($items as $item)
                @if(!empty($item['content']))
                    <div class="exception-card py-3 px-4 bg-white transition-all hover-shadow d-flex align-items-center" 
                         style="border-left: 4px solid {{ $primaryColor }}; border-radius: 12px; min-height: 60px;">
                        <p class="mb-0 fw-medium" style="color: {{ $textColor }}; font-size: 0.95rem; line-height: 1.5;">
                            {{ $item['content'] }}
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }
</style>
