<?php

use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\EmailField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class SiteContactWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Site Contact'),
            'description' => __('Display site contact information.'),
            'address' => null,
            'address_icon' => null,
            'phone' => null,
            'phone_icon' => null,
            'email' => null,
            'email_icon' => null,
            'operating_time' => null,
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'name',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Name'))
                    ->toArray()
            )
            ->add(
                'address',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Address'))
                    ->placeholder(__('123 Đường Badminton, Quận Cầu Giấy, Hà Nội'))
                    ->toArray()
            )
            ->add(
                'address_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Address Icon'))
                    ->helperText(__('Upload custom icon for address (optional, defaults to map-pin)'))
                    ->toArray()
            )
            ->add(
                'phone',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Phone number'))
                    ->placeholder('1800 123 456')
                    ->toArray()
            )
            ->add(
                'phone_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Phone Icon'))
                    ->helperText(__('Upload custom icon for phone (optional, defaults to phone)'))
                    ->toArray()
            )
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()
                    ->label(__('Email address'))
                    ->placeholder('info@badmintonpro.vn')
                    ->toArray()
            )
            ->add(
                'email_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Email Icon'))
                    ->helperText(__('Upload custom icon for email (optional, defaults to mail)'))
                    ->toArray()
            )
            ->add(
                'operating_time',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Operating time'))
                    ->placeholder(__('06:00 - 22:00 (Daily)'))
                    ->toArray()
            );
    }
}
