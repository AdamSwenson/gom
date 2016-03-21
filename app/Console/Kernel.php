<?php

namespace App\Console;

use App\Repositories\Utilities\IBackupFlagRepository;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    public $flagDao;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->hourly();

        $this->flagDao = app()->make(IBackupFlagRepository::class);
        
        //backup db to drop box
        $schedule->command($this->createBackupCommandString())
            ->everyFiveMinutes()
            ->when(function ()
            {
                Log::info('Scheduled backup command called');
                //only backup if on production server and if someone has logged in recently
                if ( env('APP_ENV') == 'production' && $this->flagDao->isFlagged() )
                {
                    Log::info('Scheduled backup command will run');
                    return true;
                }
            })
            ->after(function ()
            {
                //if it was flagged, remove the flag
                if($this->flagDao->removeFlag()){
                    Log::info('Backup flag removed');                    
                }
            });
    }

    public function createBackupCommandString()
    {
        $date = Carbon::now()->toDateString();

        return "db:backup --database=mysql --destination=dropbox --destinationPath=/{$date}-gom-backup --compression=gzip";
    }
}
