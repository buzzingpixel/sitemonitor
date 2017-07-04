<?php

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
