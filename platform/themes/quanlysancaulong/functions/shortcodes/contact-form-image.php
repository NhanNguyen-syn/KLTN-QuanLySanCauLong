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

Shortcode::register('contact-form-image', __('Contact Form Image'), __('Contact Form with Image'), function (ShortcodeCompiler $shortcode) {
    // Normalize and provide sensible defaults for new attributes
    $shortcode->title = $shortcode->title ?: __('Hãy liên hệ với chúng tôi');
    $shortcode->subtitle = $shortcode->subtitle ?: '';
    $shortcode->image_position = in_array($shortcode->image_position, ['left', 'right']) ? $shortcode->image_position : 'left';
    $shortcode->background = in_array($shortcode->background, ['light', 'none']) ? $shortcode->background : 'light';
    $shortcode->button_text = $shortcode->button_text ?: __('GỬI TIN NHẮN');
    $shortcode->success_message = $shortcode->success_message ?: __('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.');
    $shortcode->failure_message = $shortcode->failure_message ?: __('Có lỗi xảy ra. Vui lòng thử lại.');

    return Theme::partial('shortcodes.contact-form-image', compact('shortcode'));
});

Shortcode::setAdminConfig('contact-form-image', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Title'))
                ->placeholder(__('Hãy liên hệ với chúng tôi'))
                ->rows(2)
                ->toArray()
        )
        ->add(
            'subtitle',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Subtitle'))
                ->placeholder(__('Mô tả ngắn (tùy chọn)'))
                ->toArray()
        )
        ->add(
            'title_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Title Color'))
                ->defaultValue('#1a1a1a')
                ->toArray()
        )
        ->add(
            'label_name',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Label: Name'))
                ->placeholder(__('Họ và Tên'))
                ->defaultValue('Họ và Tên')
                ->toArray()
        )
        ->add(
            'label_phone',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Label: Phone'))
                ->placeholder(__('Số điện thoại'))
                ->defaultValue('Số điện thoại')
                ->toArray()
        )
        ->add(
            'label_email',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Label: Email'))
                ->placeholder(__('Email'))
                ->defaultValue('Email')
                ->toArray()
        )
        ->add(
            'label_subject',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Label: Subject (optional)'))
                ->placeholder(__('Chủ đề (tùy chọn)'))
                ->defaultValue('Chủ đề (tùy chọn)')
                ->toArray()
        )
        ->add(
            'label_message',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Label: Message'))
                ->placeholder(__('Tin nhắn'))
                ->defaultValue('Tin nhắn')
                ->toArray()
        )
        ->add(
            'button_text',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Button Text'))
                ->placeholder(__('GỬI TIN NHẮN'))
                ->defaultValue('GỬI TIN NHẮN')
                ->toArray()
        )
        ->add(
            'button_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Button Background Color'))
                ->defaultValue('#0E6B5C')
                ->toArray()
        )
        ->add(
            'button_text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Button Text Color'))
                ->defaultValue('#ffffff')
                ->toArray()
        )
        ->add(
            'image',
            MediaImageField::class,
            InputFieldOption::make()
                ->label(__('Image'))
                ->toArray()
        )
        ->add(
            'image_url',
            TextField::class,
            TextFieldOption::make()
                ->label(__('External Image URL'))
                ->placeholder(__('https://...'))
                ->toArray()
        )
        ->add(
            'image_alt',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Image Alt'))
                ->placeholder(__('Mô tả ảnh'))
                ->toArray()
        )
        ->add(
            'image_position',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Image Position (left|right)'))
                ->placeholder('left|right')
                ->defaultValue('left')
                ->toArray()
        )
        ->add(
            'background',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Background (light|none)'))
                ->placeholder('light|none')
                ->defaultValue('light')
                ->toArray()
        )
        ->add(
            'success_message',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Success Message'))
                ->placeholder(__('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.'))
                ->defaultValue('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.')
                ->toArray()
        )
        ->add(
            'failure_message',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Failure Message'))
                ->placeholder(__('Có lỗi xảy ra. Vui lòng thử lại.'))
                ->defaultValue('Có lỗi xảy ra. Vui lòng thử lại.')
                ->toArray()
        );
});

