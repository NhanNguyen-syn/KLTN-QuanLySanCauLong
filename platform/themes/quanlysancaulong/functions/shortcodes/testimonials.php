<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;

use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Media\Facades\RvMedia;

Shortcode::register('testimonials', __('Testimonials'), __('Testimonials'), function (ShortcodeCompiler $shortcode) {
    $testimonials = [];
    $rawTestimonials = (array) ($shortcode->testimonials ?: []);

    // Check if data is from the new ShortcodeTabsField format
    if (!empty($rawTestimonials) && is_array($rawTestimonials) && isset($rawTestimonials[0]['name'])) {
        foreach ($rawTestimonials as $item) {
            if (is_array($item)) {
                if (!empty($item['avatar'])) {
                    $item['avatar'] = RvMedia::getImageUrl($item['avatar']);
                }
                $testimonials[] = $item;
            }
        }
    } else {
        // Fallback for legacy quantity-based fields
        $quantity = (int)($shortcode->quantity ?: 0);
        if ($quantity > 0) {
            for ($i = 1; $i <= $quantity; $i++) {
                if ($shortcode->{'name_' . $i}) {
                    $avatarUrl = $shortcode->{'avatar_' . $i};
                    if ($avatarUrl) {
                        $avatarUrl = RvMedia::getImageUrl($avatarUrl);
                    }

                    $testimonials[] = [
                        'name' => $shortcode->{'name_' . $i},
                        'role' => $shortcode->{'role_' . $i},
                        'avatar' => $avatarUrl,
                        'content' => $shortcode->{'content_' . $i},
                        'stars' => (int)$shortcode->{'stars_' . $i},
                    ];
                }
            }
        }
    }

    return Theme::partial('shortcodes.testimonials', compact('shortcode', 'testimonials'));
});

Shortcode::setAdminConfig('testimonials', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->defaultValue('What our members say')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextareaField::class,
            TextareaFieldOption::make()
                ->label(__('Subtitle'))
                ->rows(2)
                ->defaultValue('Our students love the coaching, fun training sessions, and the chance to improve their skills while enjoying every moment on the court.')
                ->toArray()
        )
        ->add(
            'title_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Title Color'))->defaultValue('#153E35')->toArray()
        )
        ->add(
            'subtitle_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Subtitle Color'))->defaultValue('#6b7280')->toArray()
        )
        ->add(
            'bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Background Color'))->defaultValue('#F3F7F5')->toArray()
        )
        ->add(
            'card_bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Card Background Color'))->defaultValue('#ffffff')->toArray()
        )
        ->add(
            'star_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Star Color'))->defaultValue('#C6F432')->toArray()
        )
        ->add(
            'speed',
            NumberField::class,
            InputFieldOption::make()->label(__('Row 1 speed (ms)'))->placeholder(5000)->toArray()
        )
        ->add(
            'second_row_speed',
            NumberField::class,
            InputFieldOption::make()->label(__('Row 2 speed (ms)'))->placeholder(7000)->toArray()
        )
        ->add(
            'button_text',
            TextField::class,
            TextFieldOption::make()->label(__('Button Text'))->defaultValue('See more')->toArray()
        )
        ->add(
            'button_url',
            TextField::class,
            TextFieldOption::make()->label(__('Button URL'))->defaultValue('#')->toArray()
        )
        ->add(
            'button_bg_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Button Background Color'))->defaultValue('#C6F432')->toArray()
        )
        ->add(
            'button_text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()->label(__('Button Text Color'))->defaultValue('#153E35')->toArray()
        )
        ->add(
            'testimonials',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Testimonials'))
                ->fields([
                    'name' => [
                        'type' => 'text',
                        'title' => __('Name'),
                        'required' => true,
                    ],
                    'avatar' => [
                        'type' => 'image',
                        'title' => __('Avatar Image'),
                    ],
                    'content' => [
                        'type' => 'textarea',
                        'title' => __('Testimonial Content'),
                        'required' => true,
                    ],
                    'stars' => [
                        'type' => 'number',
                        'title' => __('Rating (1--5 stars)'),
                        'attributes' => [
                            'min' => 1,
                            'max' => 5,
                            'step' => 1,
                        ],
                    ],
                ])
                ->attrs($attributes)
                ->toArray()
        );
});

