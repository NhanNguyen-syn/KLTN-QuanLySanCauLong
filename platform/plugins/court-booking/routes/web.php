<?php

use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    // Courts CRUD
    Route::group(['prefix' => 'courts', 'as' => 'courts.'], function () {
        Route::resource('', \Botble\CourtBooking\Http\Controllers\CourtController::class)->parameters(['' => 'court']);
    });


    // Booking List management
    Route::group(['prefix' => 'booking-lists', 'as' => 'booking-list.'], function () {
        Route::resource('', \Botble\CourtBooking\Http\Controllers\BookingListController::class)->parameters(['' => 'booking-list']);
    });

});


