<?php

namespace Botble\ProductsServices\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\ProductsServices\Forms\ServiceForm;
use Botble\ProductsServices\Http\Requests\ServiceRequest;
use Botble\ProductsServices\Models\Service;
use Botble\ProductsServices\Tables\ServiceTable;

class ServiceController extends BaseController
{
    public function __construct()
    {
        $this->breadcrumb()->add('Dịch vụ & Sản phẩm', route('product-categories.index'));
        $this->breadcrumb()->add('Dịch vụ', route('services.index'));
    }

    public function index(ServiceTable $table)
    {
        $this->pageTitle('Dịch vụ');
        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle('Thêm dịch vụ');
        return ServiceForm::create()->renderForm();
    }

    public function store(ServiceRequest $request)
    {
        $form = ServiceForm::create()->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('services.index'))
            ->setNextUrl(route('services.edit', $form->getModel()->getKey()))
            ->withCreatedSuccessMessage();
    }

    public function edit(Service $service)
    {
        $this->pageTitle('Sửa dịch vụ: ' . $service->name);
        return ServiceForm::createFromModel($service)->renderForm();
    }

    public function update(Service $service, ServiceRequest $request)
    {
        ServiceForm::createFromModel($service)->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('services.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Service $service)
    {
        return DeleteResourceAction::make($service);
    }
}
