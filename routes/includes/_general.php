<?php

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
