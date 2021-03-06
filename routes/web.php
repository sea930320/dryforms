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

Route::middleware(['auth'])->namespace('Backend')->prefix('admin')->group(function() {

    Route::get('dropboxFileUpload', 'UsersController@dropboxFileUpload');
    Route::resource('users', 'UsersController');
    Route::resource('plans', 'PlansController');
    Route::resource('coupons', 'CouponsController');
    Route::resource('standard/forms', 'StandardFormsController');
    Route::resource('standard/scopes', 'StandardScopesController');    
    Route::get('standard/moisture', 'StandardMoistureMapController@index')->name('moisture-page');
    Route::get('standard/area', 'StandardAffectedAreasController@areaPage')->name('areas-page');
    Route::get('standard/team', 'StandardTeamsController@teamsPage')->name('teams-page');
    Route::resource('units-of-measure', 'UnitsOfMeasureController');

// ------------------API-----------------//
    Route::resource('standard/areas', 'StandardAffectedAreasController');
    Route::resource('standard/teams', 'StandardTeamsController');
    Route::resource('standard/structure', 'StardardMoistureMapStructureController');
    Route::resource('standard/material', 'StardardMoistureMapMaterialController');
    Route::get('uoms/jsonResult', 'UnitsOfMeasureController@jsonResult');
    Route::get('standard-scopes/form', 'StandardScopesController@form');
    Route::post('standard-scopes/form-update', 'StandardScopesController@formUpdate');
    Route::get('standard-moisture/form', 'StandardMoistureMapController@form');
    Route::post('standard-moisture/form-update', 'StandardMoistureMapController@formUpdate');
    Route::get('standard-areas/form', 'StandardAffectedAreasController@form');
    Route::post('standard-areas/form-update', 'StandardAffectedAreasController@formUpdate');

    Route::resource('training/categories', 'TrainingController');
    Route::resource('training/videos', 'TrainingVideosController');
});

Route::get('/project/print/{id}', 'Api\ProjectFormsController@print');

Route::middleware([])->namespace('Frontend')->group(function() {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'main.index']);
});