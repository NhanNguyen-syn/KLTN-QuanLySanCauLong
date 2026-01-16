<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('about-cta', __('About - CTA'), __('About Us Call to Action Section'), function (ShortcodeCompiler $shortcode) {
    return Theme::partial('shortcodes.about-cta', compact('shortcode'));
});

Shortcode::setAdminConfig('about-cta', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->defaultValue('Gia Nhập Cộng Đồng BadmintonPro')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Subtitle'))
                ->rows(2)
                ->defaultValue('Dù bạn là người mới bắt đầu hay vận động viên chuyên nghiệp, chúng tôi luôn có chỗ dành cho bạn.')
                ->toArray()
        )
        ->add(
            'background_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Background Color'))
                ->defaultValue('#ffffff')
                ->toArray()
        )
        ->add(
            'button_text',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Button Text'))
                ->defaultValue('Liên Hệ Hợp Tác')
                ->toArray()
        )
        ->add(
            'button_url',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Button URL'))
                ->defaultValue('/lien-he')
                ->toArray()
        )
        ->add(
            'button_bg_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Button Background Color'))
                ->defaultValue('#065e45')
                ->toArray()
        )
        ->add(
            'button_text_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Button Text Color'))
                ->defaultValue('#ffffff')
                ->toArray()
        );
});
