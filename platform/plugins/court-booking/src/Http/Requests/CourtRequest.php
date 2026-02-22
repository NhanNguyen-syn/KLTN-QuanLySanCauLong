<?php

namespace Botble\CourtBooking\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;

class CourtRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'court_type_id' => ['required', 'integer', 'exists:court_types,id'],
            'status_id' => ['required', 'integer', 'exists:court_statuses,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'surface' => ['nullable', 'string', 'max:255'],
            'court_size' => ['nullable', 'string', 'max:255'],
            'lighting' => ['nullable', 'string', 'max:255'],
            'air_conditioned' => ['nullable'],
            'features' => ['nullable', 'string'],
            'gallery' => ['nullable'],
            'availability' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:' . implode(',', [
                BaseStatusEnum::PUBLISHED,
                BaseStatusEnum::DRAFT,
                BaseStatusEnum::PENDING,
            ])],
        ];
    }
}

