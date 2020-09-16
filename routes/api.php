<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'AuthController@login')->name('api.auth.login');
    Route::post('register', 'AuthController@register')->name('api.auth.register');

    Route::middleware('auth.jwt')->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('/users', 'AuthController@users');

        Route::get('/vehicles', 'VehicleController@index')->name('api.vehicle.index');
        Route::get('/vehicles/{vehicle}', 'VehicleController@show')->name('api.vehicle.show');
        Route::post('/vehicles', 'VehicleController@store')->name('api.vehicle.store');
        Route::put('/vehicles/{id}', 'VehicleController@update')->name('api.vehicle.update');
        Route::delete('/vehicles/{id}', 'VehicleController@destroy')->name('api.vehicle.destroy');

        Route::get('/rents/all/{from}/{to}', 'RentController@index')->name('api.rent.index');
        Route::post('/rents', 'RentController@store')->name('api.rent.store');
    });
});

