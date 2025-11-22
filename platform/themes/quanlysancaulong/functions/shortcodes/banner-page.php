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

Shortcode::register('banner-page', __('Banner Page'), __('Banner Page'), function (ShortcodeCompiler $shortcode) {
    return Theme::partial('shortcodes.banner-page', compact('shortcode'));
});

Shortcode::setAdminConfig('banner-page', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Title'))
                ->placeholder(__('Train Hard. Play Smart. Rise Together.'))
                ->rows(3)
                ->toArray()
        )
        ->add(
            'description',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Description'))
                ->rows(3)
                ->placeholder(__('A badminton club for those who want to grow...'))
                ->toArray()
        )
        ->add(
            'background_image',
            MediaImageField::class,
            InputFieldOption::make()
                ->label(__('Background Image'))
                ->toArray()
        )
        ->add(
            'button_text',
            TextField::class,
            TextFieldOption::make()->label(__('Button Text'))->placeholder(__('Become a Member'))->toArray()
        )
        ->add(
            'button_url',
            TextField::class,
            TextFieldOption::make()->label(__('Button URL'))->placeholder(route('public.index'))->toArray()
        )
        ->add(
            'satisfied_text',
            TextField::class,
            TextFieldOption::make()->label(__('Satisfied Text'))->placeholder(__('Satisfied by 1k Users'))->toArray()
        )

        ->add(
            'overlay_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Overlay Color'))
                ->defaultValue('rgba(0, 0, 0, 0.5)')
                ->toArray()
        );
});

