<?php

use Illuminate\Support\Facades\Route;

// Serve Customer SPA build
Route::get('/frontend/customer/{any?}', function () {
    $index = public_path('frontend/customer/index.html');
    abort_unless(file_exists($index), 404);
    return response()->file($index);
})->where('any', '.*');

// Serve Admin SPA build
Route::get('/frontend/admin/{any?}', function () {
    $index = public_path('frontend/admin/index.html');
    abort_unless(file_exists($index), 404);
    return response()->file($index);
})->where('any', '.*');
