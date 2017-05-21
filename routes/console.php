<?php

use App\Console\Controllers\CheckSitesController;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('check-sites', function () {
    $checkSitesController = new CheckSitesController();
    $checkSitesController->runCheck();
})->describe('Check status of monitored sties');
