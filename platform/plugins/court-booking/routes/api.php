<?php

use Illuminate\Support\Facades\Route;
use Botble\CourtBooking\Http\Controllers\API\AvailabilityController;
use Botble\CourtBooking\Http\Controllers\API\BookingController;
use Botble\CourtBooking\Http\Controllers\API\CourtController;
use Botble\CourtBooking\Http\Controllers\API\CourtManageController;
use Botble\CourtBooking\Http\Controllers\API\BookingListController;
use Botble\CourtBooking\Http\Controllers\API\BookingListManageController;
use Botble\CourtBooking\Http\Controllers\API\LookupController;

// Prefix all API endpoints for this plugin with /api/court-booking
Route::middleware('api')->prefix('api')->group(function () {
    Route::prefix('court-booking')->group(function () {
        // Public endpoints
        Route::get('courts', [CourtController::class, 'index']);
        Route::get('time-slots', [\Botble\CourtBooking\Http\Controllers\API\TimeSlotController::class, 'index']);
        Route::get('availability', [AvailabilityController::class, 'index']);

        // Court Management (Admin) - TODO: Add auth middleware
        Route::post('courts', [CourtManageController::class, 'store']);
        Route::put('courts/{id}', [CourtManageController::class, 'update']);
        Route::delete('courts/{id}', [CourtManageController::class, 'destroy']);

        // Lookup by order_code (mã hóa đơn)
        Route::get('lookup', [LookupController::class, 'showByOrderCode']);

        // Booking List Management (Admin) - TODO: Add auth middleware
        Route::put('booking-list/{orderCode}', [BookingListManageController::class, 'update']);
        Route::delete('booking-list/{orderCode}', [BookingListManageController::class, 'destroy']);

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

