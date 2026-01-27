<?php

namespace Botble\ProductsServices\Forms;

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\ProductsServices\Http\Requests\ServiceRequest;
use Botble\ProductsServices\Models\Service;

class ServiceForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Service::class)
            ->setValidatorClass(ServiceRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('description', TextareaField::class, [
                'label' => 'Mô tả ngắn',
                'attr' => ['rows' => 3],
            ])
            ->add('content', EditorField::class, [
                'label' => 'Chi tiết dịch vụ',
            ])
            ->add('price', TextField::class, [
                'label' => 'Giá hiển thị',
                'attr' => ['placeholder' => 'VD: 15.000đ/bộ hoặc 50.000đ - 200.000đ'],
            ])
            ->add('order', NumberField::class, [
                'label' => 'Thứ tự',
                'attr' => ['min' => 0],
                'default_value' => 0,
            ])
            ->add('image', MediaImageField::class, MediaImageFieldOption::make())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('image');
    }
}
