{!! dynamic_sidebar('top_sidebar') !!}
@if(!empty($page))
    @php
        $pageContent = $page->content;
        $bankTransferShortcodeFromPage = '';
        if (preg_match('/\\[(\\[?)bank-transfer-details(?![\\w-])[^\\]]*\\](?:[\\s\\S]*?)\\[\\/bank-transfer-details\\]/s', $pageContent, $matches)) {
            $bankTransferShortcodeFromPage = $matches[0];
        } elseif (preg_match('/\\[(\\[?)bank-transfer-details(?![\\w-])[^\\]]*\\/\\]/s', $pageContent, $matches)) {
            $bankTransferShortcodeFromPage = $matches[0];
        } elseif (preg_match('/\\[(\\[?)bank-transfer-details(?![\\w-])[^\\]]*\\]/s', $pageContent, $matches)) {
            $bankTransferShortcodeFromPage = $matches[0];
        }
        $pageContent = preg_replace('/\\[(\\[?)bank-transfer-details(?![\\w-])[^\\]]*\\](?:[\\s\\S]*?)\\[\\/bank-transfer-details\\]/s', '', $pageContent);
        $pageContent = preg_replace('/\\[(\\[?)bank-transfer-details(?![\\w-])[^\\]]*\\/\\]/s', '', $pageContent);
        $pageContent = preg_replace('/\\[(\\[?)bank-transfer-details(?![\\w-])[^\\]]*\\]/s', '', $pageContent);
    @endphp
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
@endif

