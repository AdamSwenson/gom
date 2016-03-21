<?php

namespace App\Jobs\UserActivityLogging;

use App\Jobs\Job;
use App\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Handles writing the login event to the log and any other
 * recording or notifications that needs to be done upon
 * someone logging in.
 *
 * @package App\Jobs
 */
class RecordUserLogin extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
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
        $this->addUserLoginToLog();
    }

    /**
     * Writes a notification that the user logged in to the log
     */
    public function addUserLoginToLog()
    {
        if ( ! empty($this->user) )
        {
            $id = $this->user->id;
            $message = "UserLoginEvent: User #{$id} has logged in";
            Log::info($message);
        }
    }
}
