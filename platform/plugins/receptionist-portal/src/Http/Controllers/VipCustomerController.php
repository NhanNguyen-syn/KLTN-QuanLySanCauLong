<?php

namespace Botble\ReceptionistPortal\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\ReceptionistPortal\Models\VipCustomer;
use Botble\ReceptionistPortal\Forms\VipCustomerForm;
use Botble\ReceptionistPortal\Tables\VipCustomerTable;
use Illuminate\Http\Request;

class VipCustomerController extends BaseController
{
    /**
     * Display VIP customer list
     */
    public function index(VipCustomerTable $table)
    {
        $this->pageTitle('Khách hàng VIP');

        return $table->renderTable();
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->pageTitle('Thêm khách VIP');

        return VipCustomerForm::create()->renderForm();
    }

    /**
     * Store new VIP customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:vip_customers,phone',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:member,vip,gold,platinum',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $customer = VipCustomer::create([
            ...$request->only(['name', 'phone', 'email', 'type', 'discount_percent', 'credit_limit', 'notes']),
            'member_since' => now(),
            'is_active' => true,
        ]);

        return $this
            ->httpResponse()
            ->setPreviousRoute('receptionist.vip.index')
            ->setNextRoute('receptionist.vip.edit', $customer->id)
            ->withCreatedSuccessMessage();
    }

    /**
     * Show edit form
     */
    public function edit(VipCustomer $vipCustomer)
    {
        $this->pageTitle('Sửa: ' . $vipCustomer->name);

        return VipCustomerForm::createFromModel($vipCustomer)->renderForm();
    }

    /**
     * Update VIP customer
     */
    public function update(Request $request, VipCustomer $vipCustomer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:vip_customers,phone,' . $vipCustomer->id,
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:member,vip,gold,platinum',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);

        $vipCustomer->update($request->only([
            'name',
            'phone',
            'email',
            'type',
            'discount_percent',
            'credit_limit',
            'notes',
            'is_active',
            'valid_until'
        ]));

        return $this
            ->httpResponse()
            ->setPreviousRoute('receptionist.vip.index')
            ->withUpdatedSuccessMessage();
    }

    /**
     * Delete VIP customer
     */
    public function destroy(VipCustomer $vipCustomer)
    {
        return DeleteResourceAction::make($vipCustomer);
    }
}
