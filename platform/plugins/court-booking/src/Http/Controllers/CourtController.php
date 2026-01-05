<?php

namespace Botble\CourtBooking\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\CourtBooking\Forms\CourtForm;
use Botble\CourtBooking\Http\Requests\CourtRequest;
use Botble\CourtBooking\Models\Court;
use Botble\CourtBooking\Tables\CourtTable;

class CourtController extends BaseController
{
    public function __construct()
    {
        $this->breadcrumb()->add('Quản lý Sân', route('courts.index'));
    }

    public function index(CourtTable $table)
    {
        $this->pageTitle('Sân');
        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle('Thêm sân');
        return CourtForm::create()->renderForm();
    }

    public function store(CourtRequest $request)
    {
        $form = CourtForm::create()->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('courts.index'))
            ->setNextUrl(route('courts.edit', $form->getModel()->getKey()))
            ->withCreatedSuccessMessage();
    }

    public function edit(Court $court)
    {
        $this->pageTitle('Sửa sân: ' . $court->name);
        return CourtForm::createFromModel($court)->renderForm();
    }

    public function update(Court $court, CourtRequest $request)
    {
        CourtForm::createFromModel($court)->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('courts.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Court $court)
    {
        return DeleteResourceAction::make($court);
    }
}

