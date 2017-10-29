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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::resource('users', 'Backend\UsersController');
    Route::resource('plans', 'Backend\PlansController');
    Route::resource('coupons', 'Backend\CouponsController');
});