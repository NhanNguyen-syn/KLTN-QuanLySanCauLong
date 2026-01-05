        {{-- Redesigned footer (adapted from sample in /d) --}}
        <footer class="pt-5 text-white" style="background-color:#0f172a">
            <div class="container px-3 px-lg-4">
                <div class="row gy-5">
                    {{-- Company info --}}
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ BaseHelper::getHomepageUrl() }}" class="d-flex align-items-center gap-3 mb-4 text-decoration-none text-white">
                            {{-- Brand square (fallback to logo if available) --}}
                            @php($logo = Theme::getLogoImage(maxHeight:48))
                            @if($logo)
                                {!! $logo !!}
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded-3 fw-bold" style="width:48px;height:48px;background-image:linear-gradient(to bottom right,#34d399,#059669)">
                                    {{ Str::substr(theme_option('site_title', 'B'),0,1) }}
                                </div>
                            @endif
                            <div>
                                <span class="fw-bold fs-5 d-block">{{ theme_option('site_title', 'BadmintonPro') }}</span>
                                <span class="small text-white-50">{{ __('Professional badminton court') }}</span>
                            </div>
                        </a>
                        <p class="small text-white-50 mb-4">{{ __('International-standard badminton courts fully equipped to meet all your training and competition needs.') }}</p>
                        @if ($socialLinks = Theme::getSocialLinks())
                            <div class="d-flex gap-2">
                                @foreach($socialLinks as $socialLink)
                                    @continue(! $icon = $socialLink->getIconHtml())
                                    <a {{ $socialLink->getAttributes() }} class="footer-social d-inline-flex align-items-center justify-content-center rounded-2 text-white-50" style="width:40px;height:40px;background:rgba(255,255,255,.05)">
                                        {!! $icon !!}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Quick links --}}
                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-semibold mb-4 d-flex align-items-center">
                            <span class="me-2 d-inline-block rounded-pill" style="width:4px;height:20px;background-color:#10b981"></span>
                            {{ __('Explore') }}
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="/" class="text-white-50 text-decoration-none">{{ __('Home') }}</a></li>
                            <li class="mb-2"><a href="/dat-san" class="text-white-50 text-decoration-none">{{ __('Book a court') }}</a></li>
                            <li class="mb-2"><a href="/san-va-gia" class="text-white-50 text-decoration-none">{{ __('Courts & Pricing') }}</a></li>
                            <li class="mb-2"><a href="/goi-thanh-vien" class="text-white-50 text-decoration-none">{{ __('Membership') }}</a></li>
                            <li><a href="/ve-chung-toi" class="text-white-50 text-decoration-none">{{ __('About us') }}</a></li>
                        </ul>
                    </div>

                    {{-- Support links --}}
                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-semibold mb-4 d-flex align-items-center">
                            <span class="me-2 d-inline-block rounded-pill" style="width:4px;height:20px;background-color:#10b981"></span>
                            {{ __('Support') }}
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="/tieu-chuan-dich-vu" class="text-white-50 text-decoration-none">{{ __('Service standard') }}</a></li>
                            <li class="mb-2"><a href="/chinh-sach-huy-doi-hoan" class="text-white-50 text-decoration-none">{{ __('Refund / cancel policy') }}</a></li>
                            <li class="mb-2"><a href="/lien-he" class="text-white-50 text-decoration-none">{{ __('Contact support') }}</a></li>
                            <li class="mb-2"><a href="/tra-cuu" class="text-white-50 text-decoration-none">{{ __('Order lookup') }}</a></li>
                            <li><a href="#" class="text-white-50 text-decoration-none">{{ __('FAQ') }}</a></li>
                        </ul>
                    </div>

                    {{-- Contact info --}}
                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-semibold mb-4 d-flex align-items-center">
                            <span class="me-2 d-inline-block rounded-pill" style="width:4px;height:20px;background-color:#10b981"></span>
                            {{ __('Contact') }}
                        </h5>
                        <ul class="list-unstyled">
                            <li class="d-flex gap-2 mb-3">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:36px;height:36px;background:rgba(16,185,129,.1)"><x-core::icon name="map-pin" class="text-success" /></span>
                                <span class="small text-white-50">{{ __('123 Badminton St, Cau Giay, Hanoi') }}</span>
                            </li>
                            <li class="d-flex gap-2 mb-3">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:36px;height:36px;background:rgba(16,185,129,.1)"><x-core::icon name="phone" class="text-success" /></span>
                                <a href="tel:1800123456" class="small text-white-50 text-decoration-none">1800 123 456</a>
                            </li>
                            <li class="d-flex gap-2">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:36px;height:36px;background:rgba(16,185,129,.1)"><x-core::icon name="mail" class="text-success" /></span>
                                <a href="mailto:info@badmintonpro.vn" class="small text-white-50 text-decoration-none">info@badmintonpro.vn</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- bottom bar --}}
            <div class="mt-5" style="background-color:#0a101f">
                <div class="container py-3">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 small text-white-50">
                        <span>© {{ date('Y') }} {{ theme_option('site_title', 'BadmintonPro') }}. {{ __('All rights reserved.') }}</span>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="/chinh-sach-huy-doi-hoan" class="text-white-50 text-decoration-none">{{ __('Privacy policy') }}</a>
                            <a href="#" class="text-white-50 text-decoration-none">{{ __('Terms of use') }}</a>
                            <a href="#" class="text-white-50 text-decoration-none">Cookie</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer


            <!-- Booking summary script is lightweight and safe to include globally -->
            <script src="{{ Theme::asset()->url('js/booking-summary.js') }}"></script>
        {!! Theme::footer() !!}
    </body>
</html>
