@php
    Theme::layout('default');
    Theme::set('pageTitle', 'Quên mật khẩu');
@endphp

<section class="auth-section">
    <style>
        .auth-section {
            min-height: calc(100vh - 200px);
            padding: 60px 0;
            background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 50%, #f0f9ff 100%);
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
            background: linear-gradient(90deg, #065f46, #059669, #14b8a6);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, #10b981, #14b8a6);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 42px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.25);
        }

        .auth-header h1 {
            font-size: 28px;
            font-weight: 900;
            margin: 0 0 8px 0;
            background: linear-gradient(135deg, #065f46, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-header p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .info-box {
            background: linear-gradient(180deg, #ecfeff, #f0fdfa);
            border: 2px solid #a7f3d0;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #065f46;
            line-height: 1.6;
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

        .auth-form input[type="email"] {
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
            border-color: #10b981;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .auth-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(90deg, #065f46, #059669, #14b8a6);
            background-size: 200% 100%;
            color: #fff;
            border: none;
            border-radius: 14px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 14px rgba(6, 95, 70, 0.3);
        }

        .auth-btn:hover {
            background-position: 100% 0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 95, 70, 0.4);
        }

        .auth-btn:active {
            transform: translateY(0);
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
            color: #10b981;
            text-decoration: underline;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #f0fdfa;
            border: 2px solid #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            border: 2px solid #fecaca;
            color: #991b1b;
        }
    </style>

    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">🔑</div>
                <h1>Quên Mật Khẩu</h1>
                <p>Nhập email của bạn để nhận liên kết đặt lại mật khẩu</p>
            </div>

            <div class="info-box">
                💡 Chúng tôi sẽ gửi một liên kết đặt lại mật khẩu đến email của bạn. Vui lòng kiểm tra cả hộp thư spam
                nếu không thấy email.
            </div>

            {!! $form->renderForm() !!}

            <div class="auth-links">
                <p>Nhớ mật khẩu rồi? <a href="{{ route('public.member.login') }}">Đăng nhập</a></p>
                <p>Chưa có tài khoản? <a href="{{ route('public.member.register') }}">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</section>