@php
    Theme::layout('default');
    Theme::set('pageTitle', 'Đăng nhập');
@endphp

<section class="auth-section">
    <style>
        .auth-section {
            min-height: calc(100vh - 200px);
            padding: 60px 0;
            background: #f0fdfa;
            display: flex;
            align-items: center;
        }

        .auth-section .container {
            max-width: 480px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .auth-card {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(6, 95, 70, 0.12);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: #059669;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 42px;
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.25);
            color: white;
        }

        .auth-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin: 0 0 8px 0;
            color: #065f46;
        }

        .auth-header p {
            color: #6b7280;
            font-size: 15px;
            margin: 0;
        }

        .auth-form {
            margin-bottom: 24px;
        }

        .auth-form .form-group {
            margin-bottom: 20px;
        }

        .auth-form label {
            display: block;
            font-weight: 700;
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .auth-form input[type="text"],
        .auth-form input[type="email"],
        .auth-form input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: #f9fafb;
        }

        .auth-form input:focus {
            outline: none;
            border-color: #059669;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .auth-form .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 16px 0;
        }

        .auth-form .form-check input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .auth-form .form-check label {
            margin: 0;
            font-weight: 400;
            font-size: 14px;
            text-transform: none;
            letter-spacing: normal;
            cursor: pointer;
        }

        .auth-links {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .auth-links p {
            margin: 8px 0;
            color: #6b7280;
            font-size: 14px;
        }

        .auth-links a {
            color: #059669;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .auth-links a:hover {
            color: #047857;
            text-decoration: underline;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fef2f2;
            border: 2px solid #fecaca;
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border: 2px solid #fed7aa;
            color: #92400e;
        }

        /* SOLID GREEN SUBMIT BUTTON - NO GRADIENTS */
        button[type="submit"],
        .btn-primary,
        .auth-btn {
            background: #059669 !important;
            color: white !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 14px 20px !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            transition: all 0.2s !important;
            width: 100%;
        }

        button[type="submit"]:hover,
        .btn-primary:hover,
        .auth-btn:hover {
            background: #047857 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3) !important;
        }

        button[type="submit"]:active,
        .btn-primary:active,
        .auth-btn:active {
            transform: translateY(0);
        }
    </style>

    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">🏸</div>
                <h1>Đăng Nhập</h1>
                <p>Chào mừng bạn quay trở lại!</p>
            </div>

            {!! $form->renderForm() !!}

            <div class="auth-links">
                <p><a href="{{ route('public.member.password.request') }}">Quên mật khẩu?</a></p>
                <p>Chưa có tài khoản? <a href="{{ route('public.member.register') }}">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</section>

<script>
    // Force solid green button - must run after DOM loads
    (function () {
        function applyGreenButton() {
            const btn = document.querySelector('button[type="submit"]');
            if (btn) {
                btn.style.cssText = 'background: #059669 !important; color: white !important; border: none !important; border-radius: 12px !important; padding: 14px 20px !important; font-weight: 700 !important; font-size: 16px !important; width: 100% !important;';

                btn.onmouseenter = function () { this.style.background = '#047857 !important'; this.style.transform = 'translateY(-1px)'; };
                btn.onmouseleave = function () { this.style.background = '#059669 !important'; this.style.transform = 'translateY(0)'; };
                btn.onmousedown = function () { this.style.transform = 'translateY(0)'; };
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', applyGreenButton);
        } else {
            applyGreenButton();
        }

        // Reapply after 100ms to ensure override
        setTimeout(applyGreenButton, 100);
    })();
</script>