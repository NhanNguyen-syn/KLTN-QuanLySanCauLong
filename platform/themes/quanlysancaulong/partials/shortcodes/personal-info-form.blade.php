@php
    $title = $props['title'] ?? 'Thông Tin Cá Nhân';
    $subtitle = $props['subtitle'] ?? 'Vui lòng cung cấp thông tin của bạn';
    $formFields = $props['formFields'] ?? [];
    $submitButtonText = $props['submitButtonText'] ?? 'Lưu Thông Tin';
    $submitButtonUrl = $props['submitButtonUrl'] ?? '';

    // Auto-fill from logged-in member
    $authName = '';
    $authEmail = '';
    $authPhone = '';
    if (auth('member')->check()) {
        $member = auth('member')->user();
        $authName = $member->name ?? '';
        $authEmail = $member->email ?? '';
        $authPhone = $member->phone ?? '';
    }
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
        .personal-info-form-section .pi-submit{width:100%;margin-top:20px;border:none;border-radius:12px;background:#059669;color:#fff;padding:14px 18px;font-weight:700;transition:all .4s cubic-bezier(.25,.46,.45,.94);display:block;text-align:center;text-decoration:none !important;position:relative;overflow:hidden;cursor:pointer}
        .personal-info-form-section .pi-submit.is-disabled{background:#e5e7eb !important;color:#9ca3af !important;cursor:not-allowed !important;box-shadow:none !important;pointer-events:none !important;transform:none !important}
        .personal-info-form-section .pi-submit:not(.is-disabled)::before{content:'';position:absolute;top:0;left:-100%;width:80%;height:100%;background:linear-gradient(120deg,transparent 0%,rgba(255,255,255,.2) 30%,rgba(255,255,255,.55) 50%,rgba(255,255,255,.2) 70%,transparent 100%);transition:left .7s ease;z-index:1;pointer-events:none}
        .personal-info-form-section .pi-submit:not(.is-disabled):hover{filter:brightness(1.1);text-decoration:none !important;transform:translateY(-3px) scale(1.03);box-shadow:0 10px 28px rgba(5,150,105,.4),0 0 16px rgba(5,150,105,.2)}
        .personal-info-form-section .pi-submit:not(.is-disabled):hover::before{left:160%}
        .personal-info-form-section .pi-submit:not(.is-disabled):active{transform:translateY(0) scale(.98)}

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

                                <form class="personal-info-form" novalidate>
                    @csrf

                    @foreach($formFields as $index => $field)
                        <div class="form-group">
                            <label for="{{ $field['fieldName'] }}">
                                {{ $field['label'] }}
                                @if($field['required'])
                                    <span class="required">*</span>
                                @endif
                            </label>
                            @php
                                $inputType = 'text';
                                $extraAttrs = '';
                                $defaultValue = '';
                                $flabel = mb_strtolower($field['label'] ?? '');
                                if (str_contains($flabel, 'email')) {
                                    $inputType = 'email';
                                    $defaultValue = $authEmail;
                                } elseif (str_contains($flabel, 'điện thoại') || str_contains($flabel, 'phone') || str_contains($flabel, 'sdt') || str_contains($flabel, 'số điện')) {
                                    $inputType = 'tel';
                                    $extraAttrs = 'maxlength="12" inputmode="numeric"';
                                    $defaultValue = $authPhone;
                                } elseif (str_contains($flabel, 'tên') || str_contains($flabel, 'name') || str_contains($flabel, 'họ')) {
                                    $defaultValue = $authName;
                                }
                            @endphp
                            <input
                                type="{{ $inputType }}"
                                id="{{ $field['fieldName'] }}"
                                name="{{ $field['fieldName'] }}"
                                class="form-control"
                                placeholder="{{ $field['placeholder'] }}"
                                data-field-type="{{ $inputType }}"
                                value="{{ $defaultValue }}"
                                @if($field['required']) required @endif
                                {!! $extraAttrs !!}
                            >
                        </div>
                    @endforeach

                    @if (!empty($submitButtonUrl))
                        <a href="{{ url($submitButtonUrl) }}" class="pi-submit pi-submit-link is-disabled" id="pi-submit-btn"><span style="position:relative;z-index:2">{{ $submitButtonText }}</span></a>
                    @else
                        <button type="submit" class="pi-submit pi-submit-button is-disabled" id="pi-submit-btn"><span style="position:relative;z-index:2">{{ $submitButtonText }}</span></button>
                    @endif

                <script>
                    (function() {
                        var form = document.querySelector('.personal-info-form');
                        if (!form) return;

                        var btn = document.getElementById('pi-submit-btn');
                        var allInputs = form.querySelectorAll('input[name]');

                        function validateField(input) {
                            var val = (input.value || '').trim();
                            var type = input.getAttribute('data-field-type') || input.type;
                            var isRequired = input.hasAttribute('required');
                            var name = input.name.toLowerCase();

                            if (isRequired && !val) return false;

                            if (type === 'email' && val) {
                                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) return false;
                            }

                            if (type === 'tel' && val) {
                                if (!/^\d{9,12}$/.test(val)) return false;
                            }

                            if (type === 'text' && val && (name.includes('name') || name.includes('ten') || name.includes('ho'))) {
                                if (/[^\p{L}\p{N}\s]/u.test(val)) return false;
                            }

                            return true;
                        }

                        // Phone: auto-strip non-digits
                        allInputs.forEach(function(input) {
                            if ((input.getAttribute('data-field-type') || input.type) === 'tel') {
                                input.addEventListener('input', function() {
                                    this.value = this.value.replace(/\D/g, '').slice(0, 12);
                                });
                            }
                        });

                        function saveToLS() {
                            try {
                                var data = {};
                                form.querySelectorAll('input,select,textarea').forEach(function(el) {
                                    if (el.name) data[el.name] = el.value;
                                });
                                localStorage.setItem('personalInfo', JSON.stringify(data));
                            } catch (e) {}
                        }

                        function checkAll() {
                            var valid = true;
                            allInputs.forEach(function(input) {
                                if (!validateField(input)) valid = false;
                            });

                            if (btn) {
                                if (valid) {
                                    btn.classList.remove('is-disabled');
                                } else {
                                    btn.classList.add('is-disabled');
                                }
                            }
                        }

                        allInputs.forEach(function(i) {
                            i.addEventListener('input', checkAll);
                            i.addEventListener('change', checkAll);
                        });

                        // Block click on <a> when disabled
                        if (btn) {
                            btn.addEventListener('click', function(e) {
                                if (btn.classList.contains('is-disabled')) {
                                    e.preventDefault();
                                    e.stopImmediatePropagation();
                                    return false;
                                }
                                saveToLS();
                            });
                        }

                        // Block form submit when disabled
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            if (btn && !btn.classList.contains('is-disabled')) {
                                saveToLS();
                                if (btn.href) window.location.href = btn.href;
                            }
                        });

                        checkAll();
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

