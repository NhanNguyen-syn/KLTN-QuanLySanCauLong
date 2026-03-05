@php
    Theme::set('pageTitle', $court->name . ' - Chi tiết sân');
    $courtImage = $court->image ? \Botble\Media\Facades\RvMedia::getImageUrl($court->image) : asset('themes/quanlysancaulong/images/placeholder-court.jpg');
    $gallery = is_array($court->gallery) ? $court->gallery : [];
    $features = is_array($court->features) ? $court->features : [];
    $allImages = array_values(array_filter(array_merge([$court->image], $gallery)));
    $allCourts = \Botble\CourtBooking\Models\Court::query()
        ->where('status', 'published')
        ->orderBy('order', 'asc')
        ->get();
    $courtStatusName = optional($court->courtStatus)->name ?? 'Đang hoạt động';
@endphp

<style>
    /* Breadcrumb */
    .court-breadcrumb {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 0;
    }
    .court-breadcrumb nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6b7280;
    }
    .court-breadcrumb a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }
    .court-breadcrumb a:hover { color: #1f2937; }
    .court-breadcrumb .current { color: #1f2937; font-weight: 600; }

    /* Court Header */
    .court-header-section {
        background: #f8fafc;
        padding: 32px 0 40px;
    }
    .court-header-top {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
    }
    .court-header-info h1 {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .court-status-badge {
        display: inline-flex;
        align-items: center;
        background: #059669;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .court-header-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .court-header-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #6b7280;
    }
    .court-header-meta-item i { font-size: 16px; }
    .court-header-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #065f46;
        color: white !important;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(6, 95, 70, 0.3);
    }
    .court-header-cta:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(6, 95, 70, 0.4);
    }

    /* Gallery */
    .court-gallery { margin-bottom: 0; }
    .court-gallery-main {
        position: relative;
        width: 100%;
        height: 350px;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 12px;
        background: #111827;
    }
    @media (min-width: 768px) {
        .court-gallery-main { height: 450px; }
    }
    .court-gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: opacity 0.5s ease;
    }
    .court-gallery-thumbs {
        display: flex;
        gap: 12px;
    }
    .court-gallery-thumb {
        position: relative;
        width: 80px;
        height: 56px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        opacity: 0.6;
        transition: all 0.2s ease;
    }
    @media (min-width: 768px) {
        .court-gallery-thumb { width: 100px; height: 68px; }
    }
    .court-gallery-thumb.active {
        border-color: #059669;
        opacity: 1;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.3);
    }
    .court-gallery-thumb:hover { opacity: 0.9; }
    .court-gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Content Layout */
    .court-content-section { padding: 48px 0 64px; }
    .court-content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }
    @media (min-width: 992px) {
        .court-content-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    /* Content Cards */
    .court-content-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        padding: 28px 32px;
    }
    .court-content-card h2 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
    }
    .court-content-card p {
        color: #6b7280;
        line-height: 1.7;
    }

    /* Specs Grid */
    .court-specs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    @media (max-width: 575px) {
        .court-specs-grid { grid-template-columns: 1fr; }
    }
    .court-spec-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
    }
    .court-spec-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(5, 150, 105, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .court-spec-icon i { font-size: 20px; color: #059669; }
    .court-spec-label {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 2px;
    }
    .court-spec-value {
        font-size: 13px;
        color: #6b7280;
    }

    /* Features List */
    .court-features-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .court-features-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        font-size: 14px;
        color: #374151;
    }
    .court-features-list li i {
        color: #059669;
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Amenities */
    .court-amenities-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    @media (max-width: 767px) {
        .court-amenities-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .court-amenity-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        text-align: center;
    }
    .court-amenity-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(5, 150, 105, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .court-amenity-icon i { font-size: 22px; color: #059669; }
    .court-amenity-label { font-size: 13px; font-weight: 500; color: #1f2937; }

    /* Sidebar */
    .court-sidebar { position: sticky; top: 100px; }
    .court-sidebar-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        margin-bottom: 20px;
    }
    .court-sidebar-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
    }

    /* Pricing rows */
    .court-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
    }
    .court-price-label { font-size: 14px; color: #6b7280; }
    .court-price-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }
    .court-price-value span { font-size: 0.8rem; font-weight: 400; color: #6b7280; }
    .court-price-value.member { color: #059669; }
    .court-price-discount {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 12px;
        margin-left: 8px;
    }

    /* Hours */
    .court-hours-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 12px;
    }
    .court-hours-box i { font-size: 20px; color: #059669; }
    .court-hours-title { font-size: 14px; font-weight: 600; color: #1f2937; }
    .court-hours-sub { font-size: 12px; color: #6b7280; }

    /* CTA buttons */
    .court-sidebar-cta {
        padding-top: 8px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .btn-book-now {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px;
        background: #065f46;
        color: white !important;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(6, 95, 70, 0.3);
    }
    .btn-book-now:hover {
        background: #047857;
        box-shadow: 0 8px 25px rgba(6, 95, 70, 0.4);
    }
    .btn-view-all {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px;
        background: transparent;
        color: #1f2937 !important;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-view-all:hover {
        border-color: #059669;
        color: #059669 !important;
    }

    /* Quick Nav */
    .court-quick-nav {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    .court-quick-nav a {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        background: #f8fafc;
        color: #1f2937;
    }
    .court-quick-nav a:hover {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
    }
    .court-quick-nav a.active {
        background: #065f46;
        color: white;
        box-shadow: 0 2px 8px rgba(6, 95, 70, 0.3);
    }

    /* Mobile CTA */
    .court-mobile-cta {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid #e5e7eb;
        padding: 16px;
        z-index: 50;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
    }
    @media (max-width: 991px) {
        .court-mobile-cta { display: flex; align-items: center; gap: 12px; }
        .court-content-section { padding-bottom: 100px; }
    }
    .court-mobile-cta .mobile-price { flex: 1; }
    .court-mobile-cta .mobile-price-label { font-size: 12px; color: #6b7280; }
    .court-mobile-cta .mobile-price-value { font-size: 1.1rem; font-weight: 700; color: #1f2937; }
    .court-mobile-cta .mobile-price-value span { font-size: 0.8rem; font-weight: 400; color: #6b7280; }
</style>

<!-- Breadcrumb -->
<section class="court-breadcrumb">
    <div class="container">
        <nav>
            <a href="{{ BaseHelper::getHomepageUrl() }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ url('/san-gia') }}">Sân & Giá</a>
            <span>/</span>
            <span class="current">{{ $court->name }}</span>
        </nav>
    </div>
</section>

<!-- Court Header -->
<section class="court-header-section">
    <div class="container">
        <div class="court-header-top">
            <div class="court-header-info">
                <h1>
                    {{ $court->name }}
                    <span class="court-status-badge">{{ $courtStatusName }}</span>
                </h1>
                <div class="court-header-meta">
                    <div class="court-header-meta-item">
                        <i class="ti ti-map-pin"></i>
                        <span>{{ $court->address ?: theme_option('address', 'Sân cầu lông Niên Thời') }}</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('public.booking') }}" class="court-header-cta d-none d-md-inline-flex">
                Đặt Sân Ngay
                <i class="ti ti-arrow-right"></i>
            </a>
        </div>

        <!-- Image Gallery -->
        <div class="court-gallery">
            <div class="court-gallery-main">
                @if(count($allImages) > 0)
                    <img id="galleryMainImage"
                         src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($allImages[0]) }}"
                         alt="{{ $court->name }}">
                @else
                    <img src="{{ $courtImage }}" alt="{{ $court->name }}">
                @endif
            </div>
            @if(count($allImages) > 1)
                <div class="court-gallery-thumbs">
                    @foreach($allImages as $index => $img)
                        <div class="court-gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                             onclick="changeGalleryImage(this, '{{ \Botble\Media\Facades\RvMedia::getImageUrl($img) }}')">
                            <img src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($img) }}" alt="{{ $court->name }} - Ảnh {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Content -->
<section class="court-content-section">
    <div class="container">
        <div class="court-content-grid">
            <!-- Main Content -->
            <div>
                <!-- Description -->
                @if($court->description)
                    <div class="court-content-card" style="margin-bottom: 24px;">
                        <h2>Giới thiệu</h2>
                        <p>{{ $court->description }}</p>
                    </div>
                @endif

                <!-- Specifications -->
                @if($court->court_size || $court->surface || $court->lighting || $court->air_conditioned)
                    <div class="court-content-card" style="margin-bottom: 24px;">
                        <h2>Thông số kỹ thuật</h2>
                        <div class="court-specs-grid">
                            @if($court->court_size)
                                <div class="court-spec-item">
                                    <div class="court-spec-icon"><i class="ti ti-ruler-2"></i></div>
                                    <div>
                                        <div class="court-spec-label">Kích thước sân</div>
                                        <div class="court-spec-value">{{ $court->court_size }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($court->surface)
                                <div class="court-spec-item">
                                    <div class="court-spec-icon"><i class="ti ti-shield-check"></i></div>
                                    <div>
                                        <div class="court-spec-label">Mặt sân</div>
                                        <div class="court-spec-value">{{ $court->surface }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($court->lighting)
                                <div class="court-spec-item">
                                    <div class="court-spec-icon"><i class="ti ti-bulb"></i></div>
                                    <div>
                                        <div class="court-spec-label">Chiếu sáng</div>
                                        <div class="court-spec-value">{{ $court->lighting }}</div>
                                    </div>
                                </div>
                            @endif
                            <div class="court-spec-item">
                                <div class="court-spec-icon"><i class="ti ti-temperature"></i></div>
                                <div>
                                    <div class="court-spec-label">Điều hòa</div>
                                    <div class="court-spec-value">{{ $court->air_conditioned ? 'Có - Nhiệt độ 24-26°C' : 'Không có' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Features -->
                @if(count($features) > 0)
                    <div class="court-content-card" style="margin-bottom: 24px;">
                        <h2>Tính năng đặc biệt</h2>
                        <ul class="court-features-list">
                            @foreach($features as $feature)
                                <li>
                                    <i class="ti ti-circle-check-filled"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Amenities -->
                <div class="court-content-card">
                    <h2>Tiện ích chung</h2>
                    <div class="court-amenities-grid">
                        <div class="court-amenity-item">
                            <div class="court-amenity-icon"><i class="ti ti-wifi"></i></div>
                            <span class="court-amenity-label">WiFi miễn phí</span>
                        </div>
                        <div class="court-amenity-item">
                            <div class="court-amenity-icon"><i class="ti ti-car"></i></div>
                            <span class="court-amenity-label">Bãi đỗ xe rộng</span>
                        </div>
                        <div class="court-amenity-item">
                            <div class="court-amenity-icon"><i class="ti ti-bath"></i></div>
                            <span class="court-amenity-label">Phòng tắm & thay đồ</span>
                        </div>
                        <div class="court-amenity-item">
                            <div class="court-amenity-icon"><i class="ti ti-armchair-2"></i></div>
                            <span class="court-amenity-label">Khu vực nghỉ chân</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="court-sidebar">
                <!-- Pricing -->
                <div class="court-sidebar-card">
                    <h3>Bảng giá</h3>
                    <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 16px; margin-bottom: 16px;">
                        <div class="court-price-row">
                            <span class="court-price-label">Chơi nhanh</span>
                            <span class="court-price-value">
                                {{ number_format($court->default_price ?: 140000, 0, ',', '.') }}đ<span>/giờ</span>
                            </span>
                        </div>
                        <div class="court-price-row">
                            <span class="court-price-label">
                                Chơi dài giờ
                                <span class="court-price-discount">-14%</span>
                            </span>
                            <span class="court-price-value member">
                                {{ number_format($court->member_price ?: 120000, 0, ',', '.') }}đ<span>/giờ</span>
                            </span>
                        </div>
                    </div>

                    <!-- Hours -->
                    <div style="margin-bottom: 20px;">
                        <h3>Giờ hoạt động</h3>
                        <div class="court-hours-box">
                            <i class="ti ti-clock"></i>
                            <div>
                                <div class="court-hours-title">{{ $court->availability ?: '5:00 - 22:30 hàng ngày' }}</div>
                                <div class="court-hours-sub">Bao gồm cả ngày lễ và cuối tuần</div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="court-sidebar-cta">
                        <a href="{{ route('public.booking') }}" class="btn-book-now">
                            Đặt Sân Ngay
                            <i class="ti ti-arrow-right"></i>
                        </a>
                        <a href="{{ url('/san-gia') }}" class="btn-view-all">
                            <i class="ti ti-arrow-left"></i>
                            Xem tất cả sân
                        </a>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="court-sidebar-card">
                    <h3>Chuyển nhanh sang sân khác</h3>
                    <div class="court-quick-nav">
                        @foreach($allCourts as $c)
                            @php
                                $cSlug = $c->slug ?: \Illuminate\Support\Str::slug($c->name);
                            @endphp
                            <a href="{{ url('san-gia/' . $cSlug) }}"
                               class="{{ $c->id === $court->id ? 'active' : '' }}">
                                {{ preg_replace('/^Sân\s*/i', 'S', $c->name) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mobile CTA -->
<div class="court-mobile-cta">
    <div class="mobile-price">
        <div class="mobile-price-label">Giá từ</div>
        <div class="mobile-price-value">
            {{ number_format($court->member_price ?: 120000, 0, ',', '.') }}đ<span>/giờ</span>
        </div>
    </div>
    <a href="{{ route('public.booking') }}" class="btn-book-now" style="flex: 0 0 auto; width: auto; padding: 12px 24px;">
        Đặt Sân
        <i class="ti ti-arrow-right"></i>
    </a>
</div>

<script>
    function changeGalleryImage(thumb, imageUrl) {
        // Update main image
        document.getElementById('galleryMainImage').src = imageUrl;

        // Update active thumb
        document.querySelectorAll('.court-gallery-thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }
</script>
