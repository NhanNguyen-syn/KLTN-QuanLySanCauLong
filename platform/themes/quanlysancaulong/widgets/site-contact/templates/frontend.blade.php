<div class="footer-widget-col" style="flex: 0 0 auto; width: 240px;">
    @if ($config['name'])
        <h5 class="footer-widget-title fw-semibold mb-4 d-flex align-items-center">
            <span class="me-2 d-inline-block rounded-pill" style="width:4px;height:20px;background-color:#10b981"></span>
            {{ $config['name'] }}
        </h5>
    @endif
    
    <div class="footer-contact-list">
        @if ($config['address'])
            <div class="d-flex gap-2 mb-3 align-items-start">
                <span class="contact-icon d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:36px;height:36px;background:rgba(16,185,129,.1)">
                    @if($config['address_icon'])
                        <img src="{{ RvMedia::getImageUrl($config['address_icon']) }}" alt="Address icon" style="width:18px;height:18px;object-fit:contain;">
                    @else
                        <x-core::icon name="map-pin" class="text-success" />
                    @endif
                </span>
                <span class="small text-white-50">{{ $config['address'] }}</span>
            </div>
        @endif
        
        @if ($config['phone'])
            <div class="d-flex gap-2 mb-3 align-items-center">
                <span class="contact-icon d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:36px;height:36px;background:rgba(16,185,129,.1)">
                    @if($config['phone_icon'])
                        <img src="{{ RvMedia::getImageUrl($config['phone_icon']) }}" alt="Phone icon" style="width:18px;height:18px;object-fit:contain;">
                    @else
                        <x-core::icon name="phone" class="text-success" />
                    @endif
                </span>
                <a href="tel:{{ preg_replace('/\s+/', '', $config['phone']) }}" class="small text-white-50 text-decoration-none">{{ $config['phone'] }}</a>
            </div>
        @endif
        
        @if ($config['email'])
            <div class="d-flex gap-2 mb-3 align-items-center">
                <span class="contact-icon d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:36px;height:36px;background:rgba(16,185,129,.1)">
                    @if($config['email_icon'])
                        <img src="{{ RvMedia::getImageUrl($config['email_icon']) }}" alt="Email icon" style="width:18px;height:18px;object-fit:contain;">
                    @else
                        <x-core::icon name="mail" class="text-success" />
                    @endif
                </span>
                <a href="mailto:{{ $config['email'] }}" class="small text-white-50 text-decoration-none">{{ $config['email'] }}</a>
            </div>
        @endif

        @if ($config['operating_time'])
            <div class="small text-white-50 mt-3">
                <strong>{{ $config['operating_time'] }}</strong>
            </div>
        @endif
    </div>
</div>
