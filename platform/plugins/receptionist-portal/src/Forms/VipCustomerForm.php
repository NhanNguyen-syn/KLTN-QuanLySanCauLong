<?php

namespace Botble\ReceptionistPortal\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\ReceptionistPortal\Models\VipCustomer;

class VipCustomerForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(VipCustomer::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('phone', TextField::class, [
                'label' => 'Số điện thoại',
                'required' => true,
                'attr' => [
                    'placeholder' => '0901234567',
                ],
            ])
            ->add('email', TextField::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'email@example.com',
                ],
            ])
            ->add('type', SelectField::class, SelectFieldOption::make()
                ->label('Loại thành viên')
                ->choices(VipCustomer::getTypeOptions())
                ->required()
                ->toArray())
            ->add('discount_percent', NumberField::class, NumberFieldOption::make()
                ->label('Giảm giá (%)')
                ->defaultValue(0)
                ->toArray())
            ->add('credit_limit', NumberField::class, NumberFieldOption::make()
                ->label('Hạn mức công nợ (VNĐ)')
                ->defaultValue(0)
                ->toArray())
            ->add('current_debt', NumberField::class, [
                'label' => 'Công nợ hiện tại (VNĐ)',
                'attr' => ['readonly' => true],
                'default_value' => 0,
            ])
            ->add('valid_until', 'date', [
                'label' => 'Hiệu lực đến',
            ])
            ->add('notes', TextareaField::class, [
                'label' => 'Ghi chú',
                'attr' => ['rows' => 3],
            ])
            ->add('is_active', OnOffField::class, OnOffFieldOption::make()
                ->label('Kích hoạt')
                ->defaultValue(true)
                ->toArray())
            ->setBreakFieldPoint('is_active');
    }
}
