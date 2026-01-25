<?php

use Illuminate\Support\Facades\Route;
use Botble\RevenueStatistics\Http\Controllers\RevenueDashboardController;

Route::group(['namespace' => 'Botble\RevenueStatistics\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'revenue-statistics', 'as' => 'revenue-statistics.'], function () {
            Route::get('/', [RevenueDashboardController::class, 'index'])
                ->name('index')
                ->permission('revenue-statistics.index');

            Route::get('/chart-data', [RevenueDashboardController::class, 'getChartData'])
                ->name('chart-data')
                ->permission('revenue-statistics.view');

            Route::get('/summary', [RevenueDashboardController::class, 'getSummary'])
                ->name('summary')
                ->permission('revenue-statistics.view');

            Route::get('/export', [RevenueDashboardController::class, 'export'])
                ->name('export')
                ->permission('revenue-statistics.export');
        });
    });
});
