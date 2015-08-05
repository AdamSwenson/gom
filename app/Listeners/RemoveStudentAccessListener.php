<?php

namespace App\Listeners;

use App\Events\UnreleaseExamEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveStudentAccessListener
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
     * @param  UnreleaseExamEvent  $event
     * @return void
     */
    public function handle(UnreleaseExamEvent $event)
    {
        //
    }
}
