@php
    $bgColor = $shortcode->background_color ?: '#f8faf6';
    $primaryColor = $shortcode->primary_color ?: '#065f46';
    $borderColor = $shortcode->border_color ?: '#d1f2e8';
    $textColor = $shortcode->text_color ?: '#6b7280';

    $colCount = count($columns);
    
    // Determine column class based on count
    $colClass = 'col-lg-4';
    if ($colCount == 1) $colClass = 'col-md-8 offset-md-2';
    elseif ($colCount == 2) $colClass = 'col-lg-6';
    elseif ($colCount == 3) $colClass = 'col-lg-4';
    elseif ($colCount == 4) $colClass = 'col-xl-3 col-lg-6'; 
@endphp

<section class="py-10" style="background-color: {{ $bgColor }};">
    <div class="container" style="max-width: {{ $colCount >= 4 ? '1320px' : '1140px' }};">
        <div class="row g-4 justify-content-center">
            @foreach($columns as $col)
                <div class="{{ $colClass }}">
                    <div class="policy-column h-100 bg-white overflow-hidden transition-all hover-shadow"
                         style="border: 1px solid {{ $borderColor }}; border-radius: 12px;">
                        
                        {{-- Column Header --}}
                        <div class="policy-header p-4 border-bottom" style="border-bottom-color: {{ $borderColor }};">
                            <h6 class="fw-bold text-uppercase mb-0" style="color: {{ $primaryColor }}; font-size: 1rem; letter-spacing: 0.5px;">
                                {{ $col['title'] }}
                            </h6>
                        </div>

                        {{-- Column Body --}}
                        <div class="policy-body">
                            @foreach($col['items'] as $item)
                                <div class="policy-item p-3 border-bottom d-flex flex-column justify-content-center" style="border-bottom-color: {{ $borderColor }}; min-height: 140px;">
                                    <p class="fw-bold mb-2 text-dark" style="font-size: 0.95rem;">
                                        {{ $item['condition'] ?? '' }}
                                    </p>
                                    <p class="fw-bold mb-2" style="color: {{ $primaryColor }}; font-size: 1.1rem;">
                                        {{ $item['fee'] ?? '' }}
                                    </p>
                                    @if(!empty($item['description']))
                                        <p class="small mb-0" style="color: {{ $textColor }}; font-size: 0.85rem; line-height: 1.5;">
                                            {{ $item['description'] }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .policy-item:last-child { border-bottom: none !important; }
    .hover-shadow:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        border-color: {{ $primaryColor }} !important;
    }
</style>
