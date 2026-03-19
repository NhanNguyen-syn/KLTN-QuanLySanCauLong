<?php

use Illuminate\Support\Facades\Route;
use Botble\ReceptionistPortal\Http\Controllers\ReceptionistDashboardController;
use Botble\ReceptionistPortal\Http\Controllers\QuickBookingController;
use Botble\ReceptionistPortal\Http\Controllers\VipCustomerController;

Route::group(['namespace' => 'Botble\ReceptionistPortal\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'receptionist', 'as' => 'receptionist.'], function () {
            // Dashboard
            Route::get('/', [ReceptionistDashboardController::class, 'index'])
                ->name('index')
                ->permission('receptionist.index');

            // API endpoints
            Route::get('/today-bookings', [ReceptionistDashboardController::class, 'getTodayBookings'])
                ->name('today-bookings')
                ->permission('receptionist.index');

            Route::get('/pending-payments', [ReceptionistDashboardController::class, 'getPendingPayments'])
                ->name('pending-payments')
                ->permission('receptionist.payment');

            // Check-in/out
            Route::post('/checkin/{booking}', [ReceptionistDashboardController::class, 'checkin'])
                ->name('checkin')
                ->permission('receptionist.checkin');

            Route::post('/checkout/{booking}', [ReceptionistDashboardController::class, 'checkout'])
                ->name('checkout')
                ->permission('receptionist.checkin');

            // Quick Payment
            Route::post('/payment/{booking}', [ReceptionistDashboardController::class, 'processPayment'])
                ->name('payment')
                ->permission('receptionist.payment');

            // Batch operations
            Route::post('/batch-checkin', [ReceptionistDashboardController::class, 'batchCheckin'])
                ->name('batch-checkin')
                ->permission('receptionist.checkin');

            Route::post('/batch-checkout', [ReceptionistDashboardController::class, 'batchCheckout'])
                ->name('batch-checkout')
                ->permission('receptionist.checkin');

            Route::post('/batch-payment', [ReceptionistDashboardController::class, 'batchPayment'])
                ->name('batch-payment')
                ->permission('receptionist.payment');

            // Quick Booking
            Route::get('/quick-booking', [QuickBookingController::class, 'index'])
                ->name('quick-booking')
                ->permission('receptionist.quick-booking');

            Route::post('/quick-booking', [QuickBookingController::class, 'store'])
                ->name('quick-booking.store')
                ->permission('receptionist.quick-booking');

            Route::get('/check-availability', [QuickBookingController::class, 'checkAvailability'])
                ->name('check-availability')
                ->permission('receptionist.quick-booking');

            Route::get('/get-slots', [QuickBookingController::class, 'getSlots'])
                ->name('get-slots')
                ->permission('receptionist.quick-booking');

            // VIP Customers
            Route::resource('vip-customers', VipCustomerController::class)
                ->except(['show'])
                ->names([
                    'index' => 'vip.index',
                    'create' => 'vip.create',
                    'store' => 'vip.store',
                    'edit' => 'vip.edit',
                    'update' => 'vip.update',
                    'destroy' => 'vip.destroy',
                ]);
        });
    });
});
