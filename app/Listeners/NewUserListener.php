<?php

namespace App\Listeners;

use App\Events\NewUserSignedUpEvent;
use App\Jobs\NewUser\NotifyTeamOfNewSignup;
use App\Jobs\NewUser\SendWelcomeEmail;
use App\Notifications\WelcomeEmail;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Job;


/**
 * Dispatches actions related to a new user signing up
 * upon noticing a NewUserSignedUpEvent
 *
 * @package App\Listeners
 */
class NewUserListener
{
    use DispatchesJobs;

    /** @var  User */
    private $user;

    /** Which worker queue should handle the task */
    const QUEUE_TO_USE = 'emails';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Do everything that needs to happen on sign up.
     *
     * @param  NewUserSignedUpEvent  $event
     * @return void
     */
    public function handle(NewUserSignedUpEvent $event)
    {
        $this->user = $event->user;

        //Send welcome email
        $this->user->notify(new WelcomeEmail($this->user));
//        $job = ( new SendWelcomeEmail($this->user) )->onQueue(self::QUEUE_TO_USE);
//        $this->dispatch($job);

        //Notify team of new sign up
        $job = (new NotifyTeamOfNewSignup($this->user))->onQueue(self::QUEUE_TO_USE);
        $this->dispatch($job);

    }


//    /**
//     * Send the welcome email
//     *
//     */
//    public function sendWelcomeEmail()
//    {
//        $to_address = $this->user->email;
//        $to_name = $this->user->name;
//        $user = $this->user;
//
//        Mail::send('emails.welcome', ['user' => $user], function ($message) use($to_address, $to_name)
//        {
//            $message->to($to_address, $to_name)->subject('Welcome to the Gradeomatic!');
//        });
//    }

}
