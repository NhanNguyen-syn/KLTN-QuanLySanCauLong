<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('policy-support', __('Policy - Support'), __('Policy Support Section'), function (ShortcodeCompiler $shortcode) {
    return Theme::partial('shortcodes.policy-support', compact('shortcode'));
});

Shortcode::setAdminConfig('policy-support', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Title'))
                ->defaultValue('Cần Hỗ Trợ?')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Subtitle'))
                ->defaultValue('Liên hệ nếu có thắc mắc về chính sách')
                ->toArray()
        )
        ->add(
            'background_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Section Background Color'))
                ->defaultValue('rgba(236, 245, 241, 0.3)')
                ->toArray()
        )
        
        // --- Phone Card ---
        ->add(
            'phone_title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Phone Box Title'))
                ->defaultValue('Điện Thoại')
                ->toArray()
        )
        ->add(
            'phone_value',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Phone Number'))
                ->defaultValue('(84) 0886 264 644')
                ->toArray()
        )
        ->add(
            'phone_border_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Phone Border Color'))
                ->defaultValue('#065f46')
                ->toArray()
        )
        ->add(
            'phone_text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Phone Text Color'))
                ->defaultValue('#065f46')
                ->toArray()
        )

        // --- Email Card ---
        ->add(
            'email_title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Email Box Title'))
                ->defaultValue('Email')
                ->toArray()
        )
        ->add(
            'email_value',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Email Address'))
                ->defaultValue('info@sancaulongnienthoi.vn')
                ->toArray()
        )
        ->add(
            'email_border_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Email Border Color'))
                ->defaultValue('#059669')
                ->toArray()
        )
        ->add(
            'email_text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Email Text Color'))
                ->defaultValue('#059669')
                ->toArray()
        );
});
