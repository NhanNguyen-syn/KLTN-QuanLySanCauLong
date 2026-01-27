<?php

namespace Botble\ProductsServices\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(BaseStatusEnum::values())],
        ];
    }
}
