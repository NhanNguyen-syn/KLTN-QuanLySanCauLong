@php
    Theme::set('pageTitle', 'Sân & Giá');

    $courts = \Botble\CourtBooking\Models\Court::query()
        ->with('type', 'courtStatus')
        ->where('status', 'published')
        ->orderBy('order', 'asc')
        ->get();
@endphp

<style>
    /* Hero Section */
    .courts-hero {
        position: relative;
        padding: 80px 0 100px;
        background: linear-gradient(135deg, #065f46 0%, #059669 50%, #14b8a6 100%);
        color: white;
        text-align: center;
        overflow: hidden;
    }

    .courts-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .courts-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .courts-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
    }

    .courts-hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto 24px;
        position: relative;
        z-index: 1;
    }

    .courts-hero .hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #059669;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .courts-hero .hero-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    /* Courts Grid */
    .courts-grid-section {
        padding: 60px 0 80px;
        background: #f8fafc;
    }

    .courts-grid-section .section-title {
        text-align: center;
        margin-bottom: 48px;
    }

    .courts-grid-section .section-title h2 {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 12px;
    }

    .courts-grid-section .section-title p {
        font-size: 1rem;
        color: #6b7280;
        max-width: 600px;
        margin: 0 auto;
    }

    .courts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    @media (max-width: 1199px) {
        .courts-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 991px) {
        .courts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 575px) {
        .courts-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Court Card */
    .court-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(229, 231, 235, 0.5);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .court-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        border-color: transparent;
    }

    .court-card:hover .court-card-image img {
        transform: scale(1.08);
    }

    .court-card:hover .court-card-title {
        color: #059669;
    }

    .court-card-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .court-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .court-card-image .court-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 0%, transparent 60%);
        opacity: 0.6;
    }

    .court-card-image .court-card-tags {
        position: absolute;
        bottom: 12px;
        left: 12px;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .court-card-tag {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        color: #1f2937;
    }

    .court-card-body {
        padding: 20px;
    }

    .court-card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
        transition: color 0.2s ease;
    }

    .court-card-address {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0;
    }

    .court-card-footer {
        padding: 16px 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .court-card-price-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }

    .court-card-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .court-card-price span {
        font-size: 0.8rem;
        font-weight: 400;
        color: #6b7280;
    }

    .court-card-arrow {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(5, 150, 105, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #059669;
        transition: all 0.3s ease;
    }

    .court-card:hover .court-card-arrow {
        background: #059669;
        color: white;
    }

    /* Pricing Section */
    .pricing-section {
        padding: 80px 0;
        background: white;
    }

    .pricing-section .section-title {
        text-align: center;
        margin-bottom: 48px;
    }

    .pricing-section .section-title h2 {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 12px;
    }

    .pricing-section .section-title p {
        font-size: 1rem;
        color: #6b7280;
    }

    .pricing-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        max-width: 900px;
        margin: 0 auto;
    }

    @media (max-width: 767px) {
        .pricing-cards {
            grid-template-columns: 1fr;
        }
    }

    .pricing-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .pricing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .pricing-card.featured {
        transform: scale(1.03);
    }

    .pricing-card.featured:hover {
        transform: scale(1.03) translateY(-4px);
    }

    .pricing-card-popular {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #1f2937;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 20px;
        z-index: 2;
    }

    .pricing-card-header {
        position: relative;
        padding: 32px;
        color: white;
    }

    .pricing-card-header.guest {
        background: linear-gradient(135deg, #059669, #14b8a6, #2dd4bf);
    }

    .pricing-card-header.member {
        background: linear-gradient(135deg, #065f46, #047857, #059669);
    }

    .pricing-card-header h3 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .pricing-card-type {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .pricing-card-amount {
        display: flex;
        align-items: baseline;
        gap: 4px;
        margin-bottom: 8px;
    }

    .pricing-card-amount .number {
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .pricing-card-amount .unit {
        font-size: 1.1rem;
        font-weight: 700;
    }

    .pricing-card-amount .per {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-left: 4px;
    }

    .pricing-card-desc {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .pricing-card-features {
        padding: 32px;
        background: white;
    }

    .pricing-card-feature {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 0.9rem;
        color: #374151;
    }

    .pricing-card-feature i {
        color: #059669;
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .pricing-card-cta {
        padding: 0 32px 32px;
        background: white;
    }

    .pricing-card-cta a {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        color: #1f2937;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pricing-card-cta a:hover {
        border-color: #059669;
        color: #059669;
    }

    /* CTA Section */
    .courts-cta-section {
        padding: 60px 0;
        background: #f0fdfa;
        text-align: center;
    }

    .courts-cta-section a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #065f46;
        color: white;
        padding: 14px 36px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(6, 95, 70, 0.3);
    }

    .courts-cta-section a:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(6, 95, 70, 0.4);
    }
</style>

<!-- Hero Section -->
<section class="courts-hero">
    <div class="container">
        <h1>Hệ Thống Sân Cầu Lông<br>Chất Lượng Quốc Tế</h1>
        <p>Giá chuẩn, minh bạch. Khám phá từng sân và đặt sân trực tuyến ngay hôm nay.</p>
        <a href="{{ route('public.booking') }}" class="hero-btn">
            <i class="ti ti-calendar-plus"></i>
            Đặt Sân Ngay
        </a>
    </div>
</section>

<!-- Pricing Plans -->
<section class="pricing-section">
    <div class="container">
        <div class="section-title">
            <h2>Bảng Giá Chi Tiết</h2>
            <p>Lựa chọn gói phù hợp với nhu cầu chơi cầu lông của bạn</p>
        </div>

        <div class="pricing-cards">
            <!-- Khách Vãng Lai -->
            <div class="pricing-card">
                <div class="pricing-card-header guest">
                    <h3>Khách Vãng Lai</h3>
                    <div class="pricing-card-type">Theo giờ</div>
                    <div class="pricing-card-amount">
                        <span class="number">150</span>
                        <span class="unit">.000đ</span>
                        <span class="per">/giờ</span>
                    </div>
                    <p class="pricing-card-desc">Đặt sân linh hoạt, phù hợp chơi thỉnh thoảng</p>
                </div>
                <div class="pricing-card-features">
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Sân gỗ tiêu chuẩn quốc tế</span>
                    </div>
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Chiếu sáng LED chuyên nghiệp</span>
                    </div>
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Điều hòa không khí</span>
                    </div>
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Phòng thay đồ tiện nghi</span>
                    </div>
                </div>
                <div class="pricing-card-cta">
                    <a href="{{ route('public.booking') }}">
                        Bắt Đầu Ngay
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Khách Cố Định -->
            <div class="pricing-card featured" style="position: relative;">
                <div class="pricing-card-popular">PHỔ BIẾN NHẤT</div>
                <div class="pricing-card-header member">
                    <h3>Khách Cố Định</h3>
                    <div class="pricing-card-type">Thành viên</div>
                    <div class="pricing-card-amount">
                        <span class="number">120</span>
                        <span class="unit">.000đ</span>
                        <span class="per">/giờ</span>
                    </div>
                    <p class="pricing-card-desc">Tiết kiệm 20%, ưu đãi đặc biệt và dịch vụ VIP</p>
                </div>
                <div class="pricing-card-features">
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Tất cả quyền lợi khách vãng lai</span>
                    </div>
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Ưu tiên đặt sân giờ đẹp</span>
                    </div>
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Nước uống & ăn nhẹ miễn phí</span>
                    </div>
                    <div class="pricing-card-feature">
                        <i class="ti ti-circle-check-filled"></i>
                        <span>Hỗ trợ huấn luyện cá nhân</span>
                    </div>
                </div>
                <div class="pricing-card-cta">
                    <a href="{{ route('public.booking') }}">
                        Bắt Đầu Ngay
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courts Grid -->
<section class="courts-grid-section">
    <div class="container">
        <div class="section-title">
            <h2>Khám Phá & Đặt Sân Cầu Lông</h2>
            <p>Khám phá sân cầu lông lý tưởng, phù hợp lịch trình và sở thích của bạn. Mỗi sân đều đạt chuẩn chuyên nghiệp.</p>
        </div>

        <div class="courts-grid">
            @foreach($courts as $court)
                @php
                    $courtSlug = $court->slug ?: \Illuminate\Support\Str::slug($court->name);
                    $courtImage = $court->image ? \Botble\Media\Facades\RvMedia::getImageUrl($court->image) : asset('themes/quanlysancaulong/images/placeholder-court.jpg');
                    $timeSlots = $court->time_display ? explode(',', $court->time_display) : [];
                @endphp
                <a href="{{ url('san-va-gia/' . $courtSlug) }}" class="court-card">
                    <!-- Image -->
                    <div class="court-card-image">
                        <img src="{{ $courtImage }}" alt="{{ $court->name }}" loading="lazy">
                        <div class="court-card-overlay"></div>
                        @if(count($timeSlots) > 0)
                            <div class="court-card-tags">
                                @foreach(array_slice($timeSlots, 0, 2) as $slot)
                                    <span class="court-card-tag">{{ trim($slot) }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="court-card-body">
                        <h3 class="court-card-title">{{ $court->name }}</h3>
                        <p class="court-card-address">
                            {{ $court->address ?: theme_option('address', '123 Đường Cầu Lông') }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="court-card-footer">
                        <div>
                            <div class="court-card-price-label">Giá bắt đầu từ</div>
                            <div class="court-card-price">
                                {{ number_format($court->default_price ?: 150000, 0, ',', '.') }}đ<span>/giờ</span>
                            </div>
                        </div>
                        <div class="court-card-arrow">
                            <i class="ti ti-arrow-right" style="font-size: 20px;"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="courts-cta-section">
    <a href="{{ route('public.booking') }}">
        <i class="ti ti-calendar-plus"></i>
        Đặt Sân Ngay
    </a>
</section>
