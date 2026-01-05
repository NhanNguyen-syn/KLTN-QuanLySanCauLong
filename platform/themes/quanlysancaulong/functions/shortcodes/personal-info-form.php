<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\OnOffField;

add_action('init', function () {
    Shortcode::register('personal-info-form', __('Personal Info Form'), __('Personal Info Form Section'), function (ShortcodeCompiler $shortcode) {
        $formFields = [];
        $tabs = (array)($shortcode->tabs ?: []);

        if (!empty($tabs)) {
            // New mode: data from ShortcodeTabsField (from repeater)
            foreach ($tabs as $index => $tab) {
                if (!empty($tab['label'])) {
                    $formFields[] = [
                        'label' => $tab['label'],
                        'placeholder' => $tab['placeholder'] ?? '',
                        'required' => (bool)($tab['required'] ?? false),
                        'fieldName' => 'field_' . ($index + 1),
                    ];
                }
            }
        } else {
            // Legacy mode: data from old attributes like `quantity` or `num_fields`
            $quantity = (int) ($shortcode->quantity ?: $shortcode->num_fields ?: 0);
            for ($i = 1; $i <= $quantity; $i++) {
                // Support both `label_1` and `field_1_label` formats
                $label = $shortcode->{"label_{$i}"} ?: $shortcode->{"field_{$i}_label"} ?? '';
                if (!empty($label)) {
                    $formFields[] = [
                        'label' => $label,
                        'placeholder' => $shortcode->{"placeholder_{$i}"} ?: $shortcode->{"field_{$i}_placeholder"} ?? '',
                        'required' => (bool)($shortcode->{"required_{$i}"} ?: $shortcode->{"field_{$i}_required"} ?? false),
                        'fieldName' => 'field_' . $i,
                    ];
                }
            }
        }

        $props = [
            'title' => $shortcode->title ?? 'Thông Tin Cá Nhân',
            'subtitle' => $shortcode->subtitle ?? 'Vui lòng cung cấp thông tin của bạn',
            'formFields' => $formFields,
            'submitButtonText' => $shortcode->submit_button_text ?? 'Lưu Thông Tin',
            'submitButtonUrl' => $shortcode->submit_button_url ?? '',
        ];

        // Ensure needed JS for this shortcode is loaded
        Theme::asset()->container('footer')->usePath()->add('personal-info-form-js', 'js/personal-info-form.js');
        Theme::asset()->container('footer')->usePath()->add('booking-summary-js', 'js/booking-summary.js');

        return Theme::partial('shortcodes.personal-info-form', ['shortcode' => $shortcode, 'props' => $props]);
    });

    Shortcode::setAdminConfig('personal-info-form', function (array $attributes) {
        $form = ShortcodeForm::createFromArray($attributes)
            ->add('title', TextField::class, TextFieldOption::make()->label(__('Title'))->defaultValue('Thông Tin Cá Nhân')->toArray())
            ->add('subtitle', TextareaField::class, TextareaFieldOption::make()->label(__('Subtitle'))->rows(2)->defaultValue('Vui lòng cung cấp thông tin của bạn')->toArray());

        $form->add(
            'tabs',
            ShortcodeTabsField::class,
            ShortcodeTabsFieldOption::make()
                ->label(__('Form Fields'))
                ->fields([
                    'label' => ['title' => __('Label'), 'required' => true],
                    'placeholder' => ['title' => __('Placeholder')],
                    'required' => ['type' => 'onOff', 'title' => __('Required'), 'defaultValue' => false],
                ])
                ->max(5) // Giới hạn tối đa 5 trường
                ->attrs($attributes)
                ->toArray()
        );

        // Submit button at the end
        $form->add('submit_button_text', TextField::class, TextFieldOption::make()->label(__('Submit Button Text'))->defaultValue('Lưu Thông Tin')->toArray())
            ->add('submit_button_url', TextField::class, TextFieldOption::make()->label(__('Submit Button URL (optional)'))->placeholder(__('Leave empty for default form submission'))->toArray());

        return $form;
    });
});

