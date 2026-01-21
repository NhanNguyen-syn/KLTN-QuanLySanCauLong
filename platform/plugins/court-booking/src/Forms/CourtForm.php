<?php

namespace Botble\CourtBooking\Forms;

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
use Botble\CourtBooking\Http\Requests\CourtRequest;
use Botble\CourtBooking\Models\Court;
use Botble\CourtBooking\Models\CourtStatus;
use Botble\CourtBooking\Models\CourtType;

class CourtForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Court::class)
            ->setValidatorClass(CourtRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add(
                'court_type_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label('Loại sân')
                    ->choices(fn () => CourtType::query()->pluck('name', 'id')->all())
                    ->searchable()
                    ->required()
            )
            ->add(
                'status_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label('Trạng thái sân')
                    ->choices(fn () => CourtStatus::query()->pluck('name', 'id')->all())
                    ->searchable()
                    ->required()
            )
            ->add('location', TextField::class, [
                'label' => 'Vị trí',
                'attr' => ['placeholder' => 'Khu A, tầng 2...'],
            ])
            ->add('note', TextareaField::class)
            ->add('address', TextField::class, [
                'label' => 'Địa chỉ',
                'attr' => ['placeholder' => '123 Đường Badminton, Quận Cầu Giấy, Hà Nội'],
            ])
            ->add('default_price', NumberField::class, [
                'label' => 'Giá bắt đầu từ (đ/giờ)',
                'attr' => ['min' => 0, 'step' => 1000, 'placeholder' => '150000'],
                'default_value' => 150000,
            ])
            ->add('time_display', TextField::class, [
                'label' => 'Giờ hiển thị',
                'attr' => ['placeholder' => '08:00-09:00, 12:00-13:00'],
                'help' => 'Nhập các khung giờ cách nhau bởi dấu phẩy (ví dụ: 08:00-09:00, 12:00-13:00)',
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

