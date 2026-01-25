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

        // Invoice routes
        Route::get('{booking_list}/print-invoice', [\Botble\CourtBooking\Http\Controllers\BookingListController::class, 'printInvoice'])->name('print-invoice');
        Route::get('{booking_list}/download-invoice', [\Botble\CourtBooking\Http\Controllers\BookingListController::class, 'downloadInvoice'])->name('download-invoice');
        Route::post('{booking_list}/send-invoice', [\Botble\CourtBooking\Http\Controllers\BookingListController::class, 'sendInvoiceEmail'])->name('send-invoice');
    });

    // Services management
    Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
        Route::resource('', \Botble\CourtBooking\Http\Controllers\ServiceController::class)->parameters(['' => 'service']);
    });

    // Revenue Dashboard - đã chuyển sang plugin revenue-statistics

});


