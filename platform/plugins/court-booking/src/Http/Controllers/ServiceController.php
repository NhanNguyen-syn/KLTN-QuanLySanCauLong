<?php

namespace Botble\CourtBooking\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\CourtBooking\Models\Service;
use Botble\CourtBooking\Forms\ServiceForm;
use Botble\CourtBooking\Tables\ServiceTable;
use Botble\CourtBooking\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * Display service list
     */
    public function index(ServiceTable $table)
    {
        $this->pageTitle('Dịch vụ & Sản phẩm');

        return $table->renderTable();
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->pageTitle('Thêm dịch vụ/sản phẩm');

        return ServiceForm::create()->renderForm();
    }

    /**
     * Store new service
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return $this
            ->httpResponse()
            ->setPreviousRoute('services.index')
            ->setNextRoute('services.edit', $service->id)
            ->withCreatedSuccessMessage();
    }

    /**
     * Show edit form
     */
    public function edit(Service $service)
    {
        $this->pageTitle('Sửa: ' . $service->name);

        return ServiceForm::createFromModel($service)->renderForm();
    }

    /**
     * Update service
     */
    public function update(ServiceRequest $request, Service $service)
    {
        // Check if user is trying to change price without permission
        if (!$this->checkPriceEditPermission($service, $request)) {
            return $this->httpResponse()
                ->setError()
                ->setMessage('Bạn không có quyền chỉnh giá dịch vụ. Chỉ Admin mới được phép.');
        }

        $service->update($request->validated());

        return $this
            ->httpResponse()
            ->setPreviousRoute('services.index')
            ->withUpdatedSuccessMessage();
    }

    /**
     * Check if user has permission to edit price
     */
    private function checkPriceEditPermission(Service $service, ServiceRequest $request): bool
    {
        // Get price field from request
        $oldPrice = $service->price;
        $newPrice = $request->input('price');

        // If price hasn't changed, allow update
        if ($oldPrice == $newPrice) {
            return true;
        }

        // If price changed, check permission
        return auth()->user()->hasPermission('services.edit-price');
    }

    /**
     * Delete service
     */
    public function destroy(Service $service)
    {
        return DeleteResourceAction::make($service);
    }

    /**
     * API: Get all active services (for frontend use)
     */
    public function getActiveServices(Request $request)
    {
        $query = Service::active()->orderBy('sort_order');

        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        $services = $query->get(['id', 'name', 'price', 'category', 'type', 'unit', 'image', 'stock', 'track_stock']);

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }
}
