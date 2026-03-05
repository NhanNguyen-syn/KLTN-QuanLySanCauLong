<?php

namespace Botble\Member\Forms\Fronts\Auth;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\Fields\EmailField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Member\Forms\Fronts\Auth\FieldOptions\EmailFieldOption;
use Botble\Member\Http\Requests\Fronts\Auth\ForgotPasswordRequest;

class ForgotPasswordForm extends AuthForm
{
    public static function formTitle(): string
    {
        return trans('plugins/member::member.form.forgot_password_title');
    }

    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('public.member.password.email'))
            ->setValidatorClass(ForgotPasswordRequest::class)
            ->icon('ti ti-lock-question')
            ->heading('Quên mật khẩu')
            ->description('Quên mật khẩu? Vui lòng nhập địa chỉ email của bạn. Bạn sẽ nhận được liên kết để tạo mật khẩu mới qua email.')
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()
                    ->label('Email')
                    ->placeholder('Nhập địa chỉ email')
                    ->icon('ti ti-mail')
            )
            ->submitButton('Gửi liên kết đặt lại mật khẩu')
            ->add('back_to_login', HtmlField::class, [
                'html' => sprintf(
                    '<div class="mt-3 text-center"><a href="%s" class="text-decoration-underline">%s</a></div>',
                    route('public.member.login'),
                    'Quay lại trang đăng nhập'
                ),
            ]);
    }
}
