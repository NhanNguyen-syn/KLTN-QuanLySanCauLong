<?php

use Botble\Base\Facades\AdminHelper;
use Botble\CourtBooking\Http\Controllers\CourtBookingController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'court-bookings', 'as' => 'court-booking.'], function () {
        Route::resource('', CourtBookingController::class)->parameters(['' => 'court-booking']);
    });

    // Court Slots management
    Route::group(['prefix' => 'court-slots', 'as' => 'court-slot.'], function () {
        Route::get('', [\Botble\CourtBooking\Http\Controllers\CourtSlotController::class, 'index'])->name('index');
        Route::post('', [\Botble\CourtBooking\Http\Controllers\CourtSlotController::class, 'index'])->name('index.post');
        Route::get('{id}/edit', [\Botble\CourtBooking\Http\Controllers\CourtSlotController::class, 'edit'])->name('edit');
        Route::put('{id}', [\Botble\CourtBooking\Http\Controllers\CourtSlotController::class, 'update'])->name('update');
        Route::delete('{id}', [\Botble\CourtBooking\Http\Controllers\CourtSlotController::class, 'destroy'])->name('destroy');
        Route::post('bulk-status', [\Botble\CourtBooking\Http\Controllers\CourtSlotController::class, 'bulkStatus'])->name('bulk-status');
    });
});
