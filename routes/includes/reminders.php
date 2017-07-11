<?php

/**
 * /reminders area
 */

// List available reminders
Route::get('/reminders', 'RemindersController@index');

// Create new reminder
Route::post('/reminders', 'RemindersController@create');

// Edit reminder
Route::get('/reminders/edit/{reminder}', 'RemindersController@view');

// Submit edit reminder
Route::post('/reminders/edit/{reminder}', 'RemindersController@edit');

// Delete reminder
Route::post('/reminders/delete/{reminder}', 'RemindersController@delete');
