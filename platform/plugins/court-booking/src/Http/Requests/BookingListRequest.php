<?php

namespace Botble\CourtBooking\Http\Requests;

use Botble\Support\Http\Requests\Request;

class BookingListRequest extends Request
{
    public function rules(): array
    {
        $statusRule = 'in:pending,processing,paid,completed,cancelled';

        if ($this->boolean('apply_to_order')) {
            return [
                'paid_amount_total' => 'nullable|numeric|min:0',
                'status' => 'nullable|string|' . $statusRule,
                'notes' => 'nullable|string|max:1000',
            ];
        }

        return [
            'status' => 'required|string|' . $statusRule,
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}

