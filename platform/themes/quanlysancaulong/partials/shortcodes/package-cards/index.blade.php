@php
    $title = $title ?? 'Đối Tượng Khách Hàng';
    $description = $description ?? 'Chọn loại hình phù hợp với nhu cầu sử dụng sân của bạn';
    $footer_text = $footer_text ?? 'Nhấn vào loại khách hàng để bắt đầu đặt sân';
    $packages = $packages ?? [];
    
    // Colors
    $bgColor = $bg_color ?? '#F7FAF5';
    $titleColor = $title_color ?? '#0A2918';
    $descriptionColor = $description_color ?? '#065e45';
    $iconBgColor = $icon_bg_color ?? '#065e45';
    $subtitleColor = $subtitle_color ?? '#065e45';
@endphp

<section class="package-cards-section" style="background-color: {{ $bgColor }};">
    <div class="package-cards-container">
        @if($title || $description)
            <div class="package-cards-header">
                @if($title)
                    <h2 class="package-cards-title">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="package-cards-description">{{ $description }}</p>
                @endif
            </div>
        @endif

        <div class="package-cards-grid">
            @foreach($packages as $package)
                <div class="package-card {{ $package['is_featured'] ? 'package-card-featured' : '' }}">
                    <div class="package-card-inner">
                        <div class="package-card-icon">
                            <span class="package-icon-emoji">{{ $package['icon'] }}</span>
                        </div>
                        
                        <h3 class="package-card-title">{{ $package['title'] }}</h3>
                        <p class="package-card-description">{{ $package['description'] }}</p>
                        @if(!empty($package['subtitle']))
                            <p class="package-card-subtitle">{{ $package['subtitle'] }}</p>
                        @endif
                        
                        @if($package['price'])
                            <div class="package-card-price">
                                <span class="price-amount">{{ $package['price'] }}</span>
                                <span class="price-unit">{{ $package['price_unit'] }}</span>
                            </div>
                        @endif
                        
                        @if(!empty($package['features']))
                            <ul class="package-card-features">
                                @foreach($package['features'] as $feature)
                                    <li class="package-feature-item">
                                        <span class="feature-check">✓</span>
                                        <span class="feature-text">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <a href="{{ $package['button_url'] }}" class="package-card-button">
                            {{ $package['button_text'] }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if(count($packages) > 0)
            <div class="package-cards-footer">
                <p class="package-cards-hint">{{ $footer_text }}</p>
            </div>
        @endif
    </div>
</section>

<style>
.package-cards-section {
    padding: 4rem 0;
    background: transparent;
}

.package-cards-container {
    max-width: 80rem;
    margin: 0 auto;
    padding: 0 1rem;
}

.package-cards-header {
    text-align: center;
    margin-bottom: 3rem;
}

.package-cards-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: {{ $titleColor }};
    margin: 0 0 1rem 0;
    line-height: 1.2;
}

.package-cards-description {
    font-size: 1.125rem;
    color: {{ $descriptionColor }};
    margin: 0 auto;
    max-width: 42rem;
    line-height: 1.6;
}

.package-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    max-width: 64rem;
    margin: 0 auto;
}

.package-card {
    position: relative;
    background: white;
    border-radius: 1.5rem;
    border: 2px solid rgba(6, 94, 69, 0.1);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.package-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(6, 94, 69, 0.15);
    border-color: rgba(6, 94, 69, 0.3);
}

.package-card-featured {
    border-color: #065e45;
    border-width: 3px;
    box-shadow: 0 8px 16px rgba(6, 94, 69, 0.1);
}

.package-card-featured::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(6, 94, 69, 0.03) 0%, rgba(10, 41, 24, 0.05) 100%);
    pointer-events: none;
}

.package-card-inner {
    position: relative;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.package-card-icon {
    width: 5rem;
    height: 5rem;
    border-radius: 1rem;
    background: {{ $iconBgColor }};
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 12px rgba(6, 94, 69, 0.2);
    transition: transform 0.3s ease;
}

.package-card:hover .package-card-icon {
    transform: scale(1.1) rotate(-5deg);
}

.package-icon-emoji {
    font-size: 2.5rem;
    filter: grayscale(1) brightness(10);
}

.package-card-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: {{ $titleColor }};
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.package-card-description {
    font-size: 0.9375rem;
    color: {{ $titleColor }};
    margin: 0 0 0.5rem 0;
    line-height: 1.5;
    opacity: 0.9;
}

.package-card-subtitle {
    font-size: 0.8125rem;
    color: {{ $subtitleColor }};
    font-weight: 600;
    font-style: italic;
    margin: 0 0 1.5rem 0;
    line-height: 1.4;
}

.package-card-price {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid rgba(6, 94, 69, 0.1);
}

.price-amount {
    font-size: 2rem;
    font-weight: 900;
    color: #065e45;
    line-height: 1;
}

.price-unit {
    font-size: 1rem;
    color: #065e45;
    opacity: 0.7;
}

.package-card-features {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem 0;
    flex: 1;
}

.package-feature-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.875rem;
    font-size: 0.9375rem;
    color: #0A2918;
    line-height: 1.5;
}

.feature-check {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    background: rgba(6, 94, 69, 0.1);
    color: #065e45;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.package-card:hover .feature-check {
    background: #065e45;
    color: white;
}

.feature-text {
    flex: 1;
}

.package-card-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 1rem 2rem;
    background: #065e45;
    color: white;
    text-decoration: none;
    border-radius: 0.75rem;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(6, 94, 69, 0.3);
    margin-top: auto;
}

.package-card-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(6, 94, 69, 0.4);
    background: #0A2918;
    color: white;
}

.package-card-button:active {
    transform: translateY(0);
}

.package-cards-footer {
    text-align: center;
    margin-top: 3rem;
}

.package-cards-hint {
    font-size: 0.875rem;
    color: #065e45;
    opacity: 0.7;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .package-cards-section {
        padding: 3rem 0;
    }
    
    .package-cards-title {
        font-size: 2rem;
    }
    
    .package-cards-description {
        font-size: 1rem;
    }
    
    .package-cards-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .package-card-inner {
        padding: 1.5rem;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .package-cards-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
