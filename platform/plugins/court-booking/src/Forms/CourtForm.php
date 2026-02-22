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
use Botble\Base\Forms\Fields\OnOffField;
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
            ->add('slug', TextField::class, [
                'label' => 'Slug (URL)',
                'attr' => ['placeholder' => 'Tự động tạo từ tên nếu để trống'],
                'help' => 'Slug dùng cho URL trang chi tiết sân. Để trống sẽ tự động tạo từ tên.',
            ])
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
            ->add('address', TextField::class, [
                'label' => 'Địa chỉ',
                'attr' => ['placeholder' => '123 Đường Badminton, Quận Cầu Giấy, Hà Nội'],
            ])
            ->add('description', TextareaField::class, [
                'label' => 'Mô tả chi tiết',
                'attr' => [
                    'placeholder' => 'Mô tả chi tiết về sân cầu lông...',
                    'rows' => 4,
                ],
            ])
            ->add('surface', TextField::class, [
                'label' => 'Mặt sân',
                'attr' => ['placeholder' => 'Sàn gỗ cao cấp nhập khẩu châu Âu'],
            ])
            ->add('court_size', TextField::class, [
                'label' => 'Kích thước sân',
                'attr' => ['placeholder' => '13.4m x 6.1m (Chuẩn BWF)'],
            ])
            ->add('lighting', TextField::class, [
                'label' => 'Hệ thống chiếu sáng',
                'attr' => ['placeholder' => 'Hệ thống LED 500 lux'],
            ])
            ->add('air_conditioned', OnOffField::class, [
                'label' => 'Có điều hòa',
                'default_value' => false,
            ])
            ->add('features', TextareaField::class, [
                'label' => 'Tính năng đặc biệt',
                'attr' => [
                    'placeholder' => "Mỗi tính năng một dòng, ví dụ:\nSàn gỗ cao cấp nhập khẩu châu Âu\nHệ thống LED 500 lux chuyên nghiệp\nĐiều hòa nhiệt độ 24-26°C",
                    'rows' => 5,
                ],
                'help' => 'Mỗi tính năng nhập trên một dòng riêng.',
                'value' => $this->getModel()->features ? implode("\n", (array) $this->getModel()->features) : '',
            ])
            ->add('gallery', 'mediaImages', [
                'label' => 'Thư viện ảnh',
                'help' => 'Chọn nhiều ảnh để hiển thị gallery trên trang chi tiết sân.',
                'values' => $this->getModel()->gallery ?? [],
            ])
            ->add('availability', TextField::class, [
                'label' => 'Giờ hoạt động',
                'attr' => ['placeholder' => '5:00 - 23:00 hàng ngày'],
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
            ->add('note', TextareaField::class)
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

