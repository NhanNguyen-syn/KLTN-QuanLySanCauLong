<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('policy-important-notes', __('Policy - Important Notes'), __('Policy Important Notes Section'), function (ShortcodeCompiler $shortcode) {
    $items = [];
    $quantity = (int) $shortcode->quantity;

    if ($quantity > 0) {
        // Handle quantity-based attributes (title_1, description_1, ...)
        for ($i = 1; $i <= $quantity; $i++) {
            $title = $shortcode->{"title_{$i}"};
            $desc = $shortcode->{"description_{$i}"};
            
            if ($title || $desc) {
                $items[] = [
                    'title' => $title,
                    'description' => $desc,
                ];
            }
        }
    } else {
        // Handle JSON based attributes
        $raw = (array) $shortcode->items;
        if (is_string($shortcode->items)) {
            $decoded = json_decode($shortcode->items, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        } elseif (!empty($raw) && isset($raw[0])) {
             $items = $raw;
        }
    }

    return Theme::partial('shortcodes.policy-important-notes', compact('shortcode', 'items'));
});

Shortcode::setAdminConfig('policy-important-notes', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Title'))
                ->defaultValue('Lưu Ý Quan Trọng')
                ->toArray()
        )
        ->add(
            'background_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Section Background Color'))
                ->defaultValue('#f8faf6')
                ->toArray()
        )
        ->add(
            'border_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Card Border Color'))
                ->defaultValue('#e2e8f0')
                ->toArray()
        )
        ->add(
            'primary_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Hover Border Color'))
                ->defaultValue('#065f46')
                ->toArray()
        )
        ->add(
            'title_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Note Title Color'))
                ->defaultValue('#111827')
                ->toArray()
        )
        ->add(
            'text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Note Text Color'))
                ->defaultValue('#4b5563')
                ->toArray()
        )
        ->add(
            'items',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Notes'))
                ->fields([
                    'title' => [
                        'title' => __('Title'),
                        'type' => 'text',
                        'required' => true,
                    ],
                    'description' => [
                        'title' => __('Description'),
                        'type' => 'textarea',
                    ],
                ])
                ->attrs($attributes)
                ->toArray()
        );
});
