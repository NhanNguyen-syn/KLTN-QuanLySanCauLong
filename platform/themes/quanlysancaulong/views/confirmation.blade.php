{!! dynamic_sidebar('top_sidebar') !!}
@if(!empty($page))
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $page->content, $page) !!}
@endif

<section class="confirm-section">
    <style>
        .confirm-section{padding:40px 0}
        .confirm-section .container{max-width:960px;margin:0 auto;padding:0 16px}
        .success-head{text-align:center;margin-bottom:24px}
        .success-badge{width:96px;height:96px;border-radius:999px;background:linear-gradient(135deg,#10b981,#14b8a6);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#fff;font-size:42px;box-shadow:0 20px 40px rgba(16,185,129,.25)}
        .card{background:#fff;border:1px solid #eef2f7;border-radius:20px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,.06)}
        .card-header{background:linear-gradient(90deg,#065f46,#059669,#14b8a6);color:#fff;padding:22px}
        .card-body{padding:22px}
        .label{font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:.08em}
        .pill{display:inline-flex;align-items:center;gap:8px;background:#ecfdf5;border:2px solid #10b981;border-radius:999px;padding:10px 16px;color:#065f46;font-weight:800}
        .info-grid{display:grid;grid-template-columns:1fr;gap:12px;background:#f8fafc;border-radius:16px;padding:16px;margin-top:8px}
        @media(min-width:768px){.info-grid{grid-template-columns:1fr 1fr}}
        .info-item{display:flex;gap:10px}
        .icon{width:40px;height:40px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 3px rgba(0,0,0,.06);flex-shrink:0}
        .group{background:linear-gradient(180deg,#ecfeff,#f0fdfa);border:2px solid #a7f3d0;border-radius:16px;padding:16px}
        .group-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
        .total{display:flex;align-items:center;justify-content:space-between;background:linear-gradient(90deg,#059669,#14b8a6);color:#fff;border-radius:16px;padding:16px;margin-top:12px;font-weight:800}
        .actions{display:flex;gap:12px;justify-content:center;margin-top:18px;flex-wrap:wrap}
        .btn{display:inline-flex;align-items:center;justify-content:center;padding:14px 20px;border-radius:12px;font-weight:800}
        .btn-primary{background:linear-gradient(90deg,#059669,#14b8a6);color:#fff}
        .btn-outline{background:#fff;color:#059669;border:2px solid #059669}
    </style>

    <div class="container">
        <div class="success-head">
            <div class="success-badge">✔️</div>
            <h1 style="font-size:34px;font-weight:900;margin:8px 0">Đặt Sân Thành Công!</h1>
            <p style="color:#6b7280">Cảm ơn bạn đã tin tưởng Sân cầu lông Niên Thời. Thông tin chi tiết đã được gửi qua email.</p>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                    <div>
                        <div class="label" style="color:#d1fae5">Mã hóa đơn</div>
                        <div id="order-code" style="font-size:28px;font-weight:900">Đang tạo...</div>
                    </div>
                    <div style="display:flex;gap:10px">
                        <button id="btn-download-invoice" class="btn btn-outline" type="button">Tải hóa đơn</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="customer-block" style="margin-bottom:18px"></div>
                <div id="booking-block" style="margin-bottom:18px"></div>
                <div id="payment-details-block">
                    <div class="total"><span>Tổng đã thanh toán: </span><span id="paid-total">0đ</span></div>
                    <div class="total" id="remaining-wrap" style="display: none; background: #f8fafc; color: #333; margin-top: 0; border-radius: 0 0 16px 16px; padding-top: 12px; padding-bottom: 12px;">
                        <span>Số tiền phải trả khi đến sân: </span>
                        <strong id="remaining-total">0đ</strong>
                    </div>
                </div>
                <div style="text-align:center;margin-top:14px">
                    <span class="pill"><span style="width:10px;height:10px;background:#10b981;border-radius:50%"></span>Đang xử lý thanh toán</span>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="/" class="btn btn-primary">Về trang chủ</a>
            <a href="/tra-cuu" class="btn btn-outline">Tra cứu đơn hàng</a>
        </div>
    </div>

    <script>
    (async function(){
        const qs=s=>document.querySelector(s);
        const fmt=n=>{try{return Number(n||0).toLocaleString('vi-VN')+'đ'}catch(e){return '0đ'}};
        // Map personalInfo fields: field_1 = name, field_2 = email, field_3 = phone
        const getName = p => (p?.field_1 || p?.fullName || p?.name || p?.full_name || p?.hoTen || p?.ten || '').toString().trim();
        const getPhone = p => (p?.field_3 || p?.phone || p?.sdt || p?.so_dien_thoai || p?.mobile || '').toString().trim();
        const getEmail = p => (p?.field_2 || p?.email || p?.mail || '').toString().trim();
        // Parse a time range string like "07:00-08:00" or "07:00 - 08:00" to [start,end]
        const parseTimeRange = (input) => {
            if (!input) return [null, null];
            const raw = String(input).replace(/\s+/g, '');
            const parts = raw.split(/-|–|to|đến|=>/i);
            const normalize = (v) => {
                if (!v) return null;
                // 0700 -> 07:00
                if (/^\d{4}$/.test(v)) return v.slice(0,2)+":"+v.slice(2);
                return v.includes(':') ? v : v;
            };
            return [normalize(parts[0]||null), normalize(parts[1]||null)];
        };

        // Chuẩn hóa date sang YYYY-MM-DD để server validate 'date' không bị 422
        const normalizeDate = (val) => {
            if (!val) return null;
            try {
                // Nếu đã đúng dạng YYYY-MM-DD thì trả về luôn
                if (/^\d{4}-\d{2}-\d{2}$/.test(String(val))) return String(val);
                const d = new Date(val);
                if (!isNaN(d.getTime())) return new Date(d.getTime() - d.getTimezoneOffset()*60000).toISOString().slice(0,10);
            } catch (e) {}
            // fallback giữ nguyên để server cố parse
            return String(val);
        };

        // Read localStorage
        let personal=null, booking=[];
        try{personal=JSON.parse(localStorage.getItem('personalInfo')||'null')}catch(e){}
        try{booking=JSON.parse(localStorage.getItem('tempBooking')||'[]')||[]}catch(e){booking=[]}
        // Customer block
        if(personal){
            qs('#customer-block').innerHTML=
                '<div class="label">Thông tin khách hàng</div>'+
                '<div class="info-grid">'+
                ' <div class="info-item"><div class="icon">👤</div><div><div class="label" style="margin-bottom:4px">Họ và tên</div><div style="font-weight:800">'+getName(personal)+'</div></div></div>'+
                ' <div class="info-item"><div class="icon">📞</div><div><div class="label" style="margin-bottom:4px">SĐT</div><div style="font-weight:800">'+getPhone(personal)+'</div></div></div>'+
                ' <div class="info-item" style="grid-column:1/-1"><div class="icon">✉️</div><div><div class="label" style="margin-bottom:4px">Email</div><div style="font-weight:800;word-break:break-all">'+getEmail(personal)+'</div></div></div>'+
                '</div>';
        }
        // Booking block (group by court + date)
        if(booking.length){
            const grouped=booking.reduce((acc,it)=>{const k=it.court+'-'+it.date;acc[k]=acc[k]||{court:it.court,date:it.date,times:[],price:0};acc[k].times.push(it.time || `${it.start_time||it.startTime}-${it.end_time||it.endTime}`);acc[k].price+=(Number(it.price)||150000);return acc;},{});
            let html='<div class="label" style="margin-bottom:8px">Thông tin đặt sân</div>';
            Object.values(grouped).forEach(g=>{
                html+= '<div class="group">'+
                    '<div class="group-head">'+
                        '<div style="display:flex;gap:10px;align-items:center"><div class="icon" style="background:#065f46;color:#fff">📍</div><div><div style="font-weight:900">'+g.court+'</div><div class="label">'+new Date(g.date).toLocaleDateString('vi-VN',{weekday:'long',year:'numeric',month:'long',day:'numeric'})+'</div></div></div>'+
                        '<div style="background:#fff;border-radius:10px;padding:8px 12px;box-shadow:0 1px 3px rgba(0,0,0,.06)"><div class="label">Thành tiền</div><div style="font-weight:900;color:#047857">'+fmt(g.price)+'</div></div>'+
                    '</div>'+
                    '<div style="background:#fff;border-radius:12px;padding:12px"><div style="display:flex;gap:8px;align-items:flex-start"><div class="icon">⏰</div><div><div class="label" style="margin-bottom:4px">Khung giờ</div><div style="font-weight:700">'+g.times.join(', ')+'</div></div></div></div>'+
                '</div>';
            });
            qs('#booking-block').innerHTML=html;
        }
        const params = new URLSearchParams(window.location.search);
        const vnpResponseCode = params.get('vnp_ResponseCode');
        const vnpTransactionStatus = params.get('vnp_TransactionStatus');
        const vnpIsReturn = vnpResponseCode !== null || vnpTransactionStatus !== null;
        const vnpSuccess = vnpResponseCode === '00' && vnpTransactionStatus === '00';

        // Payment Details from localStorage
        let paymentDetails = null;
        try { paymentDetails = JSON.parse(localStorage.getItem('paymentDetails') || 'null'); } catch(e) {}

        const bookingTotal = (booking || []).reduce((sum, item) => sum + (Number(item.price) || 0), 0);
        const fetchOrderCode = async (dateValue) => {
            if (!dateValue) return null;
            try {
                const res = await fetch('{{ url('/ajax/booking/order-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ date: dateValue })
                });
                const data = await res.json().catch(() => null);
                if (!res.ok || !data || !data.order_code) return null;
                return data.order_code;
            } catch(e) {
                return null;
            }
        };
        const vnpAmountRaw = params.get('vnp_Amount');
        const vnpAmount = vnpAmountRaw ? Math.round(Number(vnpAmountRaw) / 100) : 0;
        if (vnpIsReturn && vnpAmount > 0 && (!paymentDetails || paymentDetails.paymentMethod === 'vnpay')) {
            const inferredType = bookingTotal > 0 && vnpAmount >= bookingTotal ? 'full' : 'deposit';
            paymentDetails = {
                totalAmount: bookingTotal,
                paymentType: inferredType,
                amountPaid: vnpAmount,
                amountRemaining: Math.max(bookingTotal - vnpAmount, 0)
            };
            try {
                localStorage.setItem('paymentDetails', JSON.stringify(paymentDetails));
            } catch(e) {}
        }

        if (paymentDetails && !paymentDetails.paymentMethod) {
            paymentDetails.paymentMethod = 'bank-transfer';
        }

if (paymentDetails) {
            qs('#paid-total').textContent = fmt(paymentDetails.amountPaid);
            if (paymentDetails.paymentType === 'deposit' && paymentDetails.amountRemaining > 0) {
                qs('#remaining-total').textContent = fmt(paymentDetails.amountRemaining);
                qs('#remaining-wrap').style.display = 'flex';
            }
        } else {
            // Fallback if paymentDetails is missing
            const total=(booking||[]).reduce((s,it)=>s+(Number(it.price)||0),0);
            qs('#paid-total').textContent=fmt(total);
        }

        // Persist to server (idempotent) and get invoice/order code BD-YYYYMMDD-XXX
        let orderCode = localStorage.getItem('order_code') || null;
        let bookingCreated = localStorage.getItem('booking_created') === '1' && !!orderCode;
        if (!bookingCreated && localStorage.getItem('booking_created') === '1' && !orderCode) {
            try { localStorage.removeItem('booking_created'); } catch(e) {}
        }
        if (!vnpIsReturn && !bookingCreated) {
            const dateValue = (booking && booking[0] && (booking[0].date || booking[0].booking_date || booking[0].ngay)) || null;
            orderCode = await fetchOrderCode(dateValue);
            if (orderCode) {
                try { localStorage.setItem('order_code', orderCode); } catch(e) {}
            }
        }
        const payload={
            order_code: orderCode || null,
            customer_name: getName(personal) || null,
            contact: getPhone(personal) || null,
            email: getEmail(personal) || null,
            notes: null,
            paid_amount: paymentDetails ? paymentDetails.amountPaid : 0,
            status: vnpIsReturn ? (vnpSuccess ? ((paymentDetails && paymentDetails.paymentType === 'full') ? 'completed' : 'paid') : 'failed') : 'processing',
            items: (booking||[])
                .map(it => {
                    const courtId = it.court_id ?? it.courtId ?? it.id ?? null;
                    let st = null, et = null;

                    // Logic mới: Xử lý `it.time` là giờ bắt đầu (ví dụ: "6:00")
                    // và giả định mỗi suất là 30 phút.
                    if (it.time && typeof it.time === 'string') {
                        const timeParts = it.time.split(':').map(Number);
                        if (timeParts.length === 2) {
                            const startDate = new Date();
                            startDate.setHours(timeParts[0], timeParts[1], 0, 0);

                            const endDate = new Date(startDate.getTime() + 30 * 60000); // Thêm 30 phút

                            st = startDate.toTimeString().slice(0, 5);
                            et = endDate.toTimeString().slice(0, 5);
                        }
                    } else {
                        // Giữ lại logic cũ để tương thích nếu dữ liệu có dạng khoảng giờ
                        const rangeInput = (typeof it.slot === 'string' ? it.slot : null) || (((it.start_time || it.startTime) && (it.end_time || it.endTime)) ? `${it.start_time || it.startTime}-${it.end_time || it.endTime}` : null);
                        [st, et] = parseTimeRange(rangeInput);
                    }

                    return {
                        court_id: courtId,
                        court_name: (typeof it.court === 'string' ? it.court : null) || it.court_name || it.courtName || null,
                        date: normalizeDate(it.date || it.booking_date || it.ngay || null),
                        start_time: st,
                        end_time: et,
                        price: Number(it.price) || 0
                    };
                })
                // Chỉ cần có ngày + giờ; KHÔNG bắt buộc court_id/court_name để tránh rớt dữ liệu
                .filter(x => x.start_time && x.end_time && x.date)
        };

        console.log('CONFIRM payload to /api/booking-list', payload);

        // Hiển thị mã tạm thời theo cấu trúc BD-YYYYMMDD-... ngay cả trước khi lưu
        const tmpDate = (payload.items && payload.items[0] && payload.items[0].date) || new Date().toISOString().slice(0,10);
        const placeholderCode = `BD-${String(tmpDate).replace(/-/g,'')}-...`;
        qs('#order-code').textContent = localStorage.getItem('order_code') || placeholderCode;

        if ((payload.items||[]).length && (!vnpIsReturn ? !bookingCreated : vnpSuccess)){
            // Gọi đúng base URL theo APP_URL để hỗ trợ khi app chạy trong sub-folder
            fetch('{{ url('/api/booking-list') }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify(payload)
            })
            .then(async res => {
                const responseText = await res.text();
                console.log('[BOOKING API RESPONSE]', {
                    status: res.status,
                    ok: res.ok,
                    body: responseText,
                });

                if (res.status === 409) {
                    let errorMsg = 'Khung giờ này đã bị người khác đặt trước. Vui lòng chọn giờ khác.';
                    try {
                        const errData = JSON.parse(responseText);
                        if (errData.message) errorMsg = errData.message;
                    } catch(e) {}

                    // Custom modal notification
                    const overlay = document.createElement('div');
                    overlay.style.cssText = 'position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);animation:fadeIn .3s ease';
                    overlay.innerHTML = `
                        <style>
                            @keyframes fadeIn{from{opacity:0}to{opacity:1}}
                            @keyframes slideUp{from{opacity:0;transform:translateY(20px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}
                        </style>
                        <div style="background:#fff;border-radius:16px;padding:32px 28px;max-width:420px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.2);animation:slideUp .35s ease">
                            <div style="width:64px;height:64px;margin:0 auto 16px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;box-shadow:0 4px 12px rgba(251,191,36,0.3)">⚠️</div>
                            <h3 style="margin:0 0 8px;font-size:18px;font-weight:700;color:#1f2937">Đặt sân không thành công</h3>
                            <p style="margin:0 0 24px;font-size:14px;color:#6b7280;line-height:1.6">${errorMsg}</p>
                            <button onclick="window.location.href='/dat-san'" style="background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;border:none;padding:12px 32px;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;box-shadow:0 4px 14px rgba(37,99,235,0.35);transition:transform .15s,box-shadow .15s" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(37,99,235,0.4)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(37,99,235,0.35)'">← Quay lại chọn sân</button>
                        </div>
                    `;
                    document.body.appendChild(overlay);
                    return;
                }

                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}: ${responseText}`);
                }

                try {
                    return JSON.parse(responseText);
                } catch (e) {
                    throw new Error('Failed to parse JSON response: ' + responseText);
                }
            })
            .then(res => {
                if (!res) return; // Conflict was already handled
                console.log('[BOOKING API SUCCESS]', res);
                if (res.success && res.order_code) {
                    localStorage.setItem('order_code', res.order_code);
                    localStorage.setItem('booking_created', '1');
                    qs('#order-code').textContent = res.order_code;
                    try { localStorage.removeItem('tempBooking'); } catch(e) {}
                } else {
                    console.warn('[BOOKING API] Server responded with success=false or missing order_code.', res);
                }
            })
            .catch(err => {
                console.error('[BOOKING API FAILED]', err);
                qs('#order-code').textContent = localStorage.getItem('order_code') || placeholderCode;
            });
            // Không có item hợp lệ: vẫn hiển thị cấu trúc mã thay vì "Không xác định"
            qs('#order-code').textContent = localStorage.getItem('order_code') || placeholderCode;
        }

        // Handle Download Invoice
        const btnDownload = qs('#btn-download-invoice');
        if (btnDownload) {
            btnDownload.addEventListener('click', () => {
                const code = localStorage.getItem('order_code');
                if (code && code.startsWith('BD-')) {
                    window.open('{{ url('/invoice/download') }}/' + code, '_blank');
                } else {
                    alert('Vui lòng chờ mã hóa đơn được tạo xong.');
                }
            });
        }

        // Handle Share Button
        const btnShare = qs('#btn-share-booking');
        if (btnShare) {
            btnShare.addEventListener('click', async () => {
                const code = localStorage.getItem('order_code') || 'N/A';
                const booking = JSON.parse(localStorage.getItem('booking') || '[]');
                const total = booking.reduce((sum, item) => sum + (Number(item.price)||0), 0);
                
                let text = `🎉 Đặt sân thành công tại Sân Cầu Lông Niên Thời!\n\n`;
                text += `🔖 Mã hóa đơn: ${code}\n`;
                text += `💰 Tổng tiền: ${Number(total).toLocaleString('vi-VN')}đ\n`;
                text += `--------------------------------\n`;
                
                booking.forEach(item => {
                    const d = item.date || 'N/A';
                    const t = item.time || (item.start_time + ' - ' + item.end_time) || 'N/A';
                    text += `🏸 ${item.court || item.court_name}\n`;
                    text += `📅 Ngày: ${d}\n`;
                    text += `⏰ Giờ: ${t}\n\n`;
                });
                
                text += `📍 Địa chỉ: 123 Đường ABC, Quận 1, TP.HCM\n`;
                text += `📞 Hotline: 0901234567`;

                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: 'Đặt sân thành công - ' + code,
                            text: text,
                        });
                    } catch (err) {
                        // User cancelled or failed
                    }
                } else {
                    try {
                        await navigator.clipboard.writeText(text);
                        alert('Đã sao chép thông tin đặt sân vào bộ nhớ tạm!');
                    } catch (err) {
                        alert('Không thể chia sẻ. Vui lòng chụp màn hình.');
                    }
                }
            });
        }
    })();
    </script>
</section>


