@php
    $bgColor = $shortcode->background_color ?: '#f8faf6';
    $borderColor = $shortcode->border_color ?: '#d1f2e8';
    $primaryColor = $shortcode->primary_color ?: '#065f46';
    $titleColor = $shortcode->title_color ?: '#0a2818';
    $textColor = $shortcode->text_color ?: '#6b7280';
@endphp

<section class="py-10" style="background-color: {{ $bgColor }};">
    <div class="container" style="max-width: 900px;">
        {{-- Section Title --}}
        @if($shortcode->title)
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: #0a2818; font-size: 1.5rem;">{{ $shortcode->title }}</h3>
            </div>
        @endif

        {{-- Notes Grid --}}
        <div class="row g-3">
            @foreach($items as $item)
                <div class="col-md-6">
                    <div class="note-card h-100 p-4 bg-white border transition-all hover-border-primary hover-shadow"
                         style="border-color: {{ $borderColor }}; border-radius: 16px;">
                        <p class="fw-bold mb-2" style="color: {{ $titleColor }}; font-size: 1rem;">
                            {{ $item['title'] ?? '' }}
                        </p>
                        <p class="mb-0" style="color: {{ $textColor }}; font-size: 0.875rem; line-height: 1.5;">
                            {{ $item['description'] ?? '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .hover-border-primary:hover {
        border-color: {{ $primaryColor }} !important;
    }
    .hover-shadow:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
    }
</style>
