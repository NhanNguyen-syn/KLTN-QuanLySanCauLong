<?php

namespace Botble\ProductsServices\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\ProductsServices\Forms\ProductCategoryForm;
use Botble\ProductsServices\Http\Requests\ProductCategoryRequest;
use Botble\ProductsServices\Models\ProductCategory;
use Botble\ProductsServices\Tables\ProductCategoryTable;
use Illuminate\Support\Str;

class ProductCategoryController extends BaseController
{
    public function __construct()
    {
        $this->breadcrumb()->add('Dịch vụ & Sản phẩm', route('product-categories.index'));
    }

    public function index(ProductCategoryTable $table)
    {
        $this->pageTitle('Danh mục sản phẩm');
        try {
            return $table->renderTable();
        } catch (\Throwable $e) {
            \Log::error('ProductCategoryTable Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            throw $e;
        }
    }

    public function create()
    {
        $this->pageTitle('Thêm danh mục');
        return ProductCategoryForm::create()->renderForm();
    }

    public function store(ProductCategoryRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $form = ProductCategoryForm::create()->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('product-categories.index'))
            ->setNextUrl(route('product-categories.edit', $form->getModel()->getKey()))
            ->withCreatedSuccessMessage();
    }

    public function edit(ProductCategory $productCategory)
    {
        $this->pageTitle('Sửa danh mục: ' . $productCategory->name);
        return ProductCategoryForm::createFromModel($productCategory)->renderForm();
    }

    public function update(ProductCategory $productCategory, ProductCategoryRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        ProductCategoryForm::createFromModel($productCategory)->setRequest($request)->save();

        return $this->httpResponse()
            ->setPreviousUrl(route('product-categories.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(ProductCategory $productCategory)
    {
        return DeleteResourceAction::make($productCategory);
    }
}
