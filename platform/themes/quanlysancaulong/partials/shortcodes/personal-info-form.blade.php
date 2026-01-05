@php
    $title = $props['title'] ?? 'Thông Tin Cá Nhân';
    $subtitle = $props['subtitle'] ?? 'Vui lòng cung cấp thông tin của bạn';
    $formFields = $props['formFields'] ?? [];
    $submitButtonText = $props['submitButtonText'] ?? 'Lưu Thông Tin';
    $submitButtonUrl = $props['submitButtonUrl'] ?? '';
@endphp

<section class="personal-info-form-section">
    <style>
        .personal-info-form-section {
            padding: 40px 0 !important;
            margin-bottom: 32px;
        }

        .personal-info-form-section .container {
            max-width: 1120px;
            width: 100%;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* 2-column layout similar to d/app/thong-tin-ca-nhan */
        .personal-info-form-section .pi-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }
        @media (min-width: 992px) {
            .personal-info-form-section .pi-layout {
                grid-template-columns: 3fr 2fr;
            }
        }

        .personal-info-form-section .form-wrapper {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        /* Header + steps */
        .personal-info-form-section .pi-header{padding:8px 0 20px;text-align:center}
        .personal-info-form-section .pi-title{font-size:28px;font-weight:800;color:#111827;margin:4px 0}
        .personal-info-form-section .pi-subtitle{color:#6b7280;margin:0}
        .personal-info-form-section .pi-steps{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:14px}
        .personal-info-form-section .pi-step{display:flex;align-items:center;gap:8px;color:#9ca3af}
        .personal-info-form-section .pi-step-circle{width:36px;height:36px;border-radius:999px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-weight:700}
        .personal-info-form-section .pi-step.is-complete .pi-step-circle{background:#10b981;color:#fff}
        .personal-info-form-section .pi-step.is-current .pi-step-circle{background:#059669;color:#fff;box-shadow:0 0 0 6px rgba(16,185,129,.15)}
        .personal-info-form-section .pi-step-label{font-weight:600}
        .personal-info-form-section .pi-step.is-complete .pi-step-label{color:#059669}
        .personal-info-form-section .pi-step.is-current .pi-step-label{color:#065f46}
        .personal-info-form-section .pi-step-sep{width:40px;height:2px;background:#e5e7eb}

        /* Card heads */
        .personal-info-form-section .pi-card-head{display:flex;align-items:center;gap:12px;margin-bottom:18px}
        .personal-info-form-section .pi-card-icon{width:32px;height:32px;border-radius:8px;background:#ecfdf5;display:flex;align-items:center;justify-content:center}
        .personal-info-form-section .pi-card-title{font-weight:700}


        /* Submit */
        .personal-info-form-section .pi-submit{width:100%;margin-top:20px;border:none;border-radius:12px;background:#059669;color:#fff;padding:14px 18px;font-weight:700;transition:filter .15s,transform .15s;display:block;text-align:center;text-decoration:none !important}
        .personal-info-form-section .pi-submit[disabled]{background:#f3f4f6;color:#9ca3af;cursor:not-allowed;box-shadow:none}
        .personal-info-form-section .pi-submit:hover{filter:brightness(1.05);text-decoration:none !important}
        .personal-info-form-section .pi-submit:active{transform:scale(.98)}

        /* Summary column */
        .personal-info-form-section .pi-summary{position:relative}
        .personal-info-form-section .pi-summary-card{background:#fff;border:1px solid #f0f0f0;border-radius:16px;padding:22px;box-shadow:0 2px 8px rgba(0,0,0,.05);position:sticky;top:96px}
        .personal-info-form-section .pi-summary-title{font-weight:700;margin-bottom:12px}
        .personal-info-form-section .pi-summary-body{display:block}
        .personal-info-form-section .pi-row{display:flex;gap:12px;padding:14px 0;border-bottom:1px solid #f3f4f6}
        .personal-info-form-section .pi-row:last-child{border-bottom:0}
        .personal-info-form-section .pi-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .personal-info-form-section .pi-icon.bg-emerald{background:#ecfdf5}
        .personal-info-form-section .pi-icon.bg-blue{background:#eff6ff}
        .personal-info-form-section .pi-icon.bg-amber{background:#fffbeb}
        .personal-info-form-section .pi-label{font-size:12px;color:#6b7280}
        .personal-info-form-section .pi-value{font-weight:700}
        .personal-info-form-section .pi-total{display:flex;align-items:center;justify-content:space-between;font-weight:700;margin-top:4px}
        .personal-info-form-section .pi-total-value{color:#059669;font-size:18px}

        .personal-info-form-section .pi-empty{text-align:center;padding:24px 8px}
        .personal-info-form-section .pi-empty-icon{width:64px;height:64px;border-radius:999px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
        .personal-info-form-section .pi-empty-text{color:#6b7280}
        .personal-info-form-section .pi-empty-link{display:inline-block;margin-top:6px;color:#059669;font-weight:600;text-decoration:none}
        .personal-info-form-section .pi-empty-link:hover{text-decoration:underline}

        .personal-info-form-section .pi-secure-note{margin-top:12px;border:1px solid #a7f3d0;background:#ecfdf5;border-radius:14px;padding:14px;display:flex;gap:10px}
        .personal-info-form-section .pi-secure-icon{width:20px;height:20px;border-radius:999px;background:#10b981;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700}
        .personal-info-form-section .pi-secure-title{font-size:14px;font-weight:700;color:#065f46}
        .personal-info-form-section .pi-secure-desc{font-size:12px;color:#047857;margin-top:4px}


        .personal-info-form-section .form-header {
            margin-bottom: 32px;
            text-align: center;
        }

        .personal-info-form-section .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #212121;
            margin: 0 0 12px 0;
            line-height: 1.3;
        }

        .personal-info-form-section .form-subtitle {
            font-size: 14px;
            color: #757575;
            line-height: 1.6;
            margin: 0;
        }

        .personal-info-form-section .form-group {
            margin-bottom: 20px;
        }

        .personal-info-form-section .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #212121;
            margin-bottom: 8px;
            display: block;
        }

        .personal-info-form-section .form-group label .required {
            color: #dc3545;
            margin-left: 2px;
        }

        .personal-info-form-section .form-group input,
        .personal-info-form-section .form-group textarea,
        .personal-info-form-section .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .personal-info-form-section .form-group input:focus,
        .personal-info-form-section .form-group textarea:focus,
        .personal-info-form-section .form-group select:focus {
            outline: none;
            border-color: #0E6B5C;
            box-shadow: 0 0 0 3px rgba(14, 107, 92, 0.15);
        }

        .personal-info-form-section .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }

        .personal-info-form-section .btn-submit {
            background: #0E6B5C;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: filter 0.2s;
            flex: 1;
        }

        .personal-info-form-section .btn-submit:hover {
            filter: brightness(1.08);
        }

        .personal-info-form-section .form-message {
            margin-top: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            display: none;
        }

        .personal-info-form-section .form-success {
            background: #dcfce7;
            color: #166534;
            border-left: 6px solid #22c55e;
        }

        .personal-info-form-section .form-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 6px solid #ef4444;
        }

        @media (max-width: 768px) {
            .personal-info-form-section .form-wrapper {
                padding: 24px;
            }

            .personal-info-form-section .form-title {
                font-size: 24px;
            }
        }
    </style>

    <div class="container">
        <!-- Step progress + heading -->
        <div class="pi-header">
            <div class="pi-steps">
                <div class="pi-step is-complete">
                    <div class="pi-step-circle">1</div>
                    <div class="pi-step-label">Chọn sân</div>
                </div>
                <div class="pi-step-sep"></div>
                <div class="pi-step is-current">
                    <div class="pi-step-circle">2</div>
                    <div class="pi-step-label">Thông tin</div>
                </div>
                <div class="pi-step-sep"></div>
                <div class="pi-step">
                    <div class="pi-step-circle">3</div>
                    <div class="pi-step-label">Thanh toán</div>
                </div>
            </div>
            <h2 class="pi-title">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p class="pi-subtitle">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="pi-layout">
            <!-- Left: Form -->
            <div class="form-wrapper">
                <div class="pi-card-head">
                    <div class="pi-card-icon">👤</div>
                    <div>
                        <div class="pi-card-title">Thông tin liên hệ</div>
                    </div>
                </div>

                                <form class="personal-info-form" onsubmit="event.preventDefault(); return false;">
                    @csrf

                    @foreach($formFields as $index => $field)
                        <div class="form-group">
                            <label for="{{ $field['fieldName'] }}">
                                {{ $field['label'] }}
                                @if($field['required'])
                                    <span class="required">*</span>
                                @endif
                            </label>
                            <input
                                type="text"
                                id="{{ $field['fieldName'] }}"
                                name="{{ $field['fieldName'] }}"
                                class="form-control"
                                placeholder="{{ $field['placeholder'] }}"
                                @if($field['required']) required @endif
                            >
                        </div>
                    @endforeach

                    @if (!empty($submitButtonUrl))
                        <a href="{{ url($submitButtonUrl) }}" class="pi-submit pi-submit-link" disabled aria-disabled="true">{{ $submitButtonText }}</a>
                    @else
                        <button type="submit" class="pi-submit pi-submit-button">{{ $submitButtonText }}</button>
                    @endif

                    <div class="form-message form-success"></div>
                    <div class="form-message form-error"></div>

                <script>
                    (function() {
                        const form = document.querySelector('.personal-info-form');
                        if (!form) return;

                        const btn = form.querySelector('.pi-submit');
                        const requiredInputs = form.querySelectorAll('[required]');

                        const saveToLocalStorage = () => {
                            try {
                                const data = {};
                                form.querySelectorAll('input,select,textarea').forEach(el => {
                                    if (el.name) data[el.name] = el.value;
                                });
                                localStorage.setItem('personalInfo', JSON.stringify(data));
                            } catch (e) {
                                console.error('Failed to save personal info to localStorage', e);
                            }
                        };

                        const checkInputs = () => {
                            const allFilled = Array.from(requiredInputs).every(i => String(i.value || '').trim());
                            if (btn) {
                                if (allFilled) {
                                    btn.removeAttribute('disabled');
                                    btn.setAttribute('aria-disabled', 'false');
                                } else {
                                    btn.setAttribute('disabled', 'true');
                                    btn.setAttribute('aria-disabled', 'true');
                                }
                            }
                        };

                        requiredInputs.forEach(i => {
                            i.addEventListener('input', checkInputs);
                            i.addEventListener('change', checkInputs);
                        });

                        // Add listener based on button type
                        if (btn.classList.contains('pi-submit-link')) {
                            // For <a> tag, just save data before navigating
                            btn.addEventListener('click', (e) => {
                                if (btn.hasAttribute('disabled')) {
                                    e.preventDefault(); // Stop navigation if button is disabled
                                } else {
                                    saveToLocalStorage();
                                }
                            });
                        } else {
                            // For <button> tag, save data on form submit
                            form.addEventListener('submit', (e) => {
                                e.preventDefault(); // Always prevent default for button submit
                                if (!btn.hasAttribute('disabled')) {
                                    saveToLocalStorage();
                                    // Optionally show a success message here
                                    const successMsg = form.querySelector('.form-success');
                                    if(successMsg) {
                                        successMsg.textContent = 'Đã lưu thông tin!';
                                        successMsg.style.display = 'block';
                                    }
                                }
                            });
                        }

                        // Initial check
                        checkInputs();
                    })();
                </script>

                </form>
            </div>

            <!-- Right: Summary -->
            <div class="pi-summary">
                <div class="pi-summary-card">
                    <div class="pi-summary-title">Tóm tắt đặt sân</div>
                    <div id="booking-summary-body" class="pi-summary-body">
                        <div class="pi-empty">
                            <div class="pi-empty-icon">📅</div>
                            <div class="pi-empty-text">Chưa có thông tin đặt sân</div>
                            <a class="pi-empty-link" href="/dat-san">Đặt sân ngay</a>
                        </div>
                    </div>
                </div>
                <div class="pi-secure-note">
                    <div class="pi-secure-icon">✔</div>
                    <div>
                        <div class="pi-secure-title">Thông tin được bảo mật</div>
                        <div class="pi-secure-desc">Dữ liệu của bạn được mã hóa và bảo vệ an toàn theo tiêu chuẩn bảo mật cao nhất.</div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        (function(){
            function money(n){try{return Number(n||0).toLocaleString('vi-VN')+'đ'}catch(e){return '0đ'}}
            function el(html){var d=document.createElement('div');d.innerHTML=html;return d.firstElementChild}
            try{
                var body = document.getElementById('booking-summary-body');
                if(!body) return;
                var raw = localStorage.getItem('tempBooking');
                var items = [];
                try{ items = raw ? JSON.parse(raw)||[] : [] }catch(e){ items = [] }
                if(!items.length){ return; }
                var total = items.reduce(function(s,it){ return s + (Number(it.price)||0) }, 0);
                var first = items[0] || {};
                var html = ''+
                  '<div class="pi-row">'+
                    '<div class="pi-icon bg-emerald">📍</div>'+
                    '<div><div class="pi-label">Sân</div><div class="pi-value">'+ (first.court||'') +'</div></div>'+
                  '</div>'+
                  '<div class="pi-row">'+
                    '<div class="pi-icon bg-blue">📆</div>'+
                    '<div><div class="pi-label">Ngày</div><div class="pi-value">'+ (first.date||'') +'</div></div>'+
                  '</div>'+
                  '<div class="pi-row">'+
                    '<div class="pi-icon bg-amber">⏰</div>'+
                    '<div><div class="pi-label">Khung giờ</div><div class="pi-value">'+ items.length +' khung</div></div>'+
                  '</div>'+
                  '<div class="pi-total"><span>Tạm tính</span><span class="pi-total-value">'+ money(total) +'</span></div>';
                body.innerHTML = html;
            }catch(e){}
        })();
        </script>
    </div>
</section>

