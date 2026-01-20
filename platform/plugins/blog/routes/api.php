<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Botble\Blog\Http\Controllers\API',
], function (): void {
    // Public endpoints
    Route::get('search', 'PostController@getSearch');
    Route::get('posts', 'PostController@index');
    Route::get('categories', 'CategoryController@index');
    Route::get('tags', 'TagController@index');

    Route::get('posts/filters', 'PostController@getFilters');
    Route::get('posts/{slug}', 'PostController@findBySlug');
    Route::get('categories/filters', 'CategoryController@getFilters');
    Route::get('categories/{slug}', 'CategoryController@findBySlug');

    // Admin endpoints - TODO: Add auth middleware
    // Posts Management
    Route::post('posts', 'BlogManageController@storePost');
    Route::put('posts/{id}', 'BlogManageController@updatePost');
    Route::delete('posts/{id}', 'BlogManageController@destroyPost');

    // Categories Management
    Route::post('categories', 'BlogManageController@storeCategory');
    Route::put('categories/{id}', 'BlogManageController@updateCategory');
    Route::delete('categories/{id}', 'BlogManageController@destroyCategory');

    // Tags Management
    Route::post('tags', 'BlogManageController@storeTag');
    Route::put('tags/{id}', 'BlogManageController@updateTag');
    Route::delete('tags/{id}', 'BlogManageController@destroyTag');
});
