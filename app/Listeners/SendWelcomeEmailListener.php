<?php

namespace App\Listeners;

use App\Listeners\NewUserSignedUpEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
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
        //
    }
}
