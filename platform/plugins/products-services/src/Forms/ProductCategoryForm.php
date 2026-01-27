<?php

namespace Botble\ProductsServices\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\ProductsServices\Http\Requests\ProductCategoryRequest;
use Botble\ProductsServices\Models\ProductCategory;

class ProductCategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProductCategory::class)
            ->setValidatorClass(ProductCategoryRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('slug', TextField::class, TextFieldOption::make()
                ->label('Slug')
                ->placeholder('Tự động tạo nếu để trống')
            )
            ->add('description', TextareaField::class, [
                'label' => 'Mô tả',
                'attr' => ['rows' => 3],
            ])
            ->add('icon', TextField::class, [
                'label' => 'Icon',
                'attr' => ['placeholder' => 'Ví dụ: 🏸 hoặc class icon'],
            ])
            ->add('order', NumberField::class, [
                'label' => 'Thứ tự',
                'attr' => ['min' => 0],
                'default_value' => 0,
            ])
            ->add('status', SelectField::class, StatusFieldOption::make());
    }
}
