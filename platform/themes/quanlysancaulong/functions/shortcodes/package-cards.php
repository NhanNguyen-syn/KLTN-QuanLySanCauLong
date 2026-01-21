<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

add_action('init', function () {
    Shortcode::register('package-cards', __('Package Cards'), __('Comparison cards for customer packages'), function (ShortcodeCompiler $shortcode) {
        
        // Package 1
        $package1Features = [];
        if (!empty($shortcode->package1_features)) {
            $package1Features = array_filter(array_map('trim', explode("\n", $shortcode->package1_features)));
        }
        
        // Package 2  
        $package2Features = [];
        if (!empty($shortcode->package2_features)) {
            $package2Features = array_filter(array_map('trim', explode("\n", $shortcode->package2_features)));
        }
        
        $packages = [
            [
                'icon' => $shortcode->package1_icon ?: '👥',
                'title' => $shortcode->package1_title ?: 'Khách Vãng Lai',
                'description' => $shortcode->package1_description ?: 'Đặt sân linh hoạt theo nhu cầu sử dụng',
                'subtitle' => $shortcode->package1_subtitle ?: 'Đặt khung giờ cố định và theo ngày',
                'price' => $shortcode->package1_price ?: '',
                'price_unit' => $shortcode->package1_price_unit ?: '',
                'features' => $package1Features ?: [
                    'Nước uống 10L miễn phí',
                    'Khăn ướt cao cấp',
                    'Ưu tiên đặt sân trước 1 giờ',
                    'Quà tặng hàng tháng'
                ],
                'button_text' => $shortcode->package1_button_text ?: '',
                'button_url' => $shortcode->package1_button_url ?: '/dat-san?type=casual',
                'is_featured' => false,
            ],
            [
                'icon' => $shortcode->package2_icon ?: '⭐',
                'title' => $shortcode->package2_title ?: 'Khách Cố Định',
                'description' => $shortcode->package2_description ?: 'Đặt sân cố định với ưu đãi đặc biệt',
                'subtitle' => $shortcode->package2_subtitle ?: 'Đặt khung giờ cố định và theo ngày',
                'price' => $shortcode->package2_price ?: '',
                'price_unit' => $shortcode->package2_price_unit ?: '',
                'features' => $package2Features ?: [
                    'Nước ion không giới hạn',
                    'Khăn khô cao cấp',
                    'Ăn nhẹ 4-6 người/tuần',
                    'Giá ưu đãi 120k/giờ',
                    'Hỗ trợ VIP 24/7',
                    'Huấn luyện 1-1 mỗi tháng'
                ],
                'button_text' => $shortcode->package2_button_text ?: '',
                'button_url' => $shortcode->package2_button_url ?: '/goi-thanh-vien',
                'is_featured' => ($shortcode->package2_featured ?: 'yes') === 'yes',
            ],
        ];

        return Theme::partial('shortcodes.package-cards.index', [
            'shortcode' => $shortcode,
            'packages' => $packages,
            'title' => $shortcode->title ?: 'Đối Tượng Khách Hàng',
            'description' => $shortcode->description ?: 'Chọn loại hình phù hợp với nhu cầu sử dụng sân của bạn',
            'footer_text' => $shortcode->footer_text ?: 'Nhấn vào loại khách hàng để bắt đầu đặt sân',
            
            // Colors
            'bg_color' => $shortcode->bg_color ?: '#F7FAF5',
            'title_color' => $shortcode->title_color ?: '#0A2918',
            'description_color' => $shortcode->description_color ?: '#065e45',
            'icon_bg_color' => $shortcode->icon_bg_color ?: '#065e45',
            'subtitle_color' => $shortcode->subtitle_color ?: '#065e45',
        ]);
    });

    Shortcode::setAdminConfig('package-cards', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            // Section general
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Tiêu đề section'))->toArray())
            ->add('description', TextField::class, TextFieldOption::make()->label(__('Mô tả section'))->toArray())
            ->add('footer_text', TextField::class, TextFieldOption::make()->label(__('Text footer'))->toArray())
            
            // Colors
            ->add('bg_color', ColorField::class, ColorFieldOption::make()->label(__('Màu nền section'))->defaultValue('#F7FAF5')->toArray())
            ->add('title_color', ColorField::class, ColorFieldOption::make()->label(__('Màu tiêu đề'))->defaultValue('#0A2918')->toArray())
            ->add('description_color', ColorField::class, ColorFieldOption::make()->label(__('Màu mô tả'))->defaultValue('#065e45')->toArray())
            ->add('icon_bg_color', ColorField::class, ColorFieldOption::make()->label(__('Màu icon box'))->defaultValue('#065e45')->toArray())
            ->add('subtitle_color', ColorField::class, ColorFieldOption::make()->label(__('Màu subtitle'))->defaultValue('#065e45')->toArray())
            
            // Package 1 - Khách Vãng Lai
            ->add('package1_icon', TextField::class, TextFieldOption::make()->label(__('[Package 1] Icon (emoji)'))->placeholder('👥')->toArray())
            ->add('package1_title', TextField::class, TextFieldOption::make()->label(__('[Package 1] Tiêu đề'))->placeholder('Khách Vãng Lai')->toArray())
            ->add('package1_description', TextField::class, TextFieldOption::make()->label(__('[Package 1] Mô tả'))->toArray())
            ->add('package1_subtitle', TextField::class, TextFieldOption::make()->label(__('[Package 1] Subtitle'))->toArray())
            ->add('package1_price', TextField::class, TextFieldOption::make()->label(__('[Package 1] Giá'))->toArray())
            ->add('package1_price_unit', TextField::class, TextFieldOption::make()->label(__('[Package 1] Đơn vị giá'))->placeholder('đ/giờ')->toArray())
            ->add('package1_features', TextareaField::class, [
                'label' => __('[Package 1] Features (mỗi dòng 1 item)'),
                'attr' => ['rows' => 5, 'placeholder' => "Nước uống 10L miễn phí\nKhăn ướt cao cấp\nƯu tiên đặt sân"],
            ])
            ->add('package1_button_text', TextField::class, TextFieldOption::make()->label(__('[Package 1] Text button'))->toArray())
            ->add('package1_button_url', TextField::class, TextFieldOption::make()->label(__('[Package 1] URL button'))->placeholder('/dat-san')->toArray())
            
            // Package 2 - Khách Cố Định
            ->add('package2_icon', TextField::class, TextFieldOption::make()->label(__('[Package 2] Icon (emoji)'))->placeholder('⭐')->toArray())
            ->add('package2_title', TextField::class, TextFieldOption::make()->label(__('[Package 2] Tiêu đề'))->placeholder('Khách Cố Định')->toArray())
            ->add('package2_description', TextField::class, TextFieldOption::make()->label(__('[Package 2] Mô tả'))->toArray())
            ->add('package2_subtitle', TextField::class, TextFieldOption::make()->label(__('[Package 2] Subtitle'))->toArray())
            ->add('package2_price', TextField::class, TextFieldOption::make()->label(__('[Package 2] Giá'))->toArray())
            ->add('package2_price_unit', TextField::class, TextFieldOption::make()->label(__('[Package 2] Đơn vị giá'))->placeholder('đ/giờ')->toArray())
            ->add('package2_features', TextareaField::class, [
                'label' => __('[Package 2] Features (mỗi dòng 1 item)'),
                'attr' => ['rows' => 6, 'placeholder' => "Nước ion không giới hạn\nKhăn khô cao cấp\nHỗ trợ VIP 24/7"],
            ])
            ->add('package2_button_text', TextField::class, TextFieldOption::make()->label(__('[Package 2] Text button'))->toArray())
            ->add('package2_button_url', TextField::class, TextFieldOption::make()->label(__('[Package 2] URL button'))->placeholder('/goi-thanh-vien')->toArray());
    });
});
