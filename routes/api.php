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
    $router->post('login', ['uses' => 'Auth\ApiAuthController@login', 'as' => 'api.login']);
    $router->post('register', ['uses' => 'Auth\ApiAuthController@register', 'as' => 'api.register']);
    $router->post('logout', 'Auth\ApiAuthController@logout');
    $router->get('refresh', 'Auth\ApiAuthController@refresh');
});

Route::namespace('Api')->middleware(['jwt.auth'])->group(function($router) {
    $router->resource('companies', 'CompaniesController');
    $router->resource('categories', 'EquipmentCategoriesController');
    $router->resource('models', 'EquipmentModelsController');
    $router->resource('teams', 'TeamsController');
    $router->resource('statuses', 'EquipmentStatusesController');
    $router->resource('equipment', 'EquipmentsController');
    $router->resource('forms', 'FormsController');
    $router->resource('users', 'UsersController');
    $router->resource('areas', 'AreasController');
    $router->delete('equipments-bulk-delete', 'EquipmentsController@bulkDestroy');
    $router->get('get-models/{id}', 'EquipmentCategoriesController@getModels');
    $router->get('validate-serial/{serial}/{modelId}', 'EquipmentsController@validateSerial');

    /** Account */
    $router->get('account', ['uses' => 'AccountController@show', 'as' => 'account.show']);
    $router->post('account/password/change', ['uses' => 'AccountController@changePassword', 'as' => 'account.password.change']);
    $router->post('account/email/change', ['uses' => 'AccountController@changeEmail', 'as' => 'account.email.change']);
});