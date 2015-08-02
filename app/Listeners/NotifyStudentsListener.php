<?php

namespace App\Listeners;

use App\Events\ExamReleased;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyStudentsListener
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
     * @param  ExamReleased  $event
     * @return void
     */
    public function handle(ExamReleased $event)
    {
        //
    }
}
