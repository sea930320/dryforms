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
    Route::post('login', ['uses' => 'Auth\ApiAuthController@login', 'as' => 'api.login']);
    Route::post('logout', 'Auth\ApiAuthController@logout');
    Route::post('refresh', 'Auth\ApiAuthController@refresh');
});


//TODO authentification middleware
Route::namespace('Api')->middleware(['jwt.auth'])->group(function() {
    Route::resource('categories', 'EquipmentCategoriesController');
    Route::resource('models', 'EquipmentModelsController');
    Route::resource('teams', 'TeamsController');
    Route::resource('statuses', 'EquipmentStatusesController');
    Route::resource('equipments', 'EquipmentsController');
    Route::delete('equipments-bulk-delete', 'EquipmentsController@bulkDestroy');
    Route::get('get-models/{id}', 'EquipmentCategoriesController@getModels');
    Route::resource('companies', 'CompaniesController');
    Route::resource('employee-statuses', 'EmployeeStatusesController');
    Route::resource('company-employees', 'CompanyEmployeesController');
});