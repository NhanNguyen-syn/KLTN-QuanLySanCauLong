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

    // Forecasting & Insights
    Route::group(['prefix' => 'forecasting', 'as' => 'forecasting.'], function () {
        Route::get('', [
            'uses' => '\\Botble\\CourtBooking\\Http\\Controllers\\Admin\\ForecastingController@index',
            'as' => 'index',
            'permission' => 'booking-list.index',
        ]);

        Route::post('insight/{id}/read', [
            'uses' => '\\Botble\\CourtBooking\\Http\\Controllers\\Admin\\ForecastingController@markInsightRead',
            'as' => 'mark-read',
            'permission' => 'booking-list.index',
        ]);

        Route::post('regenerate', [
            'uses' => '\\Botble\\CourtBooking\\Http\\Controllers\\Admin\\ForecastingController@regenerate',
            'as' => 'regenerate',
            'permission' => 'booking-list.edit',
        ]);
    });

    // Revenue Dashboard - đã chuyển sang plugin revenue-statistics

});



// Public Invoice Download Route
Route::group(['middleware' => ['web', 'core']], function () {
    Route::get('invoice/download/{code}', function ($code) {
        if (!$code)
            abort(404);

        $bookings = \Botble\CourtBooking\Models\BookingList::query()
            ->where('order_code', $code)
            ->get();

        if ($bookings->isEmpty())
            abort(404, 'Order not found');

        $service = new \Botble\CourtBooking\Services\InvoicePdfService();
        $pdf = $service->generateGroupedPdf($bookings);

        return $pdf->download('hoa-don-' . $code . '.pdf');
    });
});
