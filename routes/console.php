<?php

use App\Console\Controllers\CheckSitesController;
use App\Console\Controllers\CheckPingsController;
use App\Console\Controllers\CheckRemindersController;

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
})->describe('Check status of monitored sites');

Artisan::command('check-pings', function () {
    $checkSitesController = new CheckPingsController();
    $checkSitesController->runCheck();
})->describe('Send notifications for missing pings');

Artisan::command('check-reminders', function () {
    $checkSitesController = new CheckRemindersController();
    $checkSitesController->runCheck();
})->describe('Send notifications for reminders');
