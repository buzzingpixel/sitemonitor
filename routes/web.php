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

// Tinker
Route::get('/tinker', 'TinkerController@index');

// Redirect to the sites area
Route::get('/', function () {
    return redirect('/sites');
});
Route::get('/dashboard', function () {
    return redirect('/sites');
});

// Get the auth routes
Auth::routes();

// Set up a route to send people to who don't have access to the app
Route::get('/noaccess', function () {
    return view('noaccess');
});


/**
 * /sites area
 */

// List sites
Route::get('/sites', 'SitesController@index');

// Create a site
Route::post('/sites', 'SitesController@create');

// Show site incidents
Route::get('/sites/incidents/{monitoredSite}', 'SitesController@showIncidents');

// Show site editor
Route::get('/sites/edit/{monitoredSite}', 'SitesController@view');

// Submit changes to a site
Route::post('/sites/edit/{monitoredSite}', 'SitesController@edit');

// Delete a site
Route::post('/sites/delete/{monitoredSite}', 'SitesController@delete');


/**
 * /pings area
 */

// List pings
Route::get('/pings', 'PingsController@index');

// Create a ping
Route::post('/pings', 'PingsController@create');

// Edit a ping
Route::get('/pings/edit/{ping}', 'PingsController@view');

// Submit ping edit
Route::post('/pings/edit/{ping}', 'PingsController@edit');

// Delete a ping
Route::post('/pings/delete/{ping}', 'PingsController@delete');

// Ping check in
Route::get('/pings/checkin/{ping}', 'PingsCheckinController@checkin');


/**
 * /notifications area
 */

// List emails
Route::get('/notifications', 'NotificationsController@index');

// Create an email
Route::post('/notifications', 'NotificationsController@create');

// Delete an email
Route::get(
    '/notifications/delete/{notificationEmail}',
    'NotificationsController@delete'
);


/**
 * /servers area
 */

Route::get('/servers', 'ServersController@index');


/**
 * /admins area
 */

// List users
Route::get('/admins', 'AdminsController@index');

// Update user permissions
Route::post('/admins', 'AdminsController@update');


/**
 * /settings area
 */

// Display settings
Route::get('/settings', 'SettingsController@index');

// Add SSH Key
Route::post('/settings/add-ssh-key', 'SettingsController@addSshKey');

// Delete SSH Key
Route::get('/settings/delete-ssh-key/{sshKey}', 'SettingsController@deleteSshKey');

// Delete SSH Key default
Route::get('/settings/make-default-ssh-key/{sshKey}', 'SettingsController@makeSshKeyDefault');
