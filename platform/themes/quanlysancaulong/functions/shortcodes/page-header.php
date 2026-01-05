<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\ColorField;

add_action('init', function () {
    Shortcode::register('page-header', __('Page Header'), __('Page Header Section'), function (ShortcodeCompiler $shortcode) {
        $props = [
            'title' => $shortcode->title ?? 'Page Title',
            'subtitle' => $shortcode->subtitle ?? '',
            'background_color' => $shortcode->background_color,
        ];

        return Theme::partial('shortcodes.page-header', ['shortcode' => $shortcode, 'props' => $props]);
    });

    Shortcode::setAdminConfig('page-header', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title'))->defaultValue('Page Title')->toArray())
            ->add('subtitle', TextareaField::class, TextareaFieldOption::make()->label(__('Subtitle'))->rows(2)->toArray())
            ->add('background_color', ColorField::class, ColorFieldOption::make()
                ->label(__('Background (Gradient or Color)'))
                ->defaultValue('linear-gradient(to right, #0E6B5C, #1DB9A2)')
                ->toArray());
    });
});

