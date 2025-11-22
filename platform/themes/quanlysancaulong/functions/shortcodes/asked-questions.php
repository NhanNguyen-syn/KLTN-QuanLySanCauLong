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
    Shortcode::register('asked-questions', __('Asked Questions'), __('Asked Questions (FAQ) section'), function (ShortcodeCompiler $shortcode) {
        // Prefer data from ShortcodeTabsField
        $tabs = (array)($shortcode->tabs ?: []);

        // Backward-compatible: legacy quantity-based fields
        if (empty($tabs)) {
            $quantity = (int)($shortcode->quantity ?: 0);
            if ($quantity > 0) {
                for ($i = 1; $i <= $quantity; $i++) {
                    $tabs[] = [
                        'question' => $shortcode->{'question_' . $i},
                        'answer' => $shortcode->{'answer_' . $i},
                    ];
                }
            }
        }

        $props = [
            'title' => $shortcode->title,
            'subtitle' => $shortcode->subtitle,
            'titleColor' => $shortcode->title_color,
            'subtitleColor' => $shortcode->subtitle_color,
            'items' => $tabs,
        ];

        return Theme::partial('shortcodes.asked-questions', compact('shortcode', 'props'));
    });

    Shortcode::setAdminConfig('asked-questions', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Tiêu đề chính'))->toArray())
            ->add('subtitle', TextField::class, TextFieldOption::make()->label(__('Mô tả ngắn'))->toArray())
            ->add('title_color', ColorField::class, ColorFieldOption::make()->label(__('Màu tiêu đề'))->toArray())
            ->add('subtitle_color', ColorField::class, ColorFieldOption::make()->label(__('Màu mô tả ngắn'))->toArray())
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Danh sách câu hỏi'))
                    ->fields([
                        'question' => ['title' => __('Câu hỏi')],
                        'answer' => ['type' => 'textarea', 'title' => __('Câu trả lời')],
                    ])
                    ->min(1)
                    ->attrs($attributes)
                    ->toArray()
            );
    });
});

