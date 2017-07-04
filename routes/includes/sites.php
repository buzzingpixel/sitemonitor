<?php

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
