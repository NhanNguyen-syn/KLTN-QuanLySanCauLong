<?php

namespace Botble\CourtBooking\Http\Requests;

use Botble\Support\Http\Requests\Request;
use Botble\CourtBooking\Models\Service;
use Illuminate\Validation\Rule;

class ServiceRequest extends Request
{
    public function rules(): array
    {
        $serviceId = $this->route('service') ? $this->route('service')->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($serviceId),
            ],
            'description' => ['nullable', 'string'],
            'type' => ['required', Rule::in(array_keys(Service::getTypeOptions()))],
            'category' => ['required', Rule::in(array_keys(Service::getCategoryOptions()))],
            'price' => ['required', 'numeric', 'min:0'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'track_stock' => ['nullable', 'boolean'],
            'unit' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên',
            'slug' => 'Slug',
            'description' => 'Mô tả',
            'type' => 'Loại',
            'category' => 'Danh mục',
            'price' => 'Giá bán',
            'cost' => 'Giá vốn',
            'stock' => 'Tồn kho',
            'track_stock' => 'Theo dõi tồn kho',
            'unit' => 'Đơn vị',
            'image' => 'Hình ảnh',
            'is_active' => 'Kích hoạt',
            'sort_order' => 'Thứ tự',
        ];
    }
}
