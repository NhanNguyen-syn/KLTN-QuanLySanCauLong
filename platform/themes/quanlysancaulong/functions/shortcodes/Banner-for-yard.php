<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

// ============================================================================
// REGISTER SHORTCODE
// ============================================================================

Shortcode::register('banner-for-yard', __('Banner for yard'), __('Banner for yard'), function (ShortcodeCompiler $shortcode) {
    return Theme::partial('shortcodes.banner-for-yard', compact('shortcode'));
});

// ============================================================================
// ADMIN CONFIG
// ============================================================================

Shortcode::setAdminConfig('banner-for-yard', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        // Content Settings
        ->add(
            'title',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Title'))
                ->placeholder(__('Nhập tiêu đề'))
                ->rows(2)
                ->toArray()
        )
        ->add(
            'title_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Title color'))
                ->defaultValue('#ffffff')
                ->toArray()
        )
        ->add(
            'description',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Description'))
                ->rows(3)
                ->placeholder(__('Mô tả ngắn nằm dưới tiêu đề'))
                ->toArray()
        )
        // Background Settings
        ->add(
            'background_image',
            MediaImageField::class,
            InputFieldOption::make()
                ->label(__('Background Image'))
                ->toArray()
        )
        ->add(
            'overlay_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Overlay Color'))
                ->defaultValue('rgba(0, 0, 0, 0.35)')
                ->toArray()
        )
        // Button Settings
        ->add(
            'button_text',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Button Text'))
                ->placeholder(__('Xem thêm'))
                ->toArray()
        )
        ->add(
            'button_url',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Button URL'))
                ->placeholder(route('public.index'))
                ->toArray()
        )
        ->add(
            'button_bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Button background color'))
                ->defaultValue('#0d6efd')
                ->toArray()
        )
        ->add(
            'button_text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Button text color'))
                ->defaultValue('#ffffff')
                ->toArray()
        );
});

