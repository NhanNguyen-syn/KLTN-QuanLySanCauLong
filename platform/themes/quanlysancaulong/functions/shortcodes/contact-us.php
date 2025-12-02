<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;

add_action('init', function () {
    Shortcode::register('contact-us', __('Contact Us'), __('Contact Us Section'), function (ShortcodeCompiler $shortcode) {
        // Sanitize iframe code by replacing smart quotes with standard quotes.
        $iframe = str_replace(['“', '”', '`', '‘', '’'], '"', (string) $shortcode->google_maps_iframe);

        // Build other branches array from individual fields
        $otherBranches = [];
        for ($i = 1; $i <= 3; $i++) {
            $title = $shortcode->{"branch_{$i}_title"} ?? '';
            $description = $shortcode->{"branch_{$i}_description"} ?? '';
            $url = $shortcode->{"branch_{$i}_url"} ?? '';

            if (!empty($title) || !empty($description) || !empty($url)) {
                $otherBranches[] = [
                    'title' => $title,
                    'description' => $description,
                    'url' => $url,
                ];
            }
        }

        $props = [
            'formTitle' => $shortcode->form_title,
            'formSubtitle' => $shortcode->form_subtitle,
            'contactFormHtml' => do_shortcode('[contact-form][/contact-form]'),
            'locationTitle' => $shortcode->location_title,
            'googleMapsIframe' => $iframe,
            'mainBranchTitle' => $shortcode->main_branch_title,
            'mainBranchAddress' => $shortcode->main_branch_address,
            'mainBranchPhone' => $shortcode->main_branch_phone,
            'mainBranchMapUrl' => $shortcode->main_branch_map_url,
            'otherBranchesTitle' => $shortcode->other_branches_title,
            'otherBranches' => $otherBranches,
        ];

        return Theme::partial('shortcodes.contact-us', ['shortcode' => $shortcode, 'props' => $props]);
    });

    Shortcode::setAdminConfig('contact-us', function (array $attributes) {
        // No compatibility layer needed for new structure

        return ShortcodeForm::createFromArray($attributes)
            // Left Column: Form
            ->add('form_title', TextField::class, TextFieldOption::make()->label(__('Form Title'))->defaultValue('Gửi Tin Nhắn Cho Chúng Tôi')->toArray())
            ->add('form_subtitle', TextareaField::class, TextareaFieldOption::make()->label(__('Form Subtitle'))->rows(2)->defaultValue('Hãy điền thông tin vào biểu mẫu dưới đây, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.')->toArray())

            // Right Column: Location
            ->add('location_title', TextField::class, TextFieldOption::make()->label(__('Location Title'))->defaultValue('Vị Trí Của Chúng Tôi')->toArray())
            ->add(
                'google_maps_iframe',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Google Maps Iframe Embed Code'))
                    ->rows(4)
                    ->placeholder(__('Paste your Google Maps iframe code here'))
                    ->toArray()
            )
            ->add('main_branch_title', TextField::class, TextFieldOption::make()->label(__('Main Branch Title'))->defaultValue('Chi Nhánh Chính')->toArray())
            ->add('main_branch_address', TextField::class, TextFieldOption::make()->label(__('Main Branch Address'))->toArray())
            ->add('main_branch_phone', TextField::class, TextFieldOption::make()->label(__('Main Branch Phone'))->toArray())
            ->add('main_branch_map_url', TextField::class, TextFieldOption::make()->label(__('Main Branch Google Maps URL'))->placeholder(__('URL for "Chỉ đường" link'))->toArray())

            ->add('other_branches_title', TextField::class, TextFieldOption::make()->label(__('Other Branches Title'))->defaultValue('Chi Nhánh Khác')->toArray())

            // Branch 1
            ->add('branch_1_title', TextField::class, TextFieldOption::make()->label(__('Branch 1 - Title'))->placeholder('e.g., Hasfarm Berries Quận 1')->toArray())
            ->add('branch_1_description', TextareaField::class, TextareaFieldOption::make()->label(__('Branch 1 - Description'))->rows(2)->placeholder('e.g., 123 Nguyễn Hữu Quân 1, TPHCM')->toArray())
            ->add('branch_1_url', TextField::class, TextFieldOption::make()->label(__('Branch 1 - Google Maps URL'))->placeholder('https://maps.google.com/...')->toArray())

            // Branch 2
            ->add('branch_2_title', TextField::class, TextFieldOption::make()->label(__('Branch 2 - Title'))->placeholder('e.g., Hasfarm Berries Quận 7')->toArray())
            ->add('branch_2_description', TextareaField::class, TextareaFieldOption::make()->label(__('Branch 2 - Description'))->rows(2)->placeholder('e.g., 456 Nguyễn Thị Thập Quận 7, TPHCM')->toArray())
            ->add('branch_2_url', TextField::class, TextFieldOption::make()->label(__('Branch 2 - Google Maps URL'))->placeholder('https://maps.google.com/...')->toArray())

            // Branch 3
            ->add('branch_3_title', TextField::class, TextFieldOption::make()->label(__('Branch 3 - Title'))->placeholder('e.g., Hasfarm Berries Hà Nội')->toArray())
            ->add('branch_3_description', TextareaField::class, TextareaFieldOption::make()->label(__('Branch 3 - Description'))->rows(2)->placeholder('e.g., 789 Lăng Hạ Đống Đa, Hà Nội')->toArray())
            ->add('branch_3_url', TextField::class, TextFieldOption::make()->label(__('Branch 3 - Google Maps URL'))->placeholder('https://maps.google.com/...')->toArray());
    });
});
