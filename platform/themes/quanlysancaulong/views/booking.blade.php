@php $page = $page ?? null; @endphp
@if(!empty($page))
    @php
        $pageContent = do_shortcode($page->content ?? "");
    @endphp
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
@endif

<style>
    .booking-page .table-header-row {
        background: linear-gradient(90deg, #065e45 0%, #0b6f52 30%, #138262 60%, #1b9a76 80%, #26b98f 100%) !important;
    }
    .booking-page .court-header-cell {
        background-color: #065e45 !important;
    }
    .booking-page .time-header-cell {
        background-color: transparent !important;
    }
    .booking-page .booking-summary-bar {
        background: linear-gradient(90deg, #065e45 0%, #0b6f52 30%, #138262 60%, #1b9a76 80%, #26b98f 100%) !important;
    }
    /* Auth Prompt Styling */
    .auth-prompt-overlay {
        background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 50%, #f0f9ff 100%);
        padding: 60px 20px;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-prompt-card {
        background: white;
        border-radius: 24px;
        padding: 48px 40px;
        max-width: 520px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(6, 95, 70, 0.12);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .auth-prompt-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #065f46, #059669, #14b8a6);
    }
    .auth-prompt-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10b981, #14b8a6);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 50px;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.25);
    }
    .auth-prompt-title {
        font-size: 32px;
        font-weight: 900;
        margin: 0 0 12px 0;
        background: linear-gradient(135deg, #065f46, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .auth-prompt-subtitle {
        color: #6b7280;
        font-size: 16px;
        margin: 0 0 32px 0;
        line-height: 1.6;
    }
    .auth-prompt-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .auth-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 16px 32px;
        background: linear-gradient(90deg, #065f46, #059669, #14b8a6);
        background-size: 200% 100%;
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 800;
        font-size: 16px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 14px rgba(6, 95, 70, 0.3);
    }
    .auth-btn-primary:hover {
        background-position: 100% 0;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(6, 95, 70, 0.4);
        color: white;
    }
    .auth-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 16px 32px;
        background: white;
        color: #059669;
        border: 2px solid #059669;
        border-radius: 14px;
        font-weight: 800;
        font-size: 16px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .auth-btn-secondary:hover {
        background: #f0fdfa;
        color: #065f46;
        transform: translateY(-1px);
    }
    .auth-features {
        background: linear-gradient(180deg, #ecfeff, #f0fdfa);
        border: 2px solid #a7f3d0;
        border-radius: 16px;
        padding: 24px;
        margin-top: 32px;
        text-align: left;
    }
    .auth-features h3 {
        font-size: 16px;
        font-weight: 800;
        color: #065f46;
        margin: 0 0 16px 0;
        text-align: center;
    }
    .auth-features ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .auth-features li {
        padding: 10px 0;
        color: #047857;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .auth-features li::before {
        content: '✓';
        display: inline-flex;
        align items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        font-weight: 800;
        flex-shrink: 0;
    }
</style>

<main class="booking-page">
    @guest('member')
        <!-- Guest View: Require Login -->
        <div class="auth-prompt-overlay">
            <div class="auth-prompt-card">
                <div class="auth-prompt-icon">🏸</div>
                <h1 class="auth-prompt-title">Đăng Nhập Để Đặt Sân</h1>
                <p class="auth-prompt-subtitle">
                    Vui lòng đăng nhập để sử dụng chức năng đặt sân online. 
                    Nếu chưa có tài khoản, bạn có thể đăng ký miễn phí ngay!
                </p>
                
                <div class="auth-prompt-buttons">
                    <a href="{{ route('public.member.login') }}" class="auth-btn-primary">
                        <i class="ti ti-login"></i>
                        Đăng nhập ngay
                    </a>
                    <a href="{{ route('public.member.register') }}" class="auth-btn-secondary">
                        <i class="ti ti-user-plus"></i>
                        Đăng ký mới
                    </a>
                </div>

                <div class="auth-features">
                    <h3>🎁 Lợi ích khi đăng ký</h3>
                    <ul>
                        <li>Đặt sân online nhanh chóng, tiện lợi 24/7</li>
                        <li>Xem lịch sử đặt sân và hóa đơn chi tiết</li>
                        <li>Nhận thông báo và ưu đãi đặc biệt</li>
                        <li>Quản lý thông tin cá nhân dễ dàng</li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!-- Logged In: Show Booking Interface -->
        <div id="booking-page-app" data-courts='@json($courts ?? [])'></div>
    @endguest
</main>