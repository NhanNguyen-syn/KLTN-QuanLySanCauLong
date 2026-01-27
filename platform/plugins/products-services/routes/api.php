<?php

use Botble\ProductsServices\Models\Product;
use Botble\ProductsServices\Models\ProductCategory;
use Botble\ProductsServices\Models\Service as BaseService;
use Botble\Media\Facades\RvMedia;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/products-services'], function () {
    // Get all published categories
    Route::get('categories', function () {
        $categories = ProductCategory::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->get(['id', 'name', 'slug', 'icon']);
        
        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    })->name('api.product-categories.index');

    // Get all published products
    Route::get('products', function () {
        $categoryId = request('category_id');
        
        $query = Product::query()
            ->with('category:id,name,slug')
            ->where('status', 'published')
            ->orderBy('order');
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        $products = $query->get(['id', 'name', 'category_id', 'description', 'price', 'image']);
        
        // Transform to include full image URL
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'description' => $product->description,
                'price' => $product->price,
                'image' => $product->image ? RvMedia::getImageUrl($product->image) : null,
                'category' => $product->category,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    })->name('api.products.index');

    // Get all published services
    Route::get('services', function () {
        $services = BaseService::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->get(['id', 'name', 'description', 'price', 'image', 'content']);
        
        // Transform to include full image URL
        $services = $services->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description,
                'content' => $service->content,
                'price' => $service->price,
                'image' => $service->image ? RvMedia::getImageUrl($service->image) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    })->name('api.services.index');
});
