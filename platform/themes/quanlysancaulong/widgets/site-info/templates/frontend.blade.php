<div class="footer-widget-col" style="flex: 0 0 auto; width: 280px;">
    <div class="footer-brand mb-3">
        <a href="{{ BaseHelper::getHomepageUrl() }}" class="d-flex align-items-center gap-3 text-decoration-none text-white">
            @if($config['logo'])
                {{ RvMedia::image($config['logo'], theme_option('site_title'), attributes: $attributes) }}
            @else
                <div class="brand-icon d-flex align-items-center justify-content-center rounded-3 fw-bold" style="width:48px;height:48px;background-image:linear-gradient(to bottom right,#34d399,#059669)">
                    {{ Str::substr(theme_option('site_title', 'B'),0,1) }}
                </div>
            @endif
            <div>
                <span class="fw-bold fs-5 d-block">{{ theme_option('site_title', 'BadmintonPro') }}</span>
                <span class="small text-white-50" style="font-size: 0.813rem;">{{ __('Sân cầu lông Niên Thời') }}</span>
            </div>
        </a>
    </div>
    
    @if($config['about'])
        <p class="text-white-50 mb-3" style="font-size: 0.875rem; line-height: 1.6;">{{ $config['about'] }}</p>
    @endif
    
    @if($config['show_social_links'])
        <div class="footer-social d-flex gap-2">
            @for($i = 1; $i <= 4; $i++)
                @php
                    $icon = $config["social_link_{$i}_icon"] ?? null;
                    $url = $config["social_link_{$i}_url"] ?? null;
                @endphp
                @if($icon && $url)
                    <a href="{{ $url }}" target="_blank" rel="nofollow" class="social-icon-link d-inline-flex align-items-center justify-content-center rounded-2" style="width:36px;height:36px;background:#1e293b;transition:all 0.3s ease;">
                        <img src="{{ RvMedia::getImageUrl($icon) }}" alt="Social icon" style="width:18px;height:18px;object-fit:contain;filter:brightness(0.8);">
                    </a>
                @endif
            @endfor
        </div>
    @endif
</div>

<style>
.social-icon-link:hover {
    background: #10b981 !important;
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}
.social-icon-link:hover img {
    filter: brightness(1) !important;
}
</style>
