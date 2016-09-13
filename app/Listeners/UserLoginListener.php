<?php

namespace App\Listeners;

use App\Events\UserLoginEvent;
use App\Jobs\UserActivityLogging\AddFlagForDatabaseBackup;
use App\Jobs\UserActivityLogging\RecordUserLogin;
use App\Notifications\UserLoginNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


/**
 * This listens for UserLogin events (which are thrown on successful login
 * attempts and dispatches the appropriate jobs.
 *
 * @package App\Listeners
 */
class UserLoginListener
{
    use DispatchesJobs;

    protected $user;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        $this->user = Auth::user();

        if ( ! empty($this->user) )
        {
          //  $this->user->notify(new UserLoginNotification($this->user));

            //This will log the user's log in
            $this->dispatch(new RecordUserLogin($this->user));

            //This will tell the backup system that the db has likely changed
            //and so should be backed up on the next run.
            $this->dispatch(new AddFlagForDatabaseBackup($this->user));
        }
    }

}
