<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Media\Facades\RvMedia;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('about-core-values', __('About - Core Values'), __('About Us Core Values Section'), function (ShortcodeCompiler $shortcode) {
    $values = [];
    $rawValues = (array) ($shortcode->values ?: []);

    // Check if data is from the new ShortcodeTabsField format
    if (!empty($rawValues) && is_array($rawValues) && isset($rawValues[0]['title'])) {
        foreach ($rawValues as $item) {
            if (is_array($item) && !empty($item['title'])) {
                if (!empty($item['icon'])) {
                    $item['icon'] = RvMedia::getImageUrl($item['icon']);
                }
                $values[] = $item;
            }
        }
    } else {
        // Fallback for quantity-based fields (what ShortcodeTabsField often saves as)
        $quantity = (int)($shortcode->quantity ?: 0);
        if ($quantity > 0) {
            for ($i = 1; $i <= $quantity; $i++) {
                if ($shortcode->{'title_' . $i}) {
                    $icon = $shortcode->{'icon_' . $i};
                    if ($icon) {
                        $icon = RvMedia::getImageUrl($icon);
                    }
                    $values[] = [
                        'icon' => $icon,
                        'title' => $shortcode->{'title_' . $i},
                        'description' => $shortcode->{'description_' . $i},
                        'icon_bg' => $shortcode->{'icon_bg_' . $i},
                    ];
                }
            }
        }
    }

    return Theme::partial('shortcodes.about-core-values', compact('shortcode', 'values'));
});

Shortcode::setAdminConfig('about-core-values', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->defaultValue('Giá Trị Cốt Lõi')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Subtitle'))
                ->rows(2)
                ->defaultValue('Những nguyên tắc định hình mọi hoạt động và quyết định của chúng tôi')
                ->toArray()
        )
        ->add(
            'background_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Section Background Color'))
                ->defaultValue('rgba(241, 245, 249, 0.3)')
                ->toArray()
        )
        ->add(
            'values',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Core Values'))
                ->fields([
                    'icon' => [
                        'type' => 'image',
                        'title' => __('Icon Image'),
                    ],
                    'icon_bg' => [
                        'type' => 'color',
                        'title' => __('Icon Background Color'),
                        'value' => '#e0f2fe', // Default light blue/primary-ish
                    ],
                    'title' => [
                        'type' => 'text',
                        'title' => __('Title'),
                        'required' => true,
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => __('Description'),
                        'required' => true,
                    ],
                ])
                ->attrs($attributes)
                ->toArray()
        );
});
