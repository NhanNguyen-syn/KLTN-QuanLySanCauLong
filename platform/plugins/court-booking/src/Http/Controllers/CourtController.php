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
        // Check if user is trying to change price without permission
        if (!$this->checkPriceEditPermission($court, $request)) {
            return $this->httpResponse()
                ->setError()
                ->setMessage('Bạn không có quyền chỉnh giá sân. Chỉ Admin mới được phép.');
        }

        CourtForm::createFromModel($court)->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('courts.index'))
            ->withUpdatedSuccessMessage();
    }

    /**
     * Check if user has permission to edit price
     */
    private function checkPriceEditPermission(Court $court, CourtRequest $request): bool
    {
        // Get price fields from request
        $oldDefaultPrice = $court->default_price;
        $oldMemberPrice = $court->member_price;
        $newDefaultPrice = $request->input('default_price');
        $newMemberPrice = $request->input('member_price');

        // If prices haven't changed, allow update
        if ($oldDefaultPrice == $newDefaultPrice && $oldMemberPrice == $newMemberPrice) {
            return true;
        }

        // If prices changed, check permission
        return auth()->user()->hasPermission('courts.edit-price');
    }

    public function destroy(Court $court)
    {
        return DeleteResourceAction::make($court);
    }
}

