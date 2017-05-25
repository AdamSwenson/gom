<?php

namespace App\Console\Commands;

use App\Repositories\Utilities\IBackupFlagRepository;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class BackupDatabase extends Command
{
    public $flagDao;

    /**
     * The name and signature of the console command.
     * If force is indicated, it bypasses the flag stuff
     * @var string
     */
    protected $signature = 'backup:db  {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes a mysql dump and saves the output to the specified location';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->flagDao = app()->make(IBackupFlagRepository::class);
    }

    static public function makeSlackWebhookUrl()
    {
        return 'https://hooks.slack.com/services/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';
    }

    /**
     * Creates the command line string to be run
     * @return string
     */
    static public function createBackupCommandString()
    {
        $date = Carbon::now()->toDateString();
        $time = Carbon::now()->toTimeString();

        return "php artisan db:backup --database=mysql --destination=dropbox --destinationPath=/{$date}-{$time}-gom-backup --compression=gzip";
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Log the fact that this command has been called
        Log::info('Backup command called');

        //Check whether should run
        //That will be true in the special case of being forced
        //or when a backup flag has been set in the production environment
        if ( $this->options('force') || $this->isFlagged() ) {
            $process = $this->runBackup();

            if ( isset($process) && $process->isSuccessful() ) {
                $this->handleSuccess($process);
            } else {
                $this->handleError($process);
            }
        }
        Log::info('Backup command complete');
    }

    /**
     * Runs the backup without checking for flags
     * @return Process
     */
    public function runBackup(): Process
    {
        Log::info('Running backup ');
        $process = new Process(self::createBackupCommandString());

        $process->run();

        return $process;
    }


    /**
     * Determines whether a flag is set and thus whether should
     * run in the standard case
     * @return bool
     */
    public function isFlagged()
    {
        if ( env('APP_ENV') == 'production' && $this->flagDao->isFlagged() ) {
            return true;
        }
        return false;
    }

    /**
     * Logs successful backup and clears flags
     * NB, will only clear flag if a flag was set
     * @param $process
     */
    public function handleSuccess( Process $process )
    {
        //The process was successful, so now we clean up
        //First, log the success
        Log::info('Backup successful');

        if ( $this->isFlagged() ) {
            //if the flag was set, remove the flag
            if ( $this->flagDao->removeFlag() ) {
                Log::info('Backup flag removed');
            }
        }
    }

    /**
     * Logs the error if something went wrong
     * @param $process
     */
    public function handleError( Process $process )
    {
        // handle and log error
        Log::info('Error backing up db');
        throw new ProcessFailedException($process);
    }

}