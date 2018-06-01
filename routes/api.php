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
    $router->resource('project/status', 'ProjectStatusController');
    $router->resource('project/forms', 'ProjectFormsController');
    $router->resource('project/call_reports', 'ProjectCallReportsController');
    $router->resource('project/dailylog', 'ProjectDailylogsController');
    $router->resource('project/statement', 'ProjectStatementsController');
    $router->resource('project/area', 'ProjectAreasController');
    $router->resource('project/scope', 'ProjectScopesController');
    $router->resource('project/moisture', 'ProjectMoistureController');
    $router->resource('project/psychometric', 'ProjectPsychometricController');
    $router->resource('project/days', 'ProjectMoistureDaysController');
    $router->post('project/days/delete/{id}', 'ProjectMoistureDaysController@deleteItem');
    $router->resource('standard/forms', 'StandardsController');
    $router->resource('standard/form_orders', 'FormOrdersController');
    $router->resource('standard/scopes', 'StandardScopesController');
    $router->resource('standard/dailylog_settings', 'StandardDailylogSettingsController');
    $router->resource('areas', 'AreasController');
    $router->resource('standard/structures', 'StructuresController');
    $router->resource('standard/materials', 'MaterialsController');

    $router->post('project/psychometric/updatetime', 'ProjectPsychometricController@updatetime');
    $router->get('training/categories', 'TrainingManageController@index');
    $router->get('training/videos', 'TrainingManageController@getVideos');
    $router->get('project/email', 'ProjectFormsController@prepareEmail');
    $router->get('project/email/send', 'ProjectFormsController@sendEmail')->name('send-email');
    $router->delete('equipments-bulk-delete', 'EquipmentsController@bulkDestroy');
    $router->get('get-models/{id}', 'EquipmentCategoriesController@getModels');
    $router->get('validate-serial/{serial}/category_id/{categoryId}', 'EquipmentsController@validateSerial');
    $router->post('standard/statement', ['uses' => 'StandardsController@statementStore', 'as' => 'standard.statement.store']);
    $router->delete('standard/statement/{id}', ['uses' => 'StandardsController@statementDelete', 'as' => 'standard.statement.delete']);
    $router->get('project/get-footer', 'ProjectFormsController@getFooter');
    
    $router->post('project/set-signature', 'ProjectFormsController@setSignature');
    $router->post('project/restore-status', 'ProjectsController@restoreStatus');

    $router->get('psychometric/calculate', 'PsychometricCalculationsController@calculate');
    $router->get('psychometric/dew', 'DewCalculationController@calculate');

    /** Account */
    $router->get('account', ['uses' => 'AccountController@show', 'as' => 'account.show']);
    $router->post('account/password/change', ['uses' => 'AccountController@changePassword', 'as' => 'account.password.change']);
    $router->post('account/email/change', ['uses' => 'AccountController@changeEmail', 'as' => 'account.email.change']);
/*------ testing code -------*/
    $router->post('account/subscribe', ['uses' => 'AccountController@subscribe', 'as' => 'account.subscribe.create']);
    $router->get('account/cancel-subscribe', ['uses' => 'AccountController@cancelSubscribe', 'as' => 'account.subscribe.cancel']);
    $router->get('account/resume-subscribe', ['uses' => 'AccountController@resumeSubscription', 'as' => 'account.subscribe.resume']);
    $router->get('account/get-invoices', ['uses' => 'AccountController@getInvoices', 'as' => 'account.get.invoices']);

/*---------------------------*/
});
