@php
    $user = auth('member')->user();
@endphp

<style>
    /* ===== ACCOUNT SETTINGS PAGE ===== */
    .account-settings {
        max-width: 900px;
        margin: 0 auto;
        padding: 48px 20px 80px;
        font-family: 'Inter', sans-serif;
    }

    /* Page Header */
    .account-header {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 40px;
        padding: 32px;
        background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);
        border-radius: 20px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .account-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }

    .account-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 40%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    .account-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.4);
        object-fit: cover;
        flex-shrink: 0;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: white;
        position: relative;
        z-index: 1;
    }

    .account-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .account-info {
        position: relative;
        z-index: 1;
    }

    .account-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .account-email {
        font-size: 14px;
        opacity: 0.85;
    }

    .account-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
        padding: 4px 12px;
        background: rgba(255,255,255,0.18);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Tab Navigation */
    .settings-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 32px;
        padding: 6px;
        background: #f1f5f9;
        border-radius: 14px;
        overflow-x: auto;
    }

    .settings-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        background: transparent;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
    }

    .settings-tab:hover {
        color: #059669;
        background: rgba(5, 150, 105, 0.06);
    }

    .settings-tab.active {
        background: white;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .settings-tab i {
        font-size: 18px;
    }

    /* Tab Content */
    .settings-panels {
        position: relative;
    }

    .settings-panel {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .settings-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Settings Card */
    .settings-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .settings-card-header {
        padding: 24px 28px 0;
    }

    .settings-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .settings-card-description {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 20px;
    }

    .settings-card-body {
        padding: 24px 28px 28px;
    }

    /* Override form styles */
    .settings-card .form-group {
        margin-bottom: 20px;
    }

    .settings-card label,
    .settings-card .control-label {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 8px !important;
        display: block;
    }

    .settings-card .form-control,
    .settings-card input[type="text"],
    .settings-card input[type="email"],
    .settings-card input[type="password"],
    .settings-card input[type="tel"],
    .settings-card textarea,
    .settings-card select {
        width: 100% !important;
        padding: 12px 16px !important;
        font-size: 14px !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 10px !important;
        background: #f8fafc !important;
        color: #0f172a !important;
        transition: all 0.2s ease !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .settings-card .form-control:focus,
    .settings-card input:focus,
    .settings-card textarea:focus,
    .settings-card select:focus {
        border-color: #059669 !important;
        background: white !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1) !important;
    }

    .settings-card .btn-primary,
    .settings-card button[type="submit"],
    .settings-card .btn-info {
        background: #059669 !important;
        border: none !important;
        padding: 12px 28px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        color: white !important;
        cursor: pointer;
        transition: all 0.25s ease !important;
    }

    .settings-card .btn-primary:hover,
    .settings-card button[type="submit"]:hover,
    .settings-card .btn-info:hover {
        background: #047857 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3) !important;
    }

    /* Avatar section */
    .settings-card .crop-image-container {
        text-align: center;
    }

    .settings-card .crop-image-container img {
        border-radius: 50% !important;
        border: 3px solid #e2e8f0;
        margin-bottom: 16px;
    }

    /* Card styling for form card */
    .settings-card .card {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .settings-card .card-header {
        background: transparent !important;
        border-bottom: none !important;
        padding: 0 !important;
    }

    .settings-card .card-body {
        padding: 0 !important;
    }

    .settings-card .card-header .nav-tabs,
    .settings-card .card-header .nav {
        display: none !important;
    }

    .settings-card .tab-content > .tab-pane {
        display: block !important;
        opacity: 1 !important;
    }

    /* Quick Links */
    .quick-links {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 32px;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        text-decoration: none;
        color: #334155;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .quick-link:hover {
        border-color: #a7f3d0;
        background: #f0fdfa;
        color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
    }

    .quick-link i {
        font-size: 20px;
        color: #059669;
    }

    /* Logout link */
    .settings-logout {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 24px;
        padding: 12px 24px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        color: #dc2626;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .settings-logout:hover {
        background: #fee2e2;
        color: #b91c1c;
        transform: translateY(-1px);
    }

    /* Danger Tab */
    .settings-tab.danger {
        color: #dc2626;
    }

    .settings-tab.danger:hover {
        color: #dc2626;
        background: rgba(220, 38, 38, 0.06);
    }

    .settings-tab.danger.active {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Danger Zone Card */
    .danger-zone-card {
        background: white;
        border-radius: 16px;
        border: 1.5px solid #fecaca;
        overflow: hidden;
    }

    .danger-zone-header {
        padding: 24px 28px 0;
    }

    .danger-zone-title {
        font-size: 18px;
        font-weight: 700;
        color: #dc2626;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .danger-zone-description {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .danger-zone-body {
        padding: 24px 28px 28px;
    }

    .danger-warning {
        display: flex;
        gap: 14px;
        padding: 16px;
        background: #fef2f2;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .danger-warning i {
        color: #dc2626;
        font-size: 22px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .danger-warning-text {
        font-size: 13px;
        color: #991b1b;
        line-height: 1.6;
    }

    .danger-warning-text strong {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .delete-form-group {
        margin-bottom: 20px;
    }

    .delete-form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        display: block;
    }

    .delete-form-group input {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        color: #0f172a;
        transition: all 0.2s ease;
        outline: none;
    }

    .delete-form-group input:focus {
        border-color: #dc2626;
        background: white;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .btn-delete-account {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-delete-account:hover {
        background: #b91c1c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Confirmation Modal */
    .delete-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .delete-modal-overlay.show {
        display: flex;
    }

    .delete-modal {
        background: white;
        border-radius: 20px;
        padding: 32px;
        max-width: 440px;
        width: 90%;
        text-align: center;
        animation: fadeIn 0.3s ease;
    }

    .delete-modal-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #fef2f2;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .delete-modal-icon i {
        font-size: 28px;
        color: #dc2626;
    }

    .delete-modal h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .delete-modal p {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .delete-modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .btn-cancel-delete {
        padding: 12px 24px;
        background: #f1f5f9;
        color: #334155;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel-delete:hover {
        background: #e2e8f0;
    }

    .btn-confirm-delete {
        padding: 12px 24px;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-confirm-delete:hover {
        background: #b91c1c;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .account-settings {
            padding: 24px 16px 60px;
        }

        .account-header {
            flex-direction: column;
            text-align: center;
            padding: 28px 20px;
        }

        .settings-tabs {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .settings-tab {
            padding: 10px 16px;
            font-size: 13px;
        }

        .quick-links {
            grid-template-columns: 1fr;
        }

        .settings-card-body {
            padding: 20px;
        }
    }
</style>

<div class="account-settings">
    {{-- Page Header --}}
    <div class="account-header">
        <div class="account-avatar">
            @if($user->avatar_id)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div class="account-info">
            <div class="account-name">{{ $user->name }}</div>
            <div class="account-email">{{ $user->email }}</div>
            <div class="account-badge">
                <i class="ti ti-shield-check" style="font-size: 14px;"></i>
                Thành viên
            </div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="settings-tabs">
        <button class="settings-tab active" data-tab="profile">
            <i class="ti ti-user"></i>
            Thông tin cá nhân
        </button>
        <button class="settings-tab" data-tab="avatar">
            <i class="ti ti-camera"></i>
            Ảnh đại diện
        </button>
        <button class="settings-tab" data-tab="password">
            <i class="ti ti-lock"></i>
            Đổi mật khẩu
        </button>
        <button class="settings-tab danger" data-tab="delete">
            <i class="ti ti-trash"></i>
            Xóa tài khoản
        </button>
    </div>

    {{-- Tab Panels --}}
    <div class="settings-panels">
        {{-- Profile Tab --}}
        <div class="settings-panel active" id="panel-profile">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2 class="settings-card-title">Thông tin cá nhân</h2>
                    <p class="settings-card-description">Cập nhật tên hiển thị, số điện thoại và thông tin cá nhân của bạn.</p>
                </div>
                <div class="settings-card-body">
                    {!! $profileForm !!}
                </div>
            </div>
        </div>

        {{-- Avatar Tab --}}
        <div class="settings-panel" id="panel-avatar">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2 class="settings-card-title">Ảnh đại diện</h2>
                    <p class="settings-card-description">Tải lên ảnh đại diện của bạn. Ảnh nên có tỉ lệ vuông để hiển thị tốt nhất.</p>
                </div>
                <div class="settings-card-body">
                    <div class="avatar-upload-section">
                        <div class="avatar-preview-wrapper">
                            <div class="avatar-preview-circle" id="avatar-preview-circle">
                                @if($user->avatar_id)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" id="avatar-preview-img">
                                @else
                                    <span class="avatar-preview-initial" id="avatar-preview-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    <img src="" alt="" id="avatar-preview-img" style="display: none;">
                                @endif
                            </div>
                            <div class="avatar-preview-overlay" id="avatar-preview-overlay">
                                <i class="ti ti-camera" style="font-size: 24px;"></i>
                                <span>Thay đổi</span>
                            </div>
                        </div>
                        <input type="file" id="avatar-file-input" accept="image/*" style="display: none;">
                        <div class="avatar-upload-info">
                            <button type="button" class="btn-choose-avatar" id="btn-choose-avatar">
                                <i class="ti ti-upload"></i>
                                Chọn ảnh
                            </button>
                            <p class="avatar-help-text">JPG, PNG hoặc GIF. Tối đa 2MB.</p>
                        </div>
                        <div class="avatar-upload-status" id="avatar-upload-status" style="display: none;">
                            <div class="avatar-status-icon" id="avatar-status-icon"></div>
                            <span id="avatar-status-text"></span>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .avatar-upload-section {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 20px;
                }
                .avatar-preview-wrapper {
                    position: relative;
                    width: 150px;
                    height: 150px;
                    cursor: pointer;
                }
                .avatar-preview-circle {
                    width: 150px;
                    height: 150px;
                    border-radius: 50%;
                    overflow: hidden;
                    border: 3px solid #e2e8f0;
                    background: #059669;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: border-color 0.3s ease;
                }
                .avatar-preview-wrapper:hover .avatar-preview-circle {
                    border-color: #059669;
                }
                .avatar-preview-circle img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .avatar-preview-initial {
                    font-size: 56px;
                    font-weight: 700;
                    color: white;
                }
                .avatar-preview-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    background: rgba(0,0,0,0.5);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 4px;
                    color: white;
                    font-size: 13px;
                    font-weight: 600;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                    cursor: pointer;
                }
                .avatar-preview-wrapper:hover .avatar-preview-overlay {
                    opacity: 1;
                }
                .avatar-upload-info {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 8px;
                }
                .btn-choose-avatar {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 10px 24px;
                    background: #059669;
                    color: white;
                    border: none;
                    border-radius: 10px;
                    font-size: 14px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.25s ease;
                }
                .btn-choose-avatar:hover {
                    background: #047857;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
                }
                .avatar-help-text {
                    font-size: 13px;
                    color: #94a3b8;
                    margin: 0;
                }
                .avatar-upload-status {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 10px 16px;
                    border-radius: 10px;
                    font-size: 14px;
                    font-weight: 500;
                    width: 100%;
                    max-width: 360px;
                    justify-content: center;
                }
                .avatar-upload-status.success {
                    background: #f0fdf4;
                    color: #166534;
                    border: 1px solid #bbf7d0;
                }
                .avatar-upload-status.error {
                    background: #fef2f2;
                    color: #991b1b;
                    border: 1px solid #fecaca;
                }
                .avatar-upload-status.uploading {
                    background: #f0f9ff;
                    color: #1e40af;
                    border: 1px solid #bfdbfe;
                }
            </style>
        </div>

        {{-- Password Tab --}}
        <div class="settings-panel" id="panel-password">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h2 class="settings-card-title">Đổi mật khẩu</h2>
                    <p class="settings-card-description">Để bảo mật tài khoản, hãy sử dụng mật khẩu mạnh mà bạn không dùng cho tài khoản khác.</p>
                </div>
                <div class="settings-card-body">
                    {!! $changePasswordForm !!}
                </div>
            </div>
        </div>

        {{-- Delete Account Tab --}}
        <div class="settings-panel" id="panel-delete">
            <div class="danger-zone-card">
                <div class="danger-zone-header">
                    <h2 class="danger-zone-title">
                        <i class="ti ti-alert-triangle"></i>
                        Xóa tài khoản
                    </h2>
                    <p class="danger-zone-description">Khi bạn xóa tài khoản, tất cả dữ liệu cá nhân sẽ bị xóa vĩnh viễn và không thể khôi phục.</p>
                </div>
                <div class="danger-zone-body">
                    <div class="danger-warning">
                        <i class="ti ti-alert-circle"></i>
                        <div class="danger-warning-text">
                            <strong>Lưu ý quan trọng:</strong>
                            Hành động này sẽ xóa vĩnh viễn tài khoản cùng toàn bộ dữ liệu bao gồm: thông tin cá nhân, ảnh đại diện, lịch sử hoạt động. Bạn sẽ không thể khôi phục tài khoản sau khi xóa.
                        </div>
                    </div>

                    <form id="delete-account-form" action="{{ route('public.member.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="delete-form-group">
                            <label for="delete-password">Nhập mật khẩu để xác nhận</label>
                            <input type="password" id="delete-password" name="password" placeholder="Nhập mật khẩu hiện tại của bạn" required>
                        </div>
                        <button type="button" class="btn-delete-account" id="btn-show-delete-modal">
                            <i class="ti ti-trash"></i>
                            Xóa tài khoản vĩnh viễn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="quick-links">
        <a href="{{ url('/dat-san') }}" class="quick-link">
            <i class="ti ti-calendar-plus"></i>
            Đặt sân ngay
        </a>
        <a href="{{ url('/tra-cuu') }}" class="quick-link">
            <i class="ti ti-search"></i>
            Tra cứu booking
        </a>
        <a href="{{ url('/danh-gia') }}" class="quick-link">
            <i class="ti ti-star"></i>
            Đánh giá
        </a>
    </div>

    {{-- Logout --}}
    <a href="{{ route('public.member.logout') }}" class="settings-logout"
       onclick="event.preventDefault(); document.getElementById('settings-logout-form').submit();">
        <i class="ti ti-logout"></i>
        Đăng xuất
    </a>
    <form id="settings-logout-form" action="{{ route('public.member.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

{{-- Delete Confirmation Modal --}}
<div class="delete-modal-overlay" id="delete-modal-overlay">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="ti ti-alert-triangle"></i>
        </div>
        <h3>Xác nhận xóa tài khoản?</h3>
        <p>Hành động này không thể hoàn tác. Tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn.</p>
        <div class="delete-modal-actions">
            <button class="btn-cancel-delete" id="btn-cancel-delete">Hủy bỏ</button>
            <button class="btn-confirm-delete" id="btn-confirm-delete">Xóa tài khoản</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.settings-tab');
        const panels = document.querySelectorAll('.settings-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.dataset.tab;

                // Update tabs
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Update panels
                panels.forEach(p => p.classList.remove('active'));
                document.getElementById('panel-' + target).classList.add('active');
            });
        });

        // ===== Avatar Upload =====
        const avatarInput = document.getElementById('avatar-file-input');
        const btnChoose = document.getElementById('btn-choose-avatar');
        const previewWrapper = document.querySelector('.avatar-preview-wrapper');
        const previewImg = document.getElementById('avatar-preview-img');
        const previewInitial = document.getElementById('avatar-preview-initial');
        const statusEl = document.getElementById('avatar-upload-status');
        const statusText = document.getElementById('avatar-status-text');

        function openFilePicker() {
            avatarInput.click();
        }

        if (btnChoose) btnChoose.addEventListener('click', openFilePicker);
        if (previewWrapper) previewWrapper.addEventListener('click', openFilePicker);

        if (avatarInput) {
            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                // Validate
                if (!file.type.startsWith('image/')) {
                    showStatus('error', 'Vui lòng chọn file ảnh (JPG, PNG, GIF).');
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    showStatus('error', 'File ảnh không được vượt quá 2MB.');
                    return;
                }

                // Preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewInitial) previewInitial.style.display = 'none';
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);

                // Upload
                uploadAvatar(file);
            });
        }

        function uploadAvatar(file) {
            showStatus('uploading', 'Đang tải lên...');

            const formData = new FormData();
            formData.append('avatar_file', file);

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const token = csrfToken ? csrfToken.getAttribute('content') : '';

            fetch('{{ route("public.member.avatar") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showStatus('error', data.message || 'Có lỗi xảy ra khi tải ảnh lên.');
                } else {
                    showStatus('success', 'Cập nhật ảnh đại diện thành công!');
                    // Reload page after a short delay so header avatar updates
                    setTimeout(() => window.location.reload(), 1200);
                }
            })
            .catch(error => {
                showStatus('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
                console.error('Avatar upload error:', error);
            });
        }

        function showStatus(type, message) {
            statusEl.style.display = 'flex';
            statusEl.className = 'avatar-upload-status ' + type;
            statusText.textContent = message;
        }

        // ===== Delete account modal =====
        const showModalBtn = document.getElementById('btn-show-delete-modal');
        const overlay = document.getElementById('delete-modal-overlay');
        const cancelBtn = document.getElementById('btn-cancel-delete');
        const confirmBtn = document.getElementById('btn-confirm-delete');
        const deleteForm = document.getElementById('delete-account-form');
        const deletePassword = document.getElementById('delete-password');

        if (showModalBtn) {
            showModalBtn.addEventListener('click', function() {
                if (!deletePassword.value.trim()) {
                    deletePassword.focus();
                    deletePassword.style.borderColor = '#dc2626';
                    deletePassword.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
                    return;
                }
                overlay.classList.add('show');
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                overlay.classList.remove('show');
            });
        }

        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                deleteForm.submit();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.classList.remove('show');
                }
            });
        }
    });
</script>

@push('scripts')
    {!! JsValidator::formRequest(Botble\Member\Http\Requests\SettingRequest::class) !!}
    {!! JsValidator::formRequest(Botble\Member\Http\Requests\UpdatePasswordRequest::class) !!}
@endpush
