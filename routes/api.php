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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login')->name('api.auth.login');
Route::post('register', 'AuthController@register')->name('api.auth.register');

Route::group(['prefix' => 'auth', 'middleware' => 'auth.jwt'], function ($router) {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user-profile', 'AuthController@userProfile');
});

Route::middleware('auth.jwt')->group(function () {
    Route::post('/vehicle', 'VehicleController@store')->name('api.vehicle.store');
    Route::put('/vehicle/{id}', 'VehicleController@update')->name('api.vehicle.update');
    Route::delete('/vehicle/{id}', 'VehicleController@destroy')->name('api.vehicle.destroy');
});

Route::get('/vehicle', 'VehicleController@index')->name('api.vehicle.index');
Route::get('/vehicle/{vehicle}', 'VehicleController@show')->name('api.vehicle.show');
