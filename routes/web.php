<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::resource('users', 'Backend\UsersController');
    Route::resource('plans', 'Backend\PlansController');
    Route::resource('coupons', 'Backend\CouponsController');

//    Route::resource('statuses', 'Backend\StatusController');
//    Route::resource('teams', 'Backend\TeamController');
//    Route::resource('models', 'Backend\ModelController');
//    // equipments
//    Route::resource('equipments', 'Backend\EquipmentController', ['except' => ['index', 'show']]);
//    Route::get('equipments/{model_id}', 'Backend\EquipmentController@index')->name('equipments.index');
//    Route::get('summarized-equipments', 'Backend\EquipmentController@summarized')->name('equipments.summarized');
//    Route::post('change-team', 'Backend\EquipmentController@changeTeam')->name('equipments.change.team');
//    Route::post('change-status', 'Backend\EquipmentController@changeStatus')->name('equipments.change.team');
//    Route::post('change-location', 'Backend\EquipmentController@changeLocation')->name('equipments.change.location');
//    Route::post('delete-equipment', 'Backend\EquipmentController@bulkDelete')->name('equipments.delete');
//    Route::post('get-models-by-category', 'Backend\EquipmentController@getModels')->name('equipments.get.models');
});

Route::middleware([])->namespace('Frontend')->group(function() {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'main.index']);
});