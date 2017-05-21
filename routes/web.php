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
    // return view('welcome');
    return '';
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::post('/dashboard', 'DashboardController@createSite');

Route::get('/dashboard/site/{monitoredSite}', 'DashboardController@editSite');

Route::post('/dashboard/site/{monitoredSite}', 'DashboardController@updateSite');
