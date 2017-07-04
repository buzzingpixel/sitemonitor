<?php

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

// SERVER GROUPS

// Add server group
Route::post('/servers/add-group', 'ServerGroupsController@create');

// View server group
Route::get('/servers/edit-group/{serverGroup}', 'ServerGroupsController@view');

// Edit server group
Route::post('/servers/edit-group/{serverGroup}', 'ServerGroupsController@edit');

// SCRIPTS

// Get script template
Route::get('/servers/scripts/script-template', function () {
    return view('servers.partials.script');
});

// Show scripts
Route::get('/servers/scripts', 'ScriptsController@index');

// Add Script Set
Route::post('/servers/scripts/add-script-set', 'ScriptsController@addSet');

// View script set
Route::get('/servers/scripts/{scriptSet}', 'ScriptsController@viewSet');

// Update script set
Route::post('/servers/scripts/{scriptSet}', 'ScriptsController@updateSet');

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
