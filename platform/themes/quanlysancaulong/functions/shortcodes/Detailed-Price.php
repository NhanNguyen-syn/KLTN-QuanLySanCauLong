<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;


Shortcode::register('detailed-price', __('Detailed Price'), __('Detailed price table with 2 plans'), function (ShortcodeCompiler $shortcode) {
    $plans = [];
    $quantity = (int)($shortcode->quantity ?? 2);

    for ($i = 1; $i <= $quantity; $i++) {
        // Try both formats
        $title = $shortcode->{'title_' . $i} ?? $shortcode->{'plan_' . $i . '_title'} ?? null;
        if (!$title) {
            continue;
        }

        $features = [];
        for ($f = 1; $f <= 6; $f++) {
            $val = $shortcode->{'feature_' . $f . '_' . $i} ?? $shortcode->{'plan_' . $i . '_feature_' . $f} ?? null;
            if ($val) {
                $features[] = $val;
            }
        }

        $plans[] = [
            'title' => $title,
            'badge' => $shortcode->{'badge_' . $i} ?? $shortcode->{'plan_' . $i . '_badge'} ?? null,
            'price' => $shortcode->{'price_' . $i} ?? $shortcode->{'plan_' . $i . '_price'} ?? null,
            'priceSuffix' => $shortcode->{'price_suffix_' . $i} ?? $shortcode->{'plan_' . $i . '_price_suffix'} ?? null,
            'note' => $shortcode->{'note_' . $i} ?? $shortcode->{'plan_' . $i . '_note'} ?? null,
            'buttonText' => $shortcode->{'button_text_' . $i} ?? $shortcode->{'plan_' . $i . '_button_text'} ?? null,
            'buttonUrl' => $shortcode->{'button_url_' . $i} ?? $shortcode->{'plan_' . $i . '_button_url'} ?? null,
            'isFeatured' => filter_var($shortcode->{'featured_' . $i} ?? $shortcode->{'plan_' . $i . '_featured'} ?? false, FILTER_VALIDATE_BOOLEAN),
            'featuredText' => $shortcode->{'featured_text_' . $i} ?? $shortcode->{'plan_' . $i . '_featured_text'} ?? null,
            'headerStartColor' => $shortcode->{'header_start_color_' . $i} ?? $shortcode->{'plan_' . $i . '_header_start_color'} ?? '#1fb383',
            'headerEndColor' => $shortcode->{'header_end_color_' . $i} ?? $shortcode->{'plan_' . $i . '_header_end_color'} ?? '#0e8a61',
            'labelBgColor' => $shortcode->{'label_bg_color_' . $i} ?? $shortcode->{'plan_' . $i . '_label_bg_color'} ?? '#eaf6f1',
            'labelTextColor' => $shortcode->{'label_text_color_' . $i} ?? $shortcode->{'plan_' . $i . '_label_text_color'} ?? ($shortcode->label_color ?? '#0d5e43'),
            'featuredBgColor' => $shortcode->{'featured_bg_color_' . $i} ?? $shortcode->{'plan_' . $i . '_featured_bg_color'} ?? '#0a2818',
            'features' => $features,
        ];
    }

    return Theme::partial('shortcodes.detailed-price', [
        'shortcode' => $shortcode,
        'plans' => $plans,
    ]);
});


Shortcode::setAdminConfig('detailed-price', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        // Section Settings
        ->add(
            'section_title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Title'))
                ->placeholder(__('Bảng Giá Chi Tiết'))
                ->toArray()
        )
        ->add(
            'section_subtitle',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Section Subtitle'))
                ->rows(2)
                ->placeholder(__('Lựa chọn gói phù hợp với nhu cầu của bạn'))
                ->toArray()
        )
        // Color Settings
        ->add(
            'title_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Title Color'))
                ->defaultValue('#0f3d2e')
                ->toArray()
        )
        ->add(
            'label_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Label Color'))
                ->defaultValue('#0d5e43')
                ->toArray()
        )
        // Plans Configuration
        ->add(
            'plans',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Plans'))
                ->fields([
                    // Basic Info
                    'title' => [
                        'type' => 'text',
                        'title' => __('Plan Title'),
                        'default' => __('Khách Vãng Lai')
                    ],
                    'badge' => [
                        'type' => 'text',
                        'title' => __('Badge/Label'),
                        'default' => __('Theo giờ')
                    ],
                    'price' => [
                        'type' => 'text',
                        'title' => __('Price number'),
                        'default' => '150'
                    ],
                    'price_suffix' => [
                        'type' => 'text',
                        'title' => __('Price suffix'),
                        'default' => ',000đ /giờ'
                    ],
                    'note' => [
                        'type' => 'textarea',
                        'title' => __('Short note'),
                        'rows' => 2,
                        'default' => __('Đặt sân linh hoạt, phù hợp chơi linh hoạt')
                    ],
                    // Button Settings
                    'button_text' => [
                        'type' => 'text',
                        'title' => __('Button Text'),
                        'default' => __('Bắt Đầu Ngay')
                    ],
                    'button_url' => [
                        'type' => 'text',
                        'title' => __('Button URL'),
                        'default' => url('/')
                    ],
                    // Featured Badge
                    'featured' => [
                        'type' => 'text',
                        'title' => __('Featured (true/false)'),
                        'default' => 'false'
                    ],
                    'featured_text' => [
                        'type' => 'text',
                        'title' => __('Featured badge text'),
                        'default' => __('PHỔ BIẾN NHẤT')
                    ],
                    // Color Customization
                    'header_start_color' => [
                        'type' => 'color',
                        'title' => __('Header gradient start'),
                        'default' => '#1fb383'
                    ],
                    'header_end_color' => [
                        'type' => 'color',
                        'title' => __('Header gradient end'),
                        'default' => '#0e8a61'
                    ],
                    'label_bg_color' => [
                        'type' => 'color',
                        'title' => __('Label background color'),
                        'default' => '#eaf6f1'
                    ],
                    'label_text_color' => [
                        'type' => 'color',
                        'title' => __('Label text color'),
                        'default' => '#0d5e43'
                    ],
                    'featured_bg_color' => [
                        'type' => 'color',
                        'title' => __('Featured badge bg'),
                        'default' => '#0a2818'
                    ],
                    // Features List
                    'feature_1' => [
                        'type' => 'text',
                        'title' => __('Feature 1'),
                        'default' => __('Sàn gỗ tiêu chuẩn quốc tế')
                    ],
                    'feature_2' => [
                        'type' => 'text',
                        'title' => __('Feature 2'),
                        'default' => __('Chiếu sáng LED chuyên nghiệp')
                    ],
                    'feature_3' => [
                        'type' => 'text',
                        'title' => __('Feature 3'),
                        'default' => __('Điều hoà không khí')
                    ],
                    'feature_4' => [
                        'type' => 'text',
                        'title' => __('Feature 4'),
                        'default' => ''
                    ],
                    'feature_5' => [
                        'type' => 'text',
                        'title' => __('Feature 5'),
                        'default' => ''
                    ],
                    'feature_6' => [
                        'type' => 'text',
                        'title' => __('Feature 6'),
                        'default' => ''
                    ],
                ])
                ->max(2)
                ->attrs($attributes)
                ->toArray()
        );
});

