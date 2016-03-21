<?php

namespace App\Jobs\UserActivityLogging;


use App\Jobs\Job;
use App\Repositories\Utilities\IBackupFlagRepository;
use App\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Carries out the operations for adding a flag to notify the backup system
 * that the database should be backed up on the next scheduled run.
 *
 * Hopefully this will be irrelevant eventually. But for now, it does not make sense
 * to backup even weekly if the app isn't being used. However, if it is used, we
 * should back up at least daily.
 *
 * This is thus a compromise which flags the database to be backed up after someone logs in.
 * Then the scheduled backup task can check for these flags and decide to run.
 *
 * @package App\Jobs
 */
class AddFlagForDatabaseBackup extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dao = app()->make(IBackupFlagRepository::class);

        if ( $dao->setFlag() )
        {
            Log::info("Backup flag set");
        }
    }
}