<section class="checkout-section">
    <style>
        .checkout-section{padding:40px 0}
        .checkout-section .container{max-width:1120px;margin:0 auto;padding:0 16px}
        .checkout-grid{display:grid;grid-template-columns:1fr;gap:24px}
        @media(min-width:992px){.checkout-grid{grid-template-columns:2fr 1fr}}
        .card{background:#fff;border:1px solid #f0f0f0;border-radius:16px;padding:22px;box-shadow:0 2px 8px rgba(0,0,0,.05); margin-bottom: 30px;}
        .card h3{margin:0 0 14px 0;font-weight:800}
        .radio-opt{display:block;border:2px solid #e5e7eb;border-radius:14px;padding:16px;cursor:pointer;margin-bottom:12px}
        .radio-opt.is-active{background:linear-gradient(180deg,rgba(16,185,129,.08),rgba(20,184,166,.08));border-color:#10b981}
        .radio-opt:hover{border-color:#10b981}
        .field-title{font-size:14px;color:#6b7280;font-weight:700;text-transform:uppercase}
        .summary{position:sticky;top:24px}
        .row{display:flex;justify-content:space-between;margin:8px 0}
        .total{display:flex;justify-content:space-between;border-top:2px solid #e5e7eb;margin-top:12px;padding-top:12px;font-weight:800}
        .pay-btn{width:100%;background:linear-gradient(90deg,#0E6B5C,#1DB9A2);color:#fff;border:none;border-radius:14px;padding:14px 18px;font-weight:800}
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
                    @php
                        $bankTransferShortcode = trim((string) theme_option('bank_transfer_shortcode', ''));
                        if ($bankTransferShortcode === '' && !empty($bankTransferShortcodeFromPage)) {
                            $bankTransferShortcode = $bankTransferShortcodeFromPage;
                        }
                    @endphp
                    @if($bankTransferShortcode !== '')
                        {!! do_shortcode($bankTransferShortcode) !!}
                    @endif

                    <div id="vnpay-card" class="card" style="display:none">
                        <h3>Thanh toán VNPay</h3>
                        <div class="card" style="background:#eef6ff;border-color:#c7ddff">
                            <p class="muted" style="margin:0 0 10px 0; font-size:16px">Bạn sẽ quét QR VNPay để hoàn tất giao dịch an toàn.</p>
                            <div class="muted" style="font-size:15px">Bảo mật cao với mã hóa SSL</div>
                            <div style="margin-top:18px; display:flex; flex-direction:column; align-items:center; gap:12px;">
                                <div id="vnpay-qr-box" style="width:100%; max-width:420px; aspect-ratio:1; background:#fff; border:2px solid #2563eb; border-radius:14px; display:flex; flex-direction:column; align-items:center; justify-content:space-between; gap:8px; padding:12px;">
                                    <span class="muted" style="font-size:14px">Đang tải QR...</span>
                                </div>
                                <div style="width:100%; text-align:center;">
                                    <div class="muted" style="font-size:15px; display:flex; align-items:center; justify-content:center; gap:6px; flex-wrap:wrap;">
                                        <span>Mở app ngân hàng/VNPay để quét mã.</span>
                                        <a href="#" id="vnpay-pay-link" class="muted" style="font-size:15px; display:none;" target="_blank" rel="noopener noreferrer">Mở tài khoản liên kết</a>
                                    </div>
                                </div>
                            </div>
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

            const parseTimeRange = (input) => {
                if (!input) return [null, null];
                const raw = String(input).replace(/\s+/g, '');
                const parts = raw.split(/-|to|den|=>/i);
                const normalize = (v) => {
                    if (!v) return null;
                    if (/^\d{4}$/.test(v)) return v.slice(0, 2) + ':' + v.slice(2);
                    return v.includes(':') ? v : v;
                };
                return [normalize(parts[0] || null), normalize(parts[1] || null)];
            };

            const normalizeDate = (val) => {
                if (!val) return null;
                try {
                    if (/^\d{4}-\d{2}-\d{2}$/.test(String(val))) return String(val);
                    const d = new Date(val);
                    if (!isNaN(d.getTime())) return new Date(d.getTime() - d.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
                } catch (e) {}
                return String(val);
            };
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

const syncPaymentDetails = () => {
                const payType = state.type;
                const showDeposit = payType === 'deposit';
                const amountPaid = showDeposit ? deposit : total;
                const amountRemaining = Math.max(total - amountPaid, 0);

                const paymentDetails = {
                    totalAmount: total,
                    paymentType: payType,
                    amountPaid: amountPaid,
                    amountRemaining: amountRemaining,
                    paymentMethod: state.method
                };

                try {
                    localStorage.setItem('paymentDetails', JSON.stringify(paymentDetails));
                } catch(e) {}
            };

            // Fill transfer note if block exists
            const transferNoteEl = qs('#transfer-note');
            if (transferNoteEl) {
                transferNoteEl.textContent = (getName(state.personal)||'[TEN BAN]') + ' - DAT SAN';
            }

            const vnpayState = { loading: false, lastAmount: null };
            const buildBookingPayload = () => {
                const items = (state.booking || []).map(it => {
                    const courtId = it.court_id ?? it.courtId ?? it.id ?? null;
                    let st = null;
                    let et = null;

                    if (it.time && typeof it.time === 'string') {
                        const timeParts = it.time.split(':').map(Number);
                        if (timeParts.length === 2) {
                            const startDate = new Date();
                            startDate.setHours(timeParts[0], timeParts[1], 0, 0);
                            const endDate = new Date(startDate.getTime() + 30 * 60000);
                            st = startDate.toTimeString().slice(0, 5);
                            et = endDate.toTimeString().slice(0, 5);
                        }
                    } else {
                        const hasRange = (it.start_time || it.startTime) && (it.end_time || it.endTime);
                        const rangeInput = (typeof it.slot === 'string' ? it.slot : null) || (hasRange ? String(it.start_time || it.startTime) + '-' + String(it.end_time || it.endTime) : null);
                        const parsed = parseTimeRange(rangeInput);
                        st = parsed[0];
                        et = parsed[1];
                    }

                    return {
                        court_id: courtId,
                        court_name: (typeof it.court === 'string' ? it.court : null) || it.court_name || it.courtName || null,
                        date: normalizeDate(it.date || it.booking_date || it.ngay || null),
                        start_time: st,
                        end_time: et,
                        price: Number(it.price) || 0,
                    };
                }).filter(x => x.start_time && x.end_time && x.date);

                return {
                    order_code: localStorage.getItem('order_code') || null,
                    customer_name: getName(state.personal) || null,
                    contact: getPhone(state.personal) || getEmail(state.personal) || null,
                    notes: null,
                    paid_amount: getPayAmount(),
                    items: items,
                };
            };
            const ensureOrderCode = async () => {
                const existing = localStorage.getItem('order_code');
                const isLocked = localStorage.getItem('booking_created') === '1';
                if (existing && isLocked) return existing;
                if (existing && !isLocked) {
                    localStorage.removeItem('order_code');
                }

                const payload = buildBookingPayload();
                if (!payload.items.length) return null;

                const res = await fetch('{{ url('/ajax/booking/order-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        date: payload.items[0].date,
                    }),
                });

                const data = await res.json().catch(() => null);
                if (!res.ok || !data || !data.order_code) return null;

                localStorage.setItem('order_code', data.order_code);
                return data.order_code;
            };
            const getPayAmount = () => state.type === 'deposit' ? deposit : total;
            const setVnpayStatus = (text) => {
                const box = qs('#vnpay-qr-box');
                if (!box) return;
                box.innerHTML = '<span class="muted" style="font-size:14px">' + text + '</span>';
            };
            const fetchVnpayQr = async () => {
                const box = qs('#vnpay-qr-box');
                if (!box) return;
                const amount = getPayAmount();
                const orderCode = await ensureOrderCode();
                if (!orderCode) {
                    setVnpayStatus('Khong the tao don.');
                    vnpayState.loading = false;
                    return;
                }
                if (!amount || amount <= 0 || vnpayState.loading) return;
                if (vnpayState.lastAmount === amount && box.querySelector('img')) return;

                vnpayState.loading = true;
                vnpayState.lastAmount = amount;
                setVnpayStatus('Dang tai QR...');

                const link = qs('#vnpay-pay-link');
                if (link) {
                    link.style.display = 'none';
                    link.setAttribute('href', '#');
                }

                try {
                    const res = await fetch('{{ url('/ajax/vnpay/qr') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            amount: amount,
                            order_info: 'Thanh toan dat san',
                            order_code: orderCode,
                        }),
                    });

                    const data = await res.json().catch(() => null);
                    if (!res.ok || !data || !data.qr_image_url) {
                        throw new Error(data?.message || 'VNPay error');
                    }

                    const img = document.createElement('img');
                    img.src = data.qr_image_url;
                    img.alt = 'VNPay QR';
                    img.style.width = '100%';
                    img.style.height = 'auto';
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = 'calc(100% - 60px)';
                    img.style.objectFit = 'contain';
                    img.style.flex = '1';
                    img.style.borderRadius = '6px';

                    const labelTop = document.createElement('img');
                    labelTop.src = "{{ asset('themes/quanlysancaulong/Logo-VNPAY-QR.png') }}";
                    labelTop.alt = 'VNPAY QR';
                    labelTop.style.height = '24px';
                    labelTop.style.width = 'auto';
                    labelTop.style.marginTop = '2px';

                    const labelBottom = document.createElement('div');
                    labelBottom.textContent = 'Scan to Pay';
                    labelBottom.style.fontWeight = '700';
                    labelBottom.style.color = '#1d4ed8';
                    labelBottom.style.fontSize = '13px';

                    box.innerHTML = '';
                    box.appendChild(labelTop);
                    box.appendChild(img);
                    box.appendChild(labelBottom);

                    if (link && data.payment_url) {
                        link.textContent = 'Mở tài khoản liên kết';
                        link.style.display = 'inline';
                        link.setAttribute('href', data.payment_url);
                    }
                } catch (err) {
                    setVnpayStatus('Khong the tao QR.');
                } finally {
                    vnpayState.loading = false;
                }
            };
            const updateSummary = ()=>{
                syncPaymentDetails();
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

            if (state.method === 'bank-transfer') {
                try { localStorage.removeItem('booking_created'); } catch(e) {}
                try { localStorage.removeItem('order_code'); } catch(e) {}
                syncPaymentDetails();
            }

// Radio interactions
            qsa('.radio-opt[data-method]').forEach(el=>{
                el.addEventListener('click',()=>{
                    qsa('.radio-opt[data-method]').forEach(i=>i.classList.remove('is-active'));
                    el.classList.add('is-active');
                    const val = el.getAttribute('data-method');
                    state.method = val;
                    qs('input[name="paymentMethod"][value="'+val+'"]').checked = true;
                    const bankDetailCard = qs('#bank-detail-card');
                    if (bankDetailCard) {
                        bankDetailCard.style.display = val==='bank-transfer'?'block':'none';
                    }
                    qs('#vnpay-card').style.display = val==='vnpay'?'block':'none';
                    if (val === 'vnpay') {
                        try { localStorage.removeItem('booking_created'); } catch(e) {}
                        syncPaymentDetails();
                        fetchVnpayQr();
                    } else {
                        try { localStorage.removeItem('booking_created'); } catch(e) {}
                        try { localStorage.removeItem('order_code'); } catch(e) {}
                        syncPaymentDetails();
                    }
                    const payBtn = qs('#pay-btn');
                    if (payBtn) {
                        payBtn.style.display = val === 'vnpay' ? 'none' : 'block';
                    }
                });
            });
            qsa('.radio-opt[data-type]').forEach(el=>{
                el.addEventListener('click',()=>{
                    qsa('.radio-opt[data-type]').forEach(i=>i.classList.remove('is-active'));
                    el.classList.add('is-active');
                    const val = el.getAttribute('data-type');
                    state.type = val;
                    qs('input[name="paymentType"][value="'+val+'"]').checked = true;
                    updateSummary();
                    if (state.method === 'vnpay') {
                        vnpayState.lastAmount = null;
                        setVnpayStatus('Dang tai QR...');
                        fetchVnpayQr();
                    }
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





























