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
    return redirect('/sites');
});

Route::get('/dashboard', function () {
    return redirect('/sites');
});

Auth::routes();

Route::get('/noaccess', function () {
    return view('noaccess');
});

Route::get('/sites', 'SitesController@index');
Route::post('/sites', 'SitesController@create');

Route::get('/sites/incidents/{monitoredSite}', 'SitesController@showIncidents');

Route::get('/sites/edit/{monitoredSite}', 'SitesController@view');
Route::post('/sites/edit/{monitoredSite}', 'SitesController@edit');

Route::post('/sites/delete/{monitoredSite}', 'SitesController@delete');

Route::get('/notifications', 'NotificationsController@index');
Route::post('/notifications', 'NotificationsController@create');

Route::get('/notifications/delete/{notificationEmail}', 'NotificationsController@delete');

Route::get('/admins', 'AdminsController@index');
Route::post('/admins', 'AdminsController@update');
