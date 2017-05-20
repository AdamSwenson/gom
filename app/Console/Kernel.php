<?php

namespace App\Console;

use App\Console\Commands\BackupDatabase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        BackupDatabase::class //backup:db
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule( Schedule $schedule )
    {
        //daily database dump
        //this will check for the flag indicating that gom
        //has been recently used and needs backing up
        $schedule->command(BackupDatabase::class)->daily();

        if ( env('APP_ENV') == 'production' ) {
            //weekly forced database dump (whether or not there is a flag)
            $schedule->command(BackupDatabase::class,  ['--force'])->weekly();
        }
    }

}
