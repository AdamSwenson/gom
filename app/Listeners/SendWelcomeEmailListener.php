<?php

namespace App\Listeners;

use App\Events\NewUserSignedUpEvent;
use App\Jobs\NewUser\SendWelcomeEmail;
use App\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Job;


/**
 * Class SendWelcomeEmailListener
 *
 * Dispatches actions related to sending a welcome email
 *
 * @package App\Listeners
 */
class SendWelcomeEmailListener
{

//    use DispatchesJobs;

    private $user;

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
     * @param  NewUserSignedUpEvent  $event
     * @return void
     */
    public function handle(NewUserSignedUpEvent $event)
    {
        $this->user = $event->user;
//        TODO update to dispatch to queuing system
//        $this->dispatch(new SendWelcomeEmail($this->user));

        $this->sendWelcomeEmail();
    }


    /**
     * Send the welcome email
     *
     */
    public function sendWelcomeEmail()
    {
        $to_address = $this->user->email;
        $to_name = $this->user->name;
        $user = $this->user;

        Mail::send('emails.welcome', ['user' => $user], function ($message) use($to_address, $to_name)
        {
            $message->to($to_address, $to_name)->subject('Welcome to the Gradeomatic!');
        });
    }

}
