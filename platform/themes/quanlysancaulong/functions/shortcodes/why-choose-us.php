<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

use Botble\Media\Facades\RvMedia;

Shortcode::register('why-choose-us', __('Why Choose Us'), __('Why Choose Us'), function (ShortcodeCompiler $shortcode) {
    $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'icon', 'color', 'title_color', 'description_color'], $shortcode);

    foreach ($tabs as &$tab) {
        if (! empty($tab['icon'])) {
            $tab['icon'] = RvMedia::getImageUrl($tab['icon']);
        }
    }

    return Theme::partial('shortcodes.why-choose-us', [
        'title' => $shortcode->title,
        'subtitle' => $shortcode->subtitle,
        'title_color' => $shortcode->title_color,
        'subtitle_color' => $shortcode->subtitle_color,
        'tabs' => $tabs,
    ]);
});

Shortcode::setAdminConfig('why-choose-us', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add('title', TextField::class, InputFieldOption::make()->label(__('Title'))->required()->toArray())
        ->add('title_color', ShortcodeColorField::class, InputFieldOption::make()->label(__('Title Color'))->defaultValue('#0E6B5C')->toArray())
        ->add('subtitle', TextField::class, InputFieldOption::make()->label(__('Subtitle'))->toArray())
        ->add('subtitle_color', ShortcodeColorField::class, InputFieldOption::make()->label(__('Subtitle Color'))->defaultValue('#6c757d')->toArray())
        ->add(
            'tabs',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Tabs'))
                ->fields([
                    'title' => [
                        'type' => 'text',
                        'title' => __('Title'),
                        'required' => true,
                    ],
                    'title_color' => [
                        'type' => 'color',
                        'title' => __('Item Title Color'),
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'title' => __('Description'),
                    ],
                    'description_color' => [
                        'type' => 'color',
                        'title' => __('Item Description Color'),
                    ],
                    'icon' => [
                        'type' => 'image',
                        'title' => __('Icon'),
                    ],
                    'color' => [
                        'type' => 'color',
                        'title' => __('Icon Background Color'),
                    ],
                ])
                ->max(4)
                ->min(1)
                ->attrs($attributes)
                ->toArray()
        );
});

