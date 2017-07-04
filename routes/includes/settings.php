<?php

/**
 * /settings area
 */

// Display settings
Route::get('/settings', 'SettingsController@index');

// Display settings
Route::post('/settings', 'SettingsController@update');

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
