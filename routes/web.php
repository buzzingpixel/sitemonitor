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
    return redirect('/dashboard');
});

Auth::routes();

// Old Routes

Route::get('/dashboard', 'DashboardController@index');

Route::post('/dashboard', 'DashboardController@createSite');

Route::get('/dashboard/site/{monitoredSite}', 'DashboardController@editSite');

Route::post('/dashboard/site/{monitoredSite}', 'DashboardController@updateSite');

Route::post('/dashboard/site/delete/{monitoredSite}', 'DashboardController@deleteSite');

Route::post('/dashboard/email', 'DashboardController@addEmail');

Route::get('/dashboard/email/{notificationEmail}', 'DashboardController@deleteEmail');

Route::post('/dashboard/users', 'DashboardController@updateUsers');

Route::get('/dashboard/site/incidents/{monitoredSite}', 'DashboardController@viewSiteIncidents');

// New Routes

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
