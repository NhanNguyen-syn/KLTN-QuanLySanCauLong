<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

// UI Block: banner-page (separate file for maintainability)

Shortcode::register('banner-page', 'Banner Page', 'Banner Page', function (ShortcodeCompiler $shortcode) {
    // Robustly parse stats even if stats_quantity is not saved
    $attributes = $shortcode->toArray();

    $quantity = (int) ($shortcode->stats_quantity ?? 0);
    if ($quantity <= 0) {
        $quantity = 0;
        foreach ($attributes as $key => $value) {
            if (preg_match('/^stats_(title|description)_(\d+)$/', (string) $key, $m)) {
                if ($value !== null && $value !== '') {
                    $idx = (int) $m[2];
                    if ($idx > $quantity) {
                        $quantity = $idx;
                    }
                }
            }
        }
    }

    $quantity = min($quantity, 20);

    $stats = [];
    for ($i = 1; $i <= $quantity; $i++) {
        $title = $shortcode->{"stats_title_{$i}"} ?? null;
        $description = $shortcode->{"stats_description_{$i}"} ?? null;

        if (($title !== null && $title !== '') || ($description !== null && $description !== '')) {
            $stats[] = [
                'title' => $title,
                'description' => $description,
            ];
        }
    }

    return Theme::partial('shortcodes.banner-page', [
        'shortcode' => $shortcode,
        'stats' => $stats,
    ]);
});

Shortcode::setAdminConfig('banner-page', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()

        ->add('title', TextareaField::class, TextareaFieldOption::make()->label('Title')->toArray())
        ->add('title_color', ColorField::class, ColorFieldOption::make()->label('Title Color')->defaultValue('#ffffff')->toArray())
        ->add('title_accent_color', ColorField::class, ColorFieldOption::make()->label('Title Accent Color (2nd/3rd line)')->defaultValue('#6fd3c3')->toArray())
        ->add('subtitle', TextField::class, TextFieldOption::make()->label('Subtitle')->toArray())
        ->add('subtitle_color', ColorField::class, ColorFieldOption::make()->label('Subtitle Color')->defaultValue('#a7f3d0')->toArray())
        ->add('background_color', ColorField::class, ColorFieldOption::make()->label('Background Color')->defaultValue('#0f766e')->toArray())
        ->add('button_1_text', TextField::class, TextFieldOption::make()->label('Button 1 Text')->toArray())
        ->add('button_1_link', TextField::class, TextFieldOption::make()->label('Button 1 Link')->toArray())
        ->add('button_1_text_color', ColorField::class, ColorFieldOption::make()->label('Button 1 Text Color')->defaultValue('#0f766e')->toArray())
        ->add('button_1_background_color', ColorField::class, ColorFieldOption::make()->label('Button 1 Background Color')->defaultValue('#ffffff')->toArray())
        ->add('button_2_text', TextField::class, TextFieldOption::make()->label('Button 2 Text')->toArray())
        ->add('button_2_link', TextField::class, TextFieldOption::make()->label('Button 2 Link')->toArray())
        ->add('button_2_text_color', ColorField::class, ColorFieldOption::make()->label('Button 2 Text Color')->defaultValue('#ffffff')->toArray())
        ->add('button_2_border_color', ColorField::class, ColorFieldOption::make()->label('Button 2 Border Color')->defaultValue('#ffffff')->toArray())
        // Tabs field for stats (limit 4)
        ->add('stats', 'tabs', [
            'label' => 'Stats (max 4)',
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'title' => 'Title',
                ],
                'description' => [
                    'type' => 'text',
                    'title' => 'Description',
                ],

            ],
            'shortcode_attributes' => $attributes,
            'min' => 1,
            'max' => 4,
            'attr' => [
                'tab_key' => 'stats',
            ],
        ]);
});

