<?php

namespace Botble\CourtBooking\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Models\CourtSlot;
use Botble\CourtBooking\Tables\CourtSlotTable;
use Illuminate\Http\Request;

class CourtSlotController extends BaseController
{
    public function index(CourtSlotTable $table)
    {
        $this->pageTitle(trans('plugins/court-booking::court-slot.name'));
        return $table->renderTable();
    }

    public function edit(int $id)
    {
        $courtSlot = CourtSlot::with(['court', 'bookingItems.booking.user'])->findOrFail($id);
        $this->pageTitle(trans('plugins/court-booking::court-slot.edit', ['name' => $courtSlot->court->name]));

        return view('plugins/court-booking::slots.edit', compact('courtSlot'));
    }

    public function update(int $id, Request $request)
    {
        $courtSlot = CourtSlot::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:available,reserved,booked,blocked'],
            'notes' => ['nullable', 'string'],
        ]);

        $courtSlot->status = $request->input('status');
        $courtSlot->save();

        $booking = $courtSlot->getBooking();
        if ($booking && $request->has('notes')) {
            $booking->notes = $request->input('notes');
            $booking->save();
        }

        return $this
            ->httpResponse()
            ->setNextUrl(route('court-slot.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }


    public function destroy(int $id)
    {
        $courtSlot = CourtSlot::findOrFail($id);
        $courtSlot->delete();

        return $this->httpResponse()->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids' => ['required','array'],
            'status' => ['required','in:available,reserved,booked,blocked'],
        ]);

        CourtSlot::whereIn('id', $request->integer('ids'))
            ->update(['status' => $request->string('status')]);

        return $this->httpResponse()->setMessage(trans('core/base::notices.update_success_message'));
    }
}

