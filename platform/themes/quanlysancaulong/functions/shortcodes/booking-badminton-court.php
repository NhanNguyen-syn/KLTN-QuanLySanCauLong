<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Media\Facades\RvMedia;

add_action('init', function () {
    Shortcode::register('booking-badminton-court', __('Booking Badminton Court'), __('Booking badminton court grid'), function (ShortcodeCompiler $shortcode) {
        $items = [];

        // 1) New builder mode: tabs field from admin UI
        $tabs = (array)($shortcode->tabs ?: []);
        if (!empty($tabs)) {
            foreach ($tabs as $tab) {
                $items[] = [
                    'title' => $tab['title'] ?? '',
                    'description' => $tab['description'] ?? '',
                    'time_1' => $tab['time_1'] ?? '',
                    'time_2' => $tab['time_2'] ?? '',
                    'bg_color' => $tab['bg_color'] ?? '',
                    'text_color' => $tab['text_color'] ?? '',
                    'image' => !empty($tab['image']) ? RvMedia::getImageUrl($tab['image']) : '',
                    'price_label' => $tab['price_label'] ?? '',
                    'price_value' => $tab['price_value'] ?? '',
                    'price_label_color' => $tab['price_label_color'] ?? '',
                    'price_value_color' => $tab['price_value_color'] ?? '',
                    'button_url' => $tab['button_url'] ?? '',
                    'button_bg_color' => $tab['button_bg_color'] ?? '',
                    'button_text_color' => $tab['button_text_color'] ?? '',
                ];
            }
        } else {
            // 2) Backward-compatible mode: numbered attributes title_1, description_1, ...
            $qty = (int)($shortcode->quantity ?: 0);
            if ($qty <= 0) { $qty = 8; }
            for ($i = 1; $i <= $qty; $i++) {
                $title = $shortcode->{"title_{$i}"} ?? '';
                $description = $shortcode->{"description_{$i}"} ?? '';
                $time1 = $shortcode->{"time_1_{$i}"} ?? '';
                $time2 = $shortcode->{"time_2_{$i}"} ?? '';
                $bg = $shortcode->{"bg_color_{$i}"} ?? '';
                $text = $shortcode->{"text_color_{$i}"} ?? '';
                $image = $shortcode->{"image_{$i}"} ?? '';
                // Chuẩn hoá ảnh: nếu không phải URL đầy đủ thì dùng RvMedia để lấy link công khai
                if (!empty($image) && !preg_match('/^https?:\/\//i', $image)) {
                    $image = RvMedia::getImageUrl($image);
                }
                $priceLabel = $shortcode->{"price_label_{$i}"} ?? '';
                $priceValue = $shortcode->{"price_value_{$i}"} ?? '';
                $priceLabelColor = $shortcode->{"price_label_color_{$i}"} ?? '';
                $priceValueColor = $shortcode->{"price_value_color_{$i}"} ?? '';
                $btnUrl = $shortcode->{"button_url_{$i}"} ?? '';
                $btnBg = $shortcode->{"button_bg_color_{$i}"} ?? '';
                $btnText = $shortcode->{"button_text_color_{$i}"} ?? '';

                if ($title || $description || $time1 || $time2) {
                    $items[] = [
                        'title' => $title,
                        'description' => $description,
                        'time_1' => $time1,
                        'time_2' => $time2,
                        'bg_color' => $bg,
                        'text_color' => $text,
                        'image' => $image,
                        'price_label' => $priceLabel,
                        'price_value' => $priceValue,
                        'price_label_color' => $priceLabelColor,
                        'price_value_color' => $priceValueColor,
                        'button_url' => $btnUrl,
                        'button_bg_color' => $btnBg,
                        'button_text_color' => $btnText,
                    ];
                }
            }
        }

        $props = [
            'title' => $shortcode->title,
            'description' => $shortcode->description,
            'titleColor' => $shortcode->title_color,
            'descriptionColor' => $shortcode->description_color,
            'items' => $items,
            'viewAllText' => $shortcode->view_all_text,
            'viewAllUrl' => $shortcode->view_all_url,
            'viewAllBg' => $shortcode->view_all_bg,
            'viewAllColor' => $shortcode->view_all_color,
        ];

        return Theme::partial('shortcodes.booking-badminton-court', compact('shortcode','props'));
    });

    Shortcode::setAdminConfig('booking-badminton-court', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Tiêu đề'))->toArray())
            ->add('title_color', ColorField::class, ColorFieldOption::make()->label(__('Màu tiêu đề'))->toArray())
            ->add('description', TextField::class, TextFieldOption::make()->label(__('Mô tả'))->toArray())
            ->add('description_color', ColorField::class, ColorFieldOption::make()->label(__('Màu mô tả'))->toArray())
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Danh sách sân (tối đa 8)'))
                    ->fields([
                        'title' => [ 'title' => __('Tiêu đề sân') ],
                        'description' => [ 'title' => __('Mô tả ngắn') ],
                        'time_1' => [ 'title' => __('Khung giờ 1 (vd: 08:00 - 09:00)') ],
                        'time_2' => [ 'title' => __('Khung giờ 2 (vd: 12:00 - 13:00)') ],
                        'bg_color' => [ 'type' => 'color', 'title' => __('Màu nền thẻ') ],
                        'text_color' => [ 'type' => 'color', 'title' => __('Màu chữ thẻ') ],
                        'price_label' => [ 'title' => __('Nhãn giá (vd: Giá bắt đầu từ)') ],
                        'price_value' => [ 'title' => __('Giá (vd: 150.000đ/giờ)') ],
                        'price_label_color' => [ 'type' => 'color', 'title' => __('Màu nhãn giá') ],
                        'price_value_color' => [ 'type' => 'color', 'title' => __('Màu giá') ],
                        'image' => [ 'type' => 'image', 'title' => __('Ảnh nền thẻ') ],
                        'button_url' => [ 'title' => __('Link nút (mũi tên)') ],
                        'button_bg_color' => [ 'type' => 'color', 'title' => __('Màu nền nút mũi tên') ],
                        'button_text_color' => [ 'type' => 'color', 'title' => __('Màu mũi tên') ],
                    ])
                    ->max(8)
                    ->min(1)
                    ->attrs($attributes)
                    ->toArray()
            )
            ->add('view_all_text', TextField::class, TextFieldOption::make()->label(__('Chữ nút dưới cùng'))->toArray())
            ->add('view_all_url', TextField::class, TextFieldOption::make()->label(__('Link nút dưới cùng'))->toArray())
            ->add('view_all_bg', ColorField::class, ColorFieldOption::make()->label(__('Màu nền nút dưới cùng'))->toArray())
            ->add('view_all_color', ColorField::class, ColorFieldOption::make()->label(__('Màu chữ nút dưới cùng'))->toArray());
    });
});

