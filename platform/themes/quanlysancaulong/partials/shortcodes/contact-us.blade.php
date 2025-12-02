@php
    $formTitle = $props['formTitle'] ?? ($shortcode->form_title ?? 'Gửi Tin Nhắn Cho Chúng Tôi');
    $formSubtitle = $props['formSubtitle'] ?? ($shortcode->form_subtitle ?? 'Hãy điền thông tin vào biểu mẫu dưới đây, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
    $contactFormHtml = $props['contactFormHtml'] ?? do_shortcode('[contact-form][/contact-form]');

    $locationTitle = $props['locationTitle'] ?? ($shortcode->location_title ?? 'Vị Trí Của Chúng Tôi');
    $googleMapsIframe = $props['googleMapsIframe'] ?? ($shortcode->google_maps_iframe ?? '');

    $mainBranchTitle = $props['mainBranchTitle'] ?? ($shortcode->main_branch_title ?? 'Chi Nhánh Chính');
    $mainBranchAddress = $props['mainBranchAddress'] ?? ($shortcode->main_branch_address ?? '');
    $mainBranchPhone = $props['mainBranchPhone'] ?? ($shortcode->main_branch_phone ?? '');
    $mainBranchMapUrl = $props['mainBranchMapUrl'] ?? ($shortcode->main_branch_map_url ?? '');

    $otherBranchesTitle = $props['otherBranchesTitle'] ?? ($shortcode->other_branches_title ?? 'Chi Nhánh Khác');
    $otherBranches = $props['otherBranches'] ?? [];
@endphp

<section class="contact-us-section">
    <style>
        .contact-us-section {background-color:#f5f5f5;padding:40px 0!important;margin-bottom:32px}
        .contact-us-section .container {max-width:1536px;width:100%;margin:0 auto;padding:0 16px}
        .contact-us-section .row.g-4 {display:grid;grid-template-columns:1fr 1fr;gap:30px;align-items:start}
        /* Force grid items (bootstrap cols) to stretch and stop .d-flex from breaking equal height */
        .contact-us-section .row.g-4 > .d-flex {align-self:start;display:grid!important}
        .contact-us-section .row.g-4 > .d-flex > .contact-card {height:auto}
        .contact-us-section .col-12 {width:100%}
        .contact-us-section .col-lg-6 {width:100%}
        .contact-us-section .d-flex {display:flex}
        .contact-us-section .h-100 {height:100%}

        .contact-us-section .contact-card {background:#fff;border:1px solid #e8e8e8;border-radius:8px;padding:0;box-shadow:0 2px 8px rgba(0,0,0,.05);display:block;height:auto!important}
        .contact-us-section .contact-card.h-100 {height:auto!important}

        .contact-us-section .card-header {background-color:transparent;padding:24px 24px 16px;border-bottom:1px solid #f0f0f0}
        .contact-us-section .card-body {padding:0 24px 16px;display:block}
        .contact-us-section .section-title {font-size:30px;font-weight:700;color:#212121;margin:0;line-height:1.3}
        .contact-us-section .section-subtitle {font-size:14px;color:#757575;line-height:1.6;margin-top:8px}

        .contact-us-section .form-group {margin-bottom:16px}
        .contact-us-section .form-group label {font-size:14px;font-weight:600;color:#212121;margin-bottom:8px;display:block}
        .contact-us-section .form-group label .required {color:#dc3545}
        .contact-us-section .form-group input,
        .contact-us-section .form-group textarea,
        .contact-us-section .form-group select {width:100%;padding:12px 15px;border:1px solid #ddd;border-radius:6px;font-size:14px;font-family:inherit;transition:all .2s}
        .contact-us-section .form-group input:focus,
        .contact-us-section .form-group textarea:focus,
        .contact-us-section .form-group select:focus {outline:none;border-color:#0E6B5C;box-shadow:0 0 0 3px rgba(14,107,92,.15)}
        .contact-us-section .form-row {display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .contact-us-section .form-row.full {grid-template-columns:1fr}
        .contact-us-section .form-actions {margin-top:auto;padding-top:20px;display:flex;flex-direction:column;gap:12px}
        .contact-us-section .checkbox-group {display:flex;align-items:center;gap:10px}
        .contact-us-section .checkbox-group input[type="checkbox"] {width:16px;height:16px;cursor:pointer;flex-shrink:0}
        .contact-us-section .checkbox-group label {margin:0;cursor:pointer;font-weight:400;font-size:13px;color:#666}
        .contact-us-section .btn-submit {background:#0E6B5C;color:#fff;padding:12px 24px;border:none;border-radius:6px;font-weight:600;font-size:14px;cursor:pointer;width:100%;transition:filter .2s}
        .contact-us-section .btn-submit:hover {filter:brightness(1.08)}
        .contact-us-section .contact-form {display:block;margin:0}
        .contact-us-section .form-actions {margin-top:12px!important;padding-bottom:12px}

        .contact-us-section .map-responsive {border-radius:8px;overflow:hidden;margin-bottom:16px;height:400px}
        .contact-us-section .map-responsive iframe {width:100%;height:100%;border:0}

        /* Success/Error messages */
        .contact-us-section .contact-message {margin-top:12px;padding:14px 16px;border-radius:8px;display:none}
        .contact-us-section .contact-success-message {background:#dcfce7;color:#166534;border-left:6px solid #22c55e}
        .contact-us-section .contact-error-message {background:#fee2e2;color:#991b1b;border-left:6px solid #ef4444}

        .contact-us-section .branch-info {display:flex;justify-content:space-between;align-items:center;padding:12px 0;margin:8px 0;border-bottom:none}
        .contact-us-section .branch-info:last-child {border-bottom:none;margin-bottom:0}
        .contact-us-section .branch-details {flex:1}
        .contact-us-section .branch-title {font-weight:700;font-size:14px;color:#212121;margin-bottom:6px}
        /* Titles sizing */
        .contact-us-section .card-body > .branch-info .branch-title {font-size:18px}
        .contact-us-section .branch-list > .branch-title {font-size:18px}
        .contact-us-section .branch-list .branch-info .branch-title {font-size:14px}
        .contact-us-section .branch-item {font-size:14px;color:#757575;line-height:1.5;margin-bottom:4px}

        /* Inline icons for main branch */
        .contact-us-section .branch-item.with-icon {display:flex;align-items:center;gap:8px}
        .contact-us-section .branch-item .icon {width:16px;height:16px;color:#0E6B5C;flex-shrink:0}
        .contact-us-section .branch-item.with-icon a {color:inherit;text-decoration:none}


        .contact-us-section .branch-directions a {color:#0E6B5C;text-decoration:none;font-weight:600;font-size:13px;display:flex;align-items:center;gap:5px}
        .contact-us-section .branch-directions a:hover {color:#FF6B00;text-decoration:underline}
        .contact-us-section .branch-list {margin-top:16px;padding-top:16px;border-top:1px solid #eee}
        .contact-us-section .branch-list .branch-title {font-size:16px;margin-bottom:12px}
        .contact-us-section .branch-list .branch-info {padding:10px 0;margin:0}

        .contact-us-section .btn-branch {background:transparent;border:none;color:#0E6B5C;padding:0;border-radius:0;font-weight:600;font-size:13px;text-decoration:none;white-space:nowrap;cursor:pointer}

        /* Directions icon button for other branches */
        .contact-us-section .btn-branch-icon {width:28px;height:28px;background:#0E6B5C;color:#fff;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;transform:rotate(45deg);text-decoration:none}
        .contact-us-section .btn-branch-icon svg {transform:rotate(-45deg)}
        .contact-us-section .btn-branch-icon::before {content:'->';display:inline-block;transform:rotate(-45deg);color:#fff;font-weight:800;font-size:14px;line-height:1}
        .contact-us-section .btn-branch-icon:hover {filter:brightness(1.08)}
        .contact-us-section .btn-branch-icon:hover::before {transform:rotate(-45deg) translateX(1px)}

        .contact-us-section .branch-info .branch-directions {margin-left:12px;flex-shrink:0}

        .contact-us-section .btn-branch:hover {color:#FF6B00}

        .contact-us-section .branch-other .branch-item-btn {display:block;text-decoration:none;color:inherit;padding:10px 0;border-radius:0;transition:background .2s}
        .contact-us-section .branch-other .branch-item-btn:hover {background:transparent}

        @media (max-width:991.98px) {
            .contact-us-section .row.g-4 {grid-template-columns:1fr;gap:24px}
            .contact-us-section .form-row {grid-template-columns:1fr}
        }


    </style>
    <div class="container">
        <div class="row g-4">
            <!-- Left: Contact form -->
            <div class="col-12 col-lg-6 d-flex">
                <div class="contact-card">
                    <div class="card-header">
                        <h3 class="section-title">{{ $formTitle }}</h3>
                        @if(!empty($formSubtitle))
                            <p class="section-subtitle">{{ $formSubtitle }}</p>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('public.send.contact') }}" class="contact-form">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Họ và tên <span class="required">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập họ và tên của bạn" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Nhập địa chỉ email của bạn" required>
                                </div>
                            </div>
                            <div class="form-row full">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Số điện thoại của bạn">
                                </div>
                            </div>
                            <div class="form-group form-row full">
                                <label for="content">Nội dung tin nhắn <span class="required">*</span></label>
                                <textarea id="content" name="content" class="form-control" placeholder="Nhập nội dung tin nhắn của bạn" rows="5" required></textarea>
                            </div>
                            <div class="form-actions">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="agree_terms_and_policy" name="agree_terms_and_policy" value="1" required>
                                    <label for="agree_terms_and_policy">Tôi đồng ý với <a href="#">chính sách bảo mật</a> của chúng tôi</label>
                                </div>
                                <button type="submit" class="btn-submit">Gửi tin nhắn</button>

                                <div class="contact-message contact-success-message" style="display:none"></div>
                                <div class="contact-message contact-error-message" style="display:none"></div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Right: Map and branches -->
            <div class="col-12 col-lg-6 d-flex">
                <div class="contact-card h-100">
                    <div class="card-header">
                        <h3 class="section-title">{{ $locationTitle }}</h3>
                    </div>
                    <div class="card-body">
                        @if(!empty($googleMapsIframe))
                            <div class="map-responsive">{!! $googleMapsIframe !!}</div>
                        @endif

                        <div class="branch-info">
                            <div class="branch-details">
                                <div class="branch-title">{{ $mainBranchTitle }}</div>
                                @if(!empty($mainBranchAddress))
                                    <div class="branch-item with-icon">
                                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 119.5 9 2.5 2.5 0 0112 11.5z"></path>
                                        </svg>
                                        <span>{{ $mainBranchAddress }}</span>
                                    </div>
                                @endif
                                @if(!empty($mainBranchPhone))
                                    <div class="branch-item with-icon">
                                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M6.62 10.79a15 15 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V21a1 1 0 01-1 1C10.4 22 2 13.6 2 3a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.2 2.2z"></path>
                                        </svg>
                                        <a href="tel:{{ str_replace(' ', '', $mainBranchPhone) }}">{{ $mainBranchPhone }}</a>
                                    </div>
                                @endif
                            </div>
                            @if(!empty($mainBranchMapUrl))
                                <div class="branch-directions">
                                    <a class="btn-branch" href="{{ $mainBranchMapUrl }}" target="_blank" rel="noopener">
                                        Chỉ đường
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if(!empty($otherBranches))
                            <div class="branch-list">
                                <div class="branch-title">{{ $otherBranchesTitle }}</div>
                                @foreach($otherBranches as $branch)
                                    @php
                                        $title = $branch['title'] ?? '';
                                        $description = $branch['description'] ?? '';
                                        $url = $branch['url'] ?? '';
                                    @endphp
                                    @if(!empty($title) || !empty($description))
                                        <div class="branch-info branch-other">
                                            <div class="branch-details">
                                                @if(!empty($title))
                                                    <div class="branch-title">{{ $title }}</div>
                                                @endif
                                                @if(!empty($description))
                                                    <div class="branch-item">{{ $description }}</div>
                                                @endif
                                            </div>
                                            @if(!empty($url))
                                                <div class="branch-directions">
                                                    <a class="btn-branch-icon" href="{{ $url }}" target="_blank" rel="noopener" aria-label="Chỉ đường"></a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

<script>
  document.addEventListener('contact-form.submitted', function () {
    var success = document.querySelector('.contact-success-message');
    if (success && success.offsetParent !== null) {
      success.textContent = 'Cảm ơn bạn đã gửi tin nhắn! Chúng tôi sẽ liên hệ với bạn sớm nhất.';
      // Ensure it is visible then hide after 5 seconds
      success.style.display = 'block';
      setTimeout(function(){ success.style.display = 'none'; }, 5000);
    }
  });
</script>

                </div>
            </div>

{{-- Contact form AJAX handler from plugin --}}
<script src="{{ asset('vendor/core/plugins/contact/js/contact-public.js') }}"></script>

        </div>
    </div>
</section>
