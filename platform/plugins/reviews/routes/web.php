<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Reviews\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            Route::resource('', 'ReviewController')->parameters(['' => 'review']);
            
            Route::post('analyze/{id}', [
                'as' => 'analyze',
                'uses' => 'ReviewController@analyze',
            ]);

            Route::post('{id}/reply', [
                'as' => 'reply',
                'uses' => 'ReviewController@reply',
            ]);

            Route::delete('reply/{id}', [
                'as' => 'reply.destroy',
                'uses' => 'ReviewController@destroyReply',
            ]);

            Route::delete('items/destroy', [
                'as' => 'destroy.index',
                'uses' => 'ReviewController@deletes',
                'permission' => 'reviews.destroy',
            ]);
        });
    });
});
