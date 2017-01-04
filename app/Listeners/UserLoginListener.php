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
    public function handle( $event)
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

        $message = "<p>We'd love to hear what you think about the gradeomatic. Please fill out this short survey: <br/><a href='https://docs.google.com/forms/d/e/1FAIpQLSdJBXiK_lmWtT15BrXLpFBiFR5Qly9ab2bgZoy3Wlpu_qDgtw/viewform'>https://docs.google.com/forms/d/e/1FAIpQLSdJBXiK_lmWtT15BrXLpFBiFR5Qly9ab2bgZoy3Wlpu_qDgtw/viewform</a></p>";
            //Push message for login into session
            flash()->info($message)->important();
        }
    }

}
