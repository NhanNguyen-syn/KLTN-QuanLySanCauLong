<?php

namespace Botble\CourtBooking\Http\Controllers\API;

use Botble\Api\Http\Controllers\BaseApiController;
use Botble\CourtBooking\Models\BookingList;
use Illuminate\Http\Request;

class BookingListManageController extends BaseApiController
{
    /**
     * Update booking list (Admin)
     * Update status, paid_amount, notes for an order
     * @group Booking Management
     */
    public function update(Request $request, string $orderCode)
    {
        $data = $request->validate([
            'status' => 'nullable|in:pending,processing,paid,completed,cancelled',
            'paid_amount_total' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'apply_to_order' => 'nullable|boolean',
        ]);

        $items = BookingList::query()
            ->where('order_code', $orderCode)
            ->get();

        if ($items->isEmpty()) {
            return $this
                ->httpResponse()
                ->setError()
                ->setCode(404)
                ->setMessage('Order not found');
        }

        // Update status for all items in the order
        if ($request->filled('status')) {
            BookingList::query()
                ->where('order_code', $orderCode)
                ->update(['status' => $data['status']]);
        }

        // Update notes for all items in the order
        if ($request->filled('notes')) {
            BookingList::query()
                ->where('order_code', $orderCode)
                ->update(['notes' => $data['notes']]);
        }

        // Allocate paid amount proportionally
        if ($request->filled('paid_amount_total')) {
            $totalPaid = (float) $data['paid_amount_total'];
            $totalPrice = (float) $items->sum('price');
            $allocatedSoFar = 0;

            foreach ($items as $idx => $item) {
                $alloc = $totalPrice > 0 ? round($totalPaid * ($item->price / $totalPrice), 2) : 0;
                // Adjust for rounding on last item
                if ($idx === ($items->count() - 1)) {
                    $alloc = max(0, $totalPaid - $allocatedSoFar);
                }
                $allocatedSoFar += $alloc;

                $item->paid_amount = $alloc;
                $item->save();
            }
        }

        // Reload fresh data
        $updatedItems = BookingList::query()
            ->where('order_code', $orderCode)
            ->get();

        return $this
            ->httpResponse()
            ->setData($updatedItems)
            ->setMessage('Order updated successfully')
            ->toApiResponse();
    }

    /**
     * Delete entire order (Admin)
     * @group Booking Management
     */
    public function destroy(string $orderCode)
    {
        $deleted = BookingList::query()
            ->where('order_code', $orderCode)
            ->delete();

        if (!$deleted) {
            return $this
                ->httpResponse()
                ->setError()
                ->setCode(404)
                ->setMessage('Order not found');
        }

        return $this
            ->httpResponse()
            ->setMessage('Order deleted successfully')
            ->toApiResponse();
    }
}
