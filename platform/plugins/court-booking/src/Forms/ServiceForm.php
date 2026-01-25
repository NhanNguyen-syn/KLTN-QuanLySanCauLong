<?php

namespace Botble\CourtBooking\Forms;

use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\CourtBooking\Models\Service;
use Illuminate\Support\Str;

class ServiceForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Service::class)
            ->setValidatorClass(\Botble\CourtBooking\Http\Requests\ServiceRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('slug', TextField::class, [
                'label' => 'Slug URL',
                'attr' => [
                    'placeholder' => 'Tự động tạo từ tên',
                    'data-counter' => 255,
                ],
            ])
            ->add('type', SelectField::class, SelectFieldOption::make()
                ->label('Loại')
                ->choices(Service::getTypeOptions())
                ->required()
                ->toArray())
            ->add('category', SelectField::class, SelectFieldOption::make()
                ->label('Danh mục')
                ->choices(Service::getCategoryOptions())
                ->required()
                ->toArray())
            ->add('price', NumberField::class, NumberFieldOption::make()
                ->label('Giá bán (VNĐ)')
                ->required()
                ->toArray())
            ->add('cost', NumberField::class, NumberFieldOption::make()
                ->label('Giá vốn (VNĐ)')
                ->toArray())
            ->add('unit', TextField::class, [
                'label' => 'Đơn vị',
                'default_value' => 'cái',
                'attr' => [
                    'placeholder' => 'cái, chai, lon, giờ...',
                ],
            ])
            ->add('track_stock', OnOffField::class, OnOffFieldOption::make()
                ->label('Theo dõi tồn kho')
                ->toArray())
            ->add('stock', NumberField::class, NumberFieldOption::make()
                ->label('Số lượng tồn kho')
                ->toArray())
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()
                ->label('Hình ảnh')
                ->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('is_active', OnOffField::class, OnOffFieldOption::make()
                ->label('Kích hoạt')
                ->defaultValue(true)
                ->toArray())
            ->add('sort_order', NumberField::class, NumberFieldOption::make()
                ->label('Thứ tự sắp xếp')
                ->defaultValue(0)
                ->toArray())
            ->setBreakFieldPoint('is_active');
    }
}
