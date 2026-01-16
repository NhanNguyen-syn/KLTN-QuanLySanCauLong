<?php

use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class SiteInfoWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Site information'),
            'description' => __('Widget display site information'),
            'logo' => null,
            'logo_height' => 35,
            'about' => null,
            'show_social_links' => true,
            'social_link_1_icon' => null,
            'social_link_1_url' => null,
            'social_link_2_icon' => null,
            'social_link_2_url' => null,
            'social_link_3_icon' => null,
            'social_link_3_url' => null,
            'social_link_4_icon' => null,
            'social_link_4_url' => null,
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'logo',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Logo'))
                    ->defaultValue(theme_option('logo'))
                    ->helperText(__('Leave empty to use the default logo in Theme Options.'))
                    ->toArray()
            )
            ->add(
                'logo_height',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(__('Logo height (default: 35px)'))
                    ->defaultValue(35)
                    ->toArray()
            )
            ->add(
                'about',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('About'))
                    ->toArray()
            )
            ->add(
                'show_social_links',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(__('Show custom social links'))
                    ->helperText(__('Use custom social links below instead of theme options social links'))
                    ->toArray()
            )
            ->add(
                'social_link_1_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Social Link 1 - Icon'))
                    ->helperText(__('Upload icon image for first social link'))
                    ->toArray()
            )
            ->add(
                'social_link_1_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Social Link 1 - URL'))
                    ->placeholder('https://facebook.com/...')
                    ->toArray()
            )
            ->add(
                'social_link_2_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Social Link 2 - Icon'))
                    ->toArray()
            )
            ->add(
                'social_link_2_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Social Link 2 - URL'))
                    ->placeholder('https://instagram.com/...')
                    ->toArray()
            )
            ->add(
                'social_link_3_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Social Link 3 - Icon'))
                    ->toArray()
            )
            ->add(
                'social_link_3_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Social Link 3 - URL'))
                    ->placeholder('https://youtube.com/...')
                    ->toArray()
            )
            ->add(
                'social_link_4_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Social Link 4 - Icon'))
                    ->toArray()
            )
            ->add(
                'social_link_4_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Social Link 4 - URL'))
                    ->placeholder('https://twitter.com/...')
                    ->toArray()
            );
    }

    public function data(): array
    {
        $height = $this->getConfig('logo_height') ?: theme_option('logo_height', 35);

        $attributes = [
            'style' => sprintf('height: %s', is_numeric($height) ? "{$height}px" : $height),
            'loading' => false,
        ];

        return compact('attributes');
    }
}
