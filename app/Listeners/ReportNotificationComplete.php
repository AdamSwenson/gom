<?php

namespace App\Listeners;

use App\Events\StudentNotificationCompleteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportNotificationComplete
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
     * @param  StudentNotificationCompleteEvent  $event
     * @return void
     */
    public function handle(StudentNotificationCompleteEvent $event)
    {
        return view('feedback.progress_send_complete');

        //
    }
}
