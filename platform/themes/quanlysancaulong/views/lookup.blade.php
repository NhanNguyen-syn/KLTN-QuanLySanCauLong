<main id="lookup-page" class="lookup-page" data-page="lookup">
    <section class="lookup-hero">
        <div class="lookup-hero__bg"></div>
        <div class="container">
            <div class="lookup-hero__inner">
                <div class="lookup-hero__icon" aria-hidden="true">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="2"/>
                        <path d="m21 21-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h1 class="lookup-hero__title">Tra Cứu Đặt Sân</h1>
                <p class="lookup-hero__desc">Nhập <strong>mã hóa đơn</strong> để xem chi tiết, tổng tiền và trạng thái mới nhất.</p>
            </div>
        </div>
    </section>

    <section class="lookup-main">
        <div class="container">
            <div class="lookup-box">
                <label class="lookup-label" for="order-code">Mã hóa đơn</label>
                <div class="lookup-form">
                    <div class="lookup-input">
                        <span class="lookup-input__icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" stroke="currentColor" stroke-width="2"/>
                                <path d="m21 21-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input id="order-code" type="text" placeholder="Ví dụ: BD-20251218-001" autocomplete="off" />
                    </div>
                    <button id="lookup-btn" type="button" class="lookup-btn" disabled>
                        <span class="lookup-btn__text">Tra cứu</span>
                    </button>
                </div>
                <p class="lookup-hint">Mã hóa đơn được hiển thị ở trang xác nhận và/hoặc gửi qua email/SMS (nếu cấu hình).</p>
            </div>

            <div id="lookup-result" class="lookup-result" hidden></div>
        </div>
    </section>
</main>

