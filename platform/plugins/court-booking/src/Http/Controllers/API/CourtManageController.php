<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\Api\Http\Controllers\BaseApiController;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\CourtBooking\Models\Court;
use Illuminate\Http\Request;

class CourtManageController extends BaseApiController
{
    /**
     * Create a new court
     * @group Court Management
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'court_type_id' => 'nullable|integer|exists:court_types,id',
            'status_id' => 'nullable|integer|exists:court_statuses,id',
            'location' => 'nullable|string',
            'note' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|in:published,draft',
            'default_price' => 'nullable|numeric|min:0',
            'member_price' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
            'booking_url' => 'nullable|string|max:255',
            'image' => 'nullable|string',
        ]);

        $court = Court::create($data);

        return $this
            ->httpResponse()
            ->setData($court)
            ->setMessage('Court created successfully')
            ->toApiResponse();
    }

    /**
     * Update an existing court
     * @group Court Management
     */
    public function update(Request $request, int $id)
    {
        $court = Court::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'court_type_id' => 'nullable|integer|exists:court_types,id',
            'status_id' => 'nullable|integer|exists:court_statuses,id',
            'location' => 'nullable|string',
            'note' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|in:published,draft',
            'default_price' => 'nullable|numeric|min:0',
            'member_price' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
            'booking_url' => 'nullable|string|max:255',
            'image' => 'nullable|string',
        ]);

        $court->update($data);

        return $this
            ->httpResponse()
            ->setData($court)
            ->setMessage('Court updated successfully')
            ->toApiResponse();
    }

    /**
     * Delete a court
     * @group Court Management
     */
    public function destroy(int $id)
    {
        $court = Court::findOrFail($id);
        $court->delete();

        return $this
            ->httpResponse()
            ->setMessage('Court deleted successfully')
            ->toApiResponse();
    }
}
