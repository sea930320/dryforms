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
    $router->resource('roles', 'RolesController');
    $router->resource('uoms', 'UomsController');
    $router->resource('projects', 'ProjectsController');
    $router->resource('standard/forms', 'StandardsController');
    $router->resource('standard/form_orders', 'FormOrdersController');
    $router->resource('standard/scopes', 'StandardScopesController');
    $router->resource('areas', 'AreasController');
    $router->resource('standard/structures', 'StructuresController');
    $router->resource('standard/materials', 'MaterialsController');

    $router->delete('equipments-bulk-delete', 'EquipmentsController@bulkDestroy');
    $router->get('get-models/{id}', 'EquipmentCategoriesController@getModels');
    $router->get('validate-serial/{serial}/category_id/{categoryId}', 'EquipmentsController@validateSerial');
    $router->post('standard/statement', ['uses' => 'StandardsController@statementStore', 'as' => 'standard.statement.store']);
    $router->delete('standard/statement/{id}', ['uses' => 'StandardsController@statementDelete', 'as' => 'standard.statement.delete']);
    
    /** Account */
    $router->get('account', ['uses' => 'AccountController@show', 'as' => 'account.show']);
    $router->post('account/password/change', ['uses' => 'AccountController@changePassword', 'as' => 'account.password.change']);
    $router->post('account/email/change', ['uses' => 'AccountController@changeEmail', 'as' => 'account.email.change']);
/*------ testing code -------*/
    $router->post('account/subscribe', ['uses' => 'AccountController@subscribe', 'as' => 'account.subscribe.create']);
    $router->get('account/cancel-subscribe', ['uses' => 'AccountController@cancelSubscribe', 'as' => 'account.subscribe.cancel']);
    $router->get('account/resume-subscribe', ['uses' => 'AccountController@resumeSubscription', 'as' => 'account.subscribe.resume']);
/*---------------------------*/
});