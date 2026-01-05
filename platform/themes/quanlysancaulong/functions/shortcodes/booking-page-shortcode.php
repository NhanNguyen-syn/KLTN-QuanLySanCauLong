<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;

Shortcode::register('booking-page', 'Booking Page', 'Booking Page', function (ShortcodeCompiler $shortcode) {
    return Theme::partial('shortcodes.booking-page', compact('shortcode'));
});

Shortcode::setAdminConfig('booking-page', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->add('title', TextField::class, TextFieldOption::make()->label('Title')->defaultValue('Bảng Đặt Sân')->toArray())
        ->add('subtitle', TextareaField::class, TextareaFieldOption::make()->label('Subtitle')->defaultValue('Chọn khung giờ phù hợp trên bảng bên dưới. Bạn có thể chọn nhiều khung giờ liên tiếp hoặc trên nhiều sân khác nhau.')->toArray());
});
