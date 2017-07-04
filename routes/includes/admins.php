<?php

/**
 * /admins area
 */

// List users
Route::get('/admins', 'AdminsController@index');

// Update user permissions
Route::post('/admins', 'AdminsController@update');
