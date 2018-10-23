<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    Route::get('/domains', 'DomainController@index')->name('domain.index');

    Route::resource('accounts', 'AccountController');
});

Route::get('/v1/health/check', 'HealthController@check')->name('health.check');