<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     * @var array
     */
    // protected $commands = [];

    /**
     * Set schedule
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $command = $schedule->command('check-sites')
            ->everyMinute()
            ->withoutOverlapping();

        if (env('CHECK_SITES_PING')) {
            $command->thenPing(env('CHECK_SITES_PING'));
        }

        $schedule->command('check-pings')
            ->everyMinute()
            ->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
