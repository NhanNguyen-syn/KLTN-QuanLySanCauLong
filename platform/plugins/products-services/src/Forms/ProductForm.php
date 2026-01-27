<?php

namespace Botble\ProductsServices\Forms;

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\ProductsServices\Http\Requests\ProductRequest;
use Botble\ProductsServices\Models\Product;
use Botble\ProductsServices\Models\ProductCategory;

class ProductForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Product::class)
            ->setValidatorClass(ProductRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add(
                'category_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label('Danh mục')
                    ->choices(fn () => ProductCategory::query()->where('status', 'published')->pluck('name', 'id')->all())
                    ->searchable()
            )
            ->add('description', TextareaField::class, [
                'label' => 'Mô tả',
                'attr' => ['rows' => 3],
            ])
            ->add('price', NumberField::class, [
                'label' => 'Giá (VNĐ)',
                'attr' => ['min' => 0, 'step' => 1000, 'placeholder' => '150000'],
                'default_value' => 0,
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
