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

// SSH KEYS

// List user ssh keys for servers
Route::get('/servers/user-server-keys', 'ServersSshUserKeysController@index');

// Update user ssh keys for servers
Route::post('/servers/user-server-keys', 'ServersSshUserKeysController@update');

// Server key management
Route::get('/servers/server-key-management', 'ServerKeyManagementController@index');

// List Authorized Keys
Route::get(
    'servers/server-key-management/list-authorized-keys/{server}',
    'ServerKeyManagementController@listServerKeys'
);

// Add authorized key
Route::post(
    'servers/server-key-management/add-authorized-key',
    'ServerKeyManagementController@addAuthorizedKey'
);

// Remove authorized key
Route::post(
    'servers/server-key-management/remove-authorized-key',
    'ServerKeyManagementController@removeAuthorizedKey'
);

// SERVERS

// List servers
Route::get('/servers', 'ServersController@index');

// Create server
Route::post('/servers', 'ServersController@create');

// View server
Route::get('/servers/{server}', 'ServersController@view');

// Edit server
Route::post('/servers/{server}', 'ServersController@edit');

// Delete server
Route::post('/servers/delete/{server}', 'ServersController@delete');


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

// Display change password form
Route::get('/settings/change-password', 'Auth\UpdatePasswordController@index');

// Submit change password form
Route::post('/settings/change-password', 'Auth\UpdatePasswordController@update');
