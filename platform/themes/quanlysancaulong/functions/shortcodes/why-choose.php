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
    Shortcode::register('why-choose', __('Why choose section'), __('Section ly do chon chung toi'), function (ShortcodeCompiler $shortcode) {
        $quantity = (int) $shortcode->quantity;
        $tabs = [];

        if ($quantity > 0) {
            $fieldNames = [
                'item_title', 'item_desc', 'item_title_color', 'item_desc_color',
            ];

            $max = min(12, $quantity);
            for ($i = 1; $i <= $max; $i++) {
                $tabData = [];
                foreach ($fieldNames as $fieldName) {
                    $tabData[$fieldName] = $shortcode->{$fieldName . '_' . $i};
                }
                $tabs[] = $tabData;
            }
        }

        return Theme::partial('shortcodes.why-choose', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('why-choose', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()->label(__('Tiêu đề chính'))->toArray()
            )
            ->add(
                'subtitle',
                TextField::class,
                TextFieldOption::make()->label(__('Mô tả ngắn'))->toArray()
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->label(__('Các lý do'))
                    ->fields([
                        'item_title' => [
                            'title' => __('Tiêu đề mục'),
                        ],
                        'item_desc' => [
                            'title' => __('Mô tả mục'),
                        ],
                        'item_title_color' => [
                            'title' => __('Màu tiêu đề mục'),
                            'type' => 'color',
                        ],
                        'item_desc_color' => [
                            'title' => __('Màu mô tả mục'),
                            'type' => 'color',
                        ],
                    ])
                    ->max(9)
                    ->min(1)
                    ->attrs($attributes)
                    ->toArray()
            )
            ->add(
                'title_color',
                ColorField::class,
                ColorFieldOption::make()->label(__('Màu tiêu đề chính'))->toArray()
            )
            ->add(
                'subtitle_color',
                ColorField::class,
                ColorFieldOption::make()->label(__('Màu mô tả ngắn'))->toArray()
            );
    });
});

