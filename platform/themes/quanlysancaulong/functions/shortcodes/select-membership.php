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
use Botble\Base\Forms\Fields\CheckboxField;
use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;

add_action('init', function () {
    Shortcode::register('select-membership', __('Select Membership'), __('Select Membership pricing table'), function (ShortcodeCompiler $shortcode) {
        // Prefer data from ShortcodeTabsField
        $tabs = (array) ($shortcode->tabs ?: []);

        // Backward-compatible: legacy quantity-based fields
        if (empty($tabs)) {
            $quantity = (int) ($shortcode->quantity ?: 0);
            if ($quantity > 0) {
                $fieldNames = [
                    'price', 'price_color', 'title', 'title_color', 'subtitle', 'subtitle_color',
                    'features', 'features_color', 'button_text', 'button_url', 'button_bg_color',
                    'button_text_color', 'card_bg_color', 'card_border_color', 'is_featured',
                    'featured_badge_text', 'featured_badge_bg', 'featured_badge_color',
                    'discount_badge_text', 'discount_badge_bg', 'discount_badge_color',
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

        // Normalize `is_featured` for the Vue component
        $tabs = array_map(function ($tab) {
            $isFeatured = $tab['is_featured'] ?? 'no';

            return array_merge($tab, [
                'is_featured' => in_array($isFeatured, ['1', 'yes', true], true),
            ]);
        }, $tabs);

        $props = [
            'title' => $shortcode->title,
            'subtitle' => $shortcode->subtitle,
            'titleColor' => $shortcode->title_color,
            'subtitleColor' => $shortcode->subtitle_color,
            'cards' => $tabs,
        ];

        return Theme::partial('shortcodes.select-membership', compact('shortcode', 'props'));
    });

    Shortcode::setAdminConfig('select-membership', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Tiêu đề chính'))->toArray())
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Mô tả ngắn'))->toArray())
            ->add('title_color', ColorField::class, ColorFieldOption::make()->label(__('Màu tiêu đề chính'))->toArray())
            ->add('subtitle_color', ColorField::class, ColorFieldOption::make()->label(__('Màu mô tả ngắn'))->toArray())
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Các gói thành viên'))
                    ->fields([
                        'price' => ['title' => __('Giá (vd: 150.000đ)')],
                        'price_color' => ['type' => 'color', 'title' => __('Màu giá')],
                        'title' => ['title' => __('Tên gói (vd: Khách Vãng Lai)')],
                        'title_color' => ['type' => 'color', 'title' => __('Màu tên gói')],
                        'subtitle' => ['title' => __('Mô tả gói (vd: Dành cho sân linh hoạt)')],
                        'subtitle_color' => ['type' => 'color', 'title' => __('Màu mô tả gói')],
                        'features' => ['type' => 'textarea', 'title' => __('Các tiện ích (mỗi dòng một tiện ích)')],
                        'features_color' => ['type' => 'color', 'title' => __('Màu chữ tiện ích')],
                        'button_text' => ['title' => __('Chữ trên nút')],
                        'button_url' => ['title' => __('Link của nút')],
                        'button_bg_color' => ['type' => 'color', 'title' => __('Màu nền nút')],
                        'button_text_color' => ['type' => 'color', 'title' => __('Màu chữ nút')],
                        'card_bg_color' => ['type' => 'color', 'title' => __('Màu nền thẻ')],
                        'card_border_color' => ['type' => 'color', 'title' => __('Màu viền thẻ')],
                        'is_featured' => ['type' => 'checkbox', 'title' => __('Đây là gói nổi bật?')],
                        'featured_badge_text' => ['title' => __('Chữ trên nhãn nổi bật (vd: PHỔ BIẾN NHẤT)')],
                        'featured_badge_bg' => ['type' => 'color', 'title' => __('Màu nền nhãn nổi bật')],
                        'featured_badge_color' => ['type' => 'color', 'title' => __('Màu chữ nhãn nổi bật')],
                        'discount_badge_text' => ['title' => __('Chữ trên nhãn giảm giá (vd: Tiết kiệm 20%)')],
                        'discount_badge_bg' => ['type' => 'color', 'title' => __('Màu nền nhãn giảm giá')],
                        'discount_badge_color' => ['type' => 'color', 'title' => __('Màu chữ nhãn giảm giá')],
                    ])
                    ->min(1)
                    ->max(4)
                    ->attrs($attributes)
                    ->toArray()
            );
    });
});

