<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\FieldOptions\ColorFieldOption;

add_action('init', function () {
    Shortcode::register('court-pricing', __('Court Pricing'), __('Court pricing section'), function (ShortcodeCompiler $shortcode) {
        // Prefer data from ShortcodeTabsField
        $tabs = (array) ($shortcode->tabs ?: []);

        // Backward-compatible: legacy quantity-based fields
        if (empty($tabs)) {
            $quantity = (int) ($shortcode->quantity ?: 0);
            if ($quantity > 0) {
                $fieldNames = [
                    'title', 'price', 'unit', 'tag', 'features',
                    'button_text', 'button_url', 'card_bg_color', 'card_text_color',
                    'tag_bg_color', 'tag_text_color', 'button_bg_color', 'button_text_color',
                ];
                for ($i = 1; $i <= $quantity; $i++) {
                    $tabData = [];
                    foreach ($fieldNames as $fieldName) {
                        $tabData[$fieldName] = $shortcode->{$fieldName . '_' . $i};
                    }
                    $tabs[] = $tabData;
                }
            }
        }

        return Theme::partial('shortcodes.court-pricing', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('court-pricing', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                ->label(__('Tiêu đề chính'))
                ->toArray()
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()
                ->label(__('Mô tả ngắn'))
                ->toArray()
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Các gói giá'))
                    ->fields([
                        'title' => [
                            'title' => __('Tên gói (vd: Sân 1-3)'),
                        ],
                        'price' => [
                            'title' => __('Giá'),
                        ],
                        'unit' => [
                            'title' => __('Đơn vị (vd: đ/giờ)'),
                        ],
                        'tag' => [
                            'title' => __('Nhãn (vd: Khách Vãng Lai)'),
                        ],
                        'features' => [
                            'type' => 'textarea',
                            'title' => __('Các tiện ích (mỗi dòng một tiện ích)'),
                        ],
                        'button_text' => [
                            'title' => __('Chữ trên nút'),
                        ],
                        'button_url' => [
                            'title' => __('Link của nút'),
                        ],
                        'card_bg_color' => [
                            'type' => 'color',
                            'title' => __('Màu nền phần trên thẻ'),
                        ],
                        'card_text_color' => [
                            'type' => 'color',
                            'title' => __('Màu chữ phần trên thẻ'),
                        ],
                        'tag_bg_color' => [
                            'type' => 'color',
                            'title' => __('Màu nền nhãn'),
                        ],
                        'tag_text_color' => [
                            'type' => 'color',
                            'title' => __('Màu chữ nhãn'),
                        ],
                        'button_bg_color' => [
                            'type' => 'color',
                            'title' => __('Màu nền nút'),
                        ],
                        'button_text_color' => [
                            'type' => 'color',
                            'title' => __('Màu chữ nút'),
                        ],
                    ])
                    ->max(6)
                    ->min(1)
                    ->attrs($attributes)
                    ->toArray()
            )
            ->add(
                'view_all_text',
                TextField::class,
                TextFieldOption::make()
                ->label(__('Chữ xem tất cả'))
                ->toArray()
            )
            ->add(
                'view_all_url',
                TextField::class,
                TextFieldOption::make()
                ->label(__('Link xem tất cả'))
                ->toArray()
            )
            ->add(
                'title_color',
                ColorField::class,
                ColorFieldOption::make()
                ->label(__('Màu tiêu đề chính'))
                ->toArray()
            )
            ->add(
                'subtitle_color',
                ColorField::class,
                ColorFieldOption::make()
                ->label(__('Màu mô tả ngắn'))
                ->toArray()
            )
            ->add(
                'view_all_color',
                ColorField::class,
                ColorFieldOption::make()
                ->label(__('Màu chữ xem tất cả'))
                ->toArray()
            );
    });
});
