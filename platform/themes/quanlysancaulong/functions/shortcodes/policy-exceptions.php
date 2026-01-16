<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('policy-exceptions', __('Policy - Exceptions'), __('Policy Exceptions Section'), function (ShortcodeCompiler $shortcode) {
    $items = [];
    $quantity = (int) $shortcode->quantity;

    if ($quantity > 0) {
        // Handle quantity-based attributes (content_1, content_2, ...)
        for ($i = 1; $i <= $quantity; $i++) {
            $content = $shortcode->{"content_{$i}"};
            if ($content) {
                $items[] = [
                    'content' => $content,
                ];
            }
        }
    } else {
        // Handle JSON based attributes (ShortcodeTabsField)
        $raw = (array) $shortcode->items;
        if (is_string($shortcode->items)) {
            $decoded = json_decode($shortcode->items, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        } elseif (!empty($raw) && isset($raw[0])) {
             $items = $raw;
        }
    }

    return Theme::partial('shortcodes.policy-exceptions', compact('shortcode', 'items'));
});

Shortcode::setAdminConfig('policy-exceptions', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Title'))
                ->defaultValue('Trường Hợp Ngoại Lệ')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Subtitle'))
                ->defaultValue('Các trường hợp đặc biệt được xử lý linh hoạt')
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
        ->add(
            'primary_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Highlight Border Color'))
                ->defaultValue('#065f46')
                ->toArray()
        )
        ->add(
            'text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Text Color'))
                ->defaultValue('#0a2818')
                ->toArray()
        )
        ->add(
            'items',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Exception Items'))
                ->fields([
                    'content' => [
                        'title' => __('Content'),
                        'type' => 'text',
                        'required' => true,
                    ],
                ])
                ->attrs($attributes)
                ->toArray()
        );
});
