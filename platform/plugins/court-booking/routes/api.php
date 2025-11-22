<?php

use Illuminate\Support\Facades\Route;
use Botble\CourtBooking\Http\Controllers\API\AvailabilityController;
use Botble\CourtBooking\Http\Controllers\API\BookingController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::get('/availability', [AvailabilityController::class, 'index']);

    Route::prefix('bookings')->group(function () {
        Route::post('/hold', [BookingController::class, 'hold']);
        Route::post('/{id}/pay', [BookingController::class, 'pay']);
        Route::post('/{id}/cancel', [BookingController::class, 'cancel']);
        Route::get('/{id}', [BookingController::class, 'show']);
    });
});

