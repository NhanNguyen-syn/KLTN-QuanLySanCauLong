<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('about-intro', __('About - Intro'), __('About Us Introduction Section'), function (ShortcodeCompiler $shortcode) {
    return Theme::partial('shortcodes.about-intro', compact('shortcode'));
});

Shortcode::setAdminConfig('about-intro', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->defaultValue('Câu Chuyện Của Chúng Tôi')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Subtitle'))
                ->defaultValue('Nâng Tầm Trải Nghiệm Cầu Lông Việt')
                ->toArray()
        )
        ->add(
            'background_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Background Color'))
                ->defaultValue('#ffffff')
                ->toArray()
        )
        ->add(
            'title_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Badge/Title Text Color'))
                ->defaultValue('#065e45')
                ->toArray()
        )
        ->add(
            'title_bg_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Badge/Title Background Color'))
                ->defaultValue('rgba(6, 94, 69, 0.1)')
                ->toArray()
        )
        ->add(
            'heading_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Heading Color'))
                ->defaultValue('#153E35')
                ->toArray()
        )
        ->add(
            'text_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Content Text Color'))
                ->defaultValue('#4b7d70')
                ->toArray()
        )
        ->add(
            'stat_bg_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Stat Box Background Color'))
                ->defaultValue('rgba(241, 245, 249, 0.3)')
                ->toArray()
        )
        ->add(
            'stat_text_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Stat Value Color'))
                ->defaultValue('#065e45')
                ->toArray()
        )
        ->add(
            'stat_label_color',
            \Botble\Shortcode\Forms\Fields\ShortcodeColorField::class,
            \Botble\Base\Forms\FieldOptions\InputFieldOption::make()
                ->label(__('Stat Label Color'))
                ->defaultValue('#4b7d70')
                ->toArray()
        )
        ->add(
            'content',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Content Paragraph 1'))
                ->rows(3)
                ->defaultValue('Được thành lập vào năm 2023, Sân cầu lông Niên Thời ra đời với mong muốn giải quyết bài toán thiếu hụt sân chơi chất lượng cao cho cộng đồng yêu cầu lông.')
                ->toArray()
        )
        ->add(
            'sub_content',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Content Paragraph 2'))
                ->rows(4)
                ->defaultValue('Chúng tôi tin rằng một sân đấu tốt không chỉ cần mặt sàn chuẩn, ánh sáng tốt mà còn cần một hệ thống dịch vụ chuyên nghiệp, tận tâm và tiện lợi. Đó là lý do Sân cầu lông Niên Thời đầu tư mạnh mẽ vào cơ sở vật chất và công nghệ quản lý ngay từ những ngày đầu.')
                ->toArray()
        )
        ->add(
            'stat_1_value',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Stat 1 Value'))
                ->defaultValue('10+')
                ->toArray()
        )
        ->add(
            'stat_1_label',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Stat 1 Label'))
                ->defaultValue('Sân Chuẩn Quốc Tế')
                ->toArray()
        )
        ->add(
            'stat_2_value',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Stat 2 Value'))
                ->defaultValue('5000+')
                ->toArray()
        )
        ->add(
            'stat_2_label',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Stat 2 Label'))
                ->defaultValue('Thành Viên Tin Cậy')
                ->toArray()
        )
        ->add(
            'image',
            MediaImageField::class,
            InputFieldOption::make()
                ->label(__('Image'))
                ->toArray()
        );
});
