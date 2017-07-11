<?php

/**
 * /reminders area
 */

// List available reminders
Route::get('/reminders', 'RemindersController@index');

// Create new reminder
Route::post('/reminders', 'RemindersController@create');
