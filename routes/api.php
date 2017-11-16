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

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', ['uses' => 'Auth\ApiLoginController@login', 'as' => 'api.login']);
    Route::post('logout', 'Auth\ApiAuthController@logout');
    Route::post('refresh', 'Auth\ApiAuthController@refresh');
    Route::post('me', 'Auth\ApiAuthController@me');
});


//TODO authentification middleware
Route::namespace('Api')->middleware(['auth:api'])->group(function() {
    Route::resource('categories', 'EquipmentCategoriesController');
});