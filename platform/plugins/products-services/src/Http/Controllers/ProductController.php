<?php

namespace Botble\ProductsServices\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\ProductsServices\Forms\ProductForm;
use Botble\ProductsServices\Http\Requests\ProductRequest;
use Botble\ProductsServices\Models\Product;
use Botble\ProductsServices\Tables\ProductTable;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->breadcrumb()->add('Dịch vụ & Sản phẩm', route('product-categories.index'));
        $this->breadcrumb()->add('Sản phẩm', route('products.index'));
    }

    public function index(ProductTable $table)
    {
        $this->pageTitle('Sản phẩm');
        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle('Thêm sản phẩm');
        return ProductForm::create()->renderForm();
    }

    public function store(ProductRequest $request)
    {
        $form = ProductForm::create()->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('products.index'))
            ->setNextUrl(route('products.edit', $form->getModel()->getKey()))
            ->withCreatedSuccessMessage();
    }

    public function edit(Product $product)
    {
        $this->pageTitle('Sửa sản phẩm: ' . $product->name);
        return ProductForm::createFromModel($product)->renderForm();
    }

    public function update(Product $product, ProductRequest $request)
    {
        ProductForm::createFromModel($product)->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('products.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Product $product)
    {
        return DeleteResourceAction::make($product);
    }
}
