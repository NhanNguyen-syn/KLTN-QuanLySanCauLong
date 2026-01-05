{!! dynamic_sidebar('top_sidebar') !!}
@if(!empty($page))
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $page->content, $page) !!}
@endif

<section class="checkout-section">
    <style>
        .checkout-section{padding:40px 0}
        .checkout-section .container{max-width:1120px;margin:0 auto;padding:0 16px}
        .checkout-grid{display:grid;grid-template-columns:1fr;gap:24px}
        @media(min-width:992px){.checkout-grid{grid-template-columns:2fr 1fr}}
        .card{background:#fff;border:1px solid #f0f0f0;border-radius:16px;padding:22px;box-shadow:0 2px 8px rgba(0,0,0,.05); margin-bottom: 30px;}
        .card h3{margin:0 0 14px 0;font-weight:800}
        .radio-opt{display:block;border:2px solid #e5e7eb;border-radius:12px;padding:16px;cursor:pointer;margin-bottom:12px}
        .radio-opt.is-active{background:linear-gradient(180deg,rgba(16,185,129,.08),rgba(20,184,166,.08));border-color:#10b981}
        .radio-opt:hover{border-color:#10b981}
        .field-title{font-size:14px;color:#6b7280;font-weight:700;text-transform:uppercase}
        .summary{position:sticky;top:24px}
        .row{display:flex;justify-content:space-between;margin:8px 0}
        .total{display:flex;justify-content:space-between;border-top:2px solid #e5e7eb;margin-top:12px;padding-top:12px;font-weight:800}
        .pay-btn{width:100%;background:linear-gradient(90deg,#0E6B5C,#1DB9A2);color:#fff;border:none;border-radius:12px;padding:14px 18px;font-weight:800}
        .success-wrap{text-align:center;padding:60px 0}
        .success-badge{width:96px;height:96px;border-radius:999px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:42px}
        .muted{color:#6b7280}
        .radio-opt input[type="radio"]{display:none}
        .radio-icon{width:20px;height:20px;border-radius:999px;border:2px solid #e5e7eb;display:inline-block;position:relative;transition:all .2s}
        .radio-opt.is-active .radio-icon{border-color:#10b981}
        .radio-icon::after{content:'';display:block;width:10px;height:10px;border-radius:999px;background-color:#10b981;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) scale(0);transition:all .2s}
        .radio-opt.is-active .radio-icon::after{transform:translate(-50%,-50%) scale(1)}
    </style>
    <div class="container">

        <div id="checkout-content" class="checkout-grid">
            <div class="left">
                <form id="checkout-form" class="space-y">
                    <div class="card">
                        <h3>Phương Thức Thanh Toán</h3>
                        <label class="radio-opt" data-method="bank-transfer">
                            <div style="display:flex;gap:10px;align-items:flex-start">
                                <input type="radio" name="paymentMethod" value="bank-transfer" checked style="margin-top:4px">
                                <div style="flex:1">
                                    <div style="font-weight:700; display:flex; align-items:center; gap: 8px; margin-bottom: 4px;">
                                        <span class="radio-icon"></span>
                                        <span>Chuyển khoản ngân hàng</span>
                                    </div>
                                    <div class="muted" style="font-size:14px; padding-left: 28px;">Chuyển khoản trực tiếp qua ngân hàng (Vietcombank)</div>
                                </div>
                            </div>
                        </label>
                        <label class="radio-opt" data-method="vnpay">
                            <div style="display:flex;gap:10px;align-items:flex-start">
                                <input type="radio" name="paymentMethod" value="vnpay" style="margin-top:4px">
                                <div style="flex:1">
                                    <div style="font-weight:700; display:flex; align-items:center; gap: 8px; margin-bottom: 4px;">
                                        <span class="radio-icon"></span>
                                        <span>VNPay</span>
                                    </div>
                                    <div class="muted" style="font-size:14px; padding-left: 28px;">Thanh toán qua ví VNPay / ứng dụng ngân hàng</div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div id="payment-type-card" class="card">
                        <h3>Hình Thức Thanh Toán</h3>
                        <label class="radio-opt" data-type="full">
                            <div style="display:flex;gap:10px;align-items:flex-start">
                                <input type="radio" name="paymentType" value="full" checked>
                                <div style="flex:1">
                                    <div style="font-weight:700; display:flex; align-items:center; gap: 8px; margin-bottom: 4px;">
                                        <span class="radio-icon"></span>
                                        <span>Thanh toán toàn bộ</span>
                                    </div>
                                    <div class="muted" style="font-size:14px; padding-left: 28px;">Thanh toán 100% giá sân</div>
                                </div>
                            </div>
                        </label>
                        <label class="radio-opt" data-type="deposit">
                            <div style="display:flex;gap:10px;align-items:flex-start">
                                <input type="radio" name="paymentType" value="deposit">
                                <div style="flex:1">
                                    <div style="font-weight:700; display:flex; align-items:center; gap: 8px; margin-bottom: 4px;">
                                        <span class="radio-icon"></span>
                                        <span>Đặt cọc 30%</span>
                                    </div>
                                    <div class="muted" style="font-size:14px; padding-left: 28px;">Trả trước 30%, phần còn lại khi sử dụng</div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div id="bank-detail-card" class="card">
                        <h3>Chi Tiết Chuyển Khoản</h3>
                        <div class="card" style="background:linear-gradient(135deg, #f0fdfa, #f0fdfa); border-color:#a7f3d0; padding: 24px;">
                            <div style="margin-bottom: 16px;">
                                <div class="field-title">Ngân hàng</div>
                                <strong style="font-size: 1.125rem;">Vietcombank (VCB)</strong>
                            </div>
                            <div style="margin-bottom: 16px;">
                                <div class="field-title">Số tài khoản</div>
                                <strong style="font-size: 1.25rem; font-family: ui-monospace, monospace; color: #047857;">0123456789</strong>
                            </div>
                            <div style="margin-bottom: 16px;">
                                <div class="field-title">Chủ tài khoản</div>
                                <strong style="font-size: 1.125rem;">BADMINTON COURT CENTER</strong>
                            </div>
                            <div>
                                <div class="field-title">Nội dung chuyển khoản</div>
                                <div style="font-family:ui-monospace,monospace;font-weight:800;background:#fff;padding:12px;border-radius:8px; border: 1px solid #a7f3d0; margin-top: 4px;" id="transfer-note">[TEN BAN] - DAT SAN</div>
                            </div>
                        </div>
                    </div>

                    <div id="vnpay-card" class="card" style="display:none">
                        <h3>Thanh Toán VNPay</h3>
                        <div class="card" style="background:#eef6ff;border-color:#c7ddff">
                            <p class="muted" style="margin:0 0 8px 0">Bạn sẽ được chuyển đến cổng VNPay để hoàn tất giao dịch an toàn.</p>
                            <div class="muted" style="font-size:14px">• Bảo mật cao với mã hoá SSL</div>
                        </div>
                    </div>

                    <button type="submit" class="pay-btn" id="pay-btn">Xác Nhận Thanh Toán</button>
                </form>
            </div>
            <div class="right">
                <div class="card summary" id="summary-card">
                    <h3>Tóm Tắt Đơn Hàng</h3>
                    <div id="summary-personal" style="margin-bottom:12px;border-bottom:1px solid #eee;padding-bottom:12px;display:none"></div>
                    <div id="summary-booking" style="margin-bottom:12px;border-bottom:1px solid #eee;padding-bottom:12px;display:none"></div>
                    <div class="row"><span class="muted">Tổng tiền sân:</span><strong id="sum-total">0đ</strong></div>
                    <div class="row" id="sum-deposit-wrap" style="display:none"><span class="muted">Đặt cọc 30%:</span><strong id="sum-deposit">0đ</strong></div>
                    <div class="row" id="sum-remaining-wrap" style="display:none"><span class="muted">Còn lại khi đến sân:</span><strong id="sum-remaining">0đ</strong></div>
                    <div class="total"><span>Cần thanh toán:</span><span id="sum-pay">0đ</span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const qs = s=>document.querySelector(s); const qsa = s=>Array.from(document.querySelectorAll(s));
            const fmt = n=>{try{return Number(n||0).toLocaleString('vi-VN')+'đ'}catch(e){return '0đ'}};
            // personalInfo can be stored as field_1 (name), field_2 (email), field_3 (phone)
            const getName = p => (p?.field_1 || p?.fullName || p?.name || p?.full_name || p?.hoTen || p?.ten || '').toString().trim();
            const getPhone = p => (p?.field_3 || p?.phone || p?.sdt || p?.so_dien_thoai || p?.mobile || '').toString().trim();
            const getEmail = p => (p?.field_2 || p?.email || p?.mail || '').toString().trim();

            const state = { personal:null, booking:[], customer:null, method:'bank-transfer', type:'full' };
            try{ state.personal = JSON.parse(localStorage.getItem('personalInfo')||'null'); }catch(e){}

            // Tìm dữ liệu đặt sân trong localStorage theo nhiều khóa
            const parseJSON = (text)=>{ try{ return JSON.parse(text); }catch{ return null } };
            const findBooking = ()=>{
                const candidates = ['tempBooking','bookingData','booking','bookings','selectedCourts'];
                for(const k of candidates){
                    const raw = localStorage.getItem(k);
                    if(!raw) continue;
                    const data = parseJSON(raw);
                    if(Array.isArray(data) && data.length){ console.log('[CHECKOUT] booking loaded from', k, data); return {data, key:k}; }
                    if(Array.isArray(data)) { console.log('[CHECKOUT] booking key', k, 'exists but empty'); }
                }
                console.warn('[CHECKOUT] No booking data found in localStorage. Keys:', Object.keys(localStorage||{}));
                return {data:[], key:null};
            };
            const found = findBooking();
            state.booking = found.data;

            try{ state.customer = JSON.parse(localStorage.getItem('customerData')||'null'); }catch(e){}

            const isCasual = !state.customer || state.customer.customerType === 'casual';
            // Luôn hiển thị thẻ chọn hình thức thanh toán, cho phép chọn Đặt cọc cho mọi đối tượng
            qs('#payment-type-card').style.display='block';
            const depositInput = document.querySelector('input[name="paymentType"][value="deposit"]');
            if(depositInput) depositInput.disabled = false;

            const calcTotal = ()=> state.booking.reduce((s,it)=>s+(Number(it.price)||0),0);
            const total = calcTotal();
            const deposit = Math.round(total * 0.3);

            // Fill transfer note
            qs('#transfer-note').textContent = (getName(state.personal)||'[TÊN BẠN]') + ' - ĐẶT SÂN';

            const updateSummary = ()=>{
                qs('#sum-total').textContent = fmt(total);
                const payType = state.type;
                const showDeposit = payType === 'deposit';
                const needPay = showDeposit ? deposit : total;

                qs('#sum-pay').textContent = fmt(needPay);
                qs('#sum-deposit-wrap').style.display = showDeposit ? 'flex' : 'none';
                qs('#sum-deposit').textContent = fmt(deposit);

                const remaining = Math.max(total - deposit, 0);
                qs('#sum-remaining-wrap').style.display = showDeposit ? 'flex' : 'none';
                qs('#sum-remaining').textContent = fmt(remaining);

                // Personal block
                const pWrap = qs('#summary-personal');
                if(state.personal){
                    pWrap.innerHTML = '<div class="field-title">Thông tin đặt sân</div>'+
                        '<div class="row"><span class="muted">Đối tượng</span><strong>'+(state.customer?.customerType === 'casual' ? 'Khách vãng lai' : 'Khách cố định')+'</strong></div>'+
                        '<div class="row"><span class="muted">Họ và tên</span><strong>'+getName(state.personal)+'</strong></div>'+
                        '<div class="row"><span class="muted">SĐT</span><strong>'+getPhone(state.personal)+'</strong></div>'+
                        '<div class="row"><span class="muted">Email</span><strong>'+getEmail(state.personal)+'</strong></div>';
                    pWrap.style.display='block';
                }

                // Booking block
                const bWrap = qs('#summary-booking');
                if(state.booking && state.booking.length > 0){
                    const grouped = state.booking.reduce((acc, item) => {
                        const key = `${item.court}-${item.date}`;
                        if (!acc[key]) {
                            acc[key] = {
                                court: item.court,
                                date: item.date,
                                times: [],
                                price: 0,
                            };
                        }
                        acc[key].times.push(item.time);
                        acc[key].price += item.price || 150000;
                        return acc;
                    }, {});

                    let html = '<div class="field-title" style="margin-bottom:12px">Chi Tiết Đặt Sân</div>';
                    Object.values(grouped).forEach(group => {
                        html += `
                        <div class="card" style="background:linear-gradient(135deg, #f0fdfa, #f0fdfa); border-color:#a7f3d0; padding:16px; margin-bottom:12px;">
                            <div style="display:flex; gap:12px; align-items:flex-start; margin-bottom:12px;">
                                <div style="width:40px; height:40px; background:#fff; border-radius:10px; display:flex; align-items:center; justify-content:center; box-shadow:0 1px 3px rgba(0,0,0,.06); flex-shrink:0;">📍</div>
                                <div style="flex:1;">
                                    <div style="font-weight:800;">${group.court}</div>
                                    <div style="font-size:12px; color:#6b7280;">📅 ${new Date(group.date).toLocaleDateString('vi-VN')}</div>
                                </div>
                            </div>
                            <div style="background:#fff; border-radius:8px; padding:12px;">
                                <div style="display:flex; align-items:center; gap:8px; font-size:14px;">
                                    <span>⏰</span>
                                    <span style="font-weight:600">${group.times.length} khung giờ</span>
                                </div>
                                <div style="font-size:12px; color:#6b7280; padding-left:24px;">${group.times.sort().join(', ')}</div>
                                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #eee; margin-top:8px; padding-top:8px;">
                                    <span style="font-size:12px; color:#6b7280;">Thành tiền:</span>
                                    <strong style="color:#059669;">${fmt(group.price)}</strong>
                                </div>
                            </div>
                        </div>
                        `;
                    });

                    bWrap.innerHTML = html;
                    bWrap.style.display = 'block';
                }
            };

            // Radio interactions
            qsa('.radio-opt[data-method]').forEach(el=>{
                el.addEventListener('click',()=>{
                    qsa('.radio-opt[data-method]').forEach(i=>i.classList.remove('is-active'));
                    el.classList.add('is-active');
                    const val = el.getAttribute('data-method');
                    state.method = val;
                    qs('input[name="paymentMethod"][value="'+val+'"]').checked = true;
                    qs('#bank-detail-card').style.display = val==='bank-transfer'?'block':'none';
                    qs('#vnpay-card').style.display = val==='vnpay'?'block':'none';
                    qs('#pay-btn').textContent = val==='vnpay'?'Thanh Toán Với VNPay':'Xác Nhận Thanh Toán';
                });
            });
            qsa('.radio-opt[data-type]').forEach(el=>{
                el.addEventListener('click',()=>{
                    qsa('.radio-opt[data-type]').forEach(i=>i.classList.remove('is-active'));
                    el.classList.add('is-active');
                    const val = el.getAttribute('data-type');
                    state.type = val; qs('input[name="paymentType"][value="'+val+'"]').checked = true; updateSummary();
                });
            });

            // Activate default visuals
            qsa('.radio-opt[data-method]')[0].classList.add('is-active');
            qsa('.radio-opt[data-type]')[0]?.classList.add('is-active');

            updateSummary();

            // Submit -> redirect to confirmation page
            qs('#checkout-form').addEventListener('submit', function(e){
                e.preventDefault();

                const payType = state.type;
                const showDeposit = payType === 'deposit';
                const amountPaid = showDeposit ? deposit : total;
                const amountRemaining = Math.max(total - amountPaid, 0);

                const paymentDetails = {
                    totalAmount: total,
                    paymentType: payType,
                    amountPaid: amountPaid,
                    amountRemaining: amountRemaining
                };

                localStorage.setItem('paymentDetails', JSON.stringify(paymentDetails));

                window.location.href = '/xac-nhan';
            });
        })();
    </script>
</section>

