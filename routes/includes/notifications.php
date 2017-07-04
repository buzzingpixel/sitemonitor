<?php

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
