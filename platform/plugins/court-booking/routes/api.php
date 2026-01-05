<?php

use Illuminate\Support\Facades\Route;
use Botble\CourtBooking\Http\Controllers\API\AvailabilityController;
use Botble\CourtBooking\Http\Controllers\API\BookingController;
use Botble\CourtBooking\Http\Controllers\API\CourtController;
use Botble\CourtBooking\Http\Controllers\API\BookingListController;
use Botble\CourtBooking\Http\Controllers\API\LookupController;

// Prefix all API endpoints for this plugin with /api/court-booking
Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('court-booking')->group(function () {
        Route::get('courts', [CourtController::class, 'index']);
        Route::get('availability', [AvailabilityController::class, 'index']);

        // Lookup by order_code (mã hóa đơn)
        Route::get('lookup', [LookupController::class, 'showByOrderCode']);

        Route::prefix('bookings')->group(function () {
            Route::post('hold', [BookingController::class, 'hold']);
            Route::post('{id}/pay', [BookingController::class, 'pay']);
            Route::post('{id}/cancel', [BookingController::class, 'cancel']);
            Route::get('{id}', [BookingController::class, 'show']);
        });

        // Save confirmation info to booking list
        Route::post('booking-list', [BookingListController::class, 'store']);
    });

    // Legacy endpoints kept for backward compatibility (old frontend bundles)
    Route::get('courts', [CourtController::class, 'index']);
    Route::get('availability', [AvailabilityController::class, 'index']);

    // Backward compatibility: allow posting to /api/booking-list too
    Route::post('booking-list', [BookingListController::class, 'store']);
});

