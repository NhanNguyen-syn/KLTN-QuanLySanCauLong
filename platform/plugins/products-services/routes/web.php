<?php

use Botble\Base\Facades\AdminHelper;
use Botble\ProductsServices\Http\Controllers\ProductCategoryController;
use Botble\ProductsServices\Http\Controllers\ProductController;
use Botble\ProductsServices\Http\Controllers\ServiceController;

use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'product-categories', 'as' => 'product-categories.'], function () {
        Route::resource('', ProductCategoryController::class)->parameters(['' => 'productCategory']);
    });

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::resource('', ProductController::class)->parameters(['' => 'product']);
    });

    Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
        Route::resource('', ServiceController::class)->parameters(['' => 'service']);
    });
});
