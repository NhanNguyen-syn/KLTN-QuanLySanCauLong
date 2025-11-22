<?php

namespace Botble\CourtBooking\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\CourtBooking\Http\Requests\CourtBookingRequest;
use Botble\CourtBooking\Models\CourtBooking;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Tables\CourtBookingTable;
use Botble\CourtBooking\Forms\CourtBookingForm;

class CourtBookingController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/court-booking::court-booking.name'), route('court-booking.index'));
    }

    public function index(CourtBookingTable $table)
    {
        $this->pageTitle(trans('plugins/court-booking::court-booking.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/court-booking::court-booking.create'));

        return CourtBookingForm::create()->renderForm();
    }

    public function store(CourtBookingRequest $request)
    {
        $form = CourtBookingForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('court-booking.index'))
            ->setNextUrl(route('court-booking.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(CourtBooking $courtBooking)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $courtBooking->name]));

        return CourtBookingForm::createFromModel($courtBooking)->renderForm();
    }

    public function update(CourtBooking $courtBooking, CourtBookingRequest $request)
    {
        CourtBookingForm::createFromModel($courtBooking)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('court-booking.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(CourtBooking $courtBooking)
    {
        return DeleteResourceAction::make($courtBooking);
    }
}
