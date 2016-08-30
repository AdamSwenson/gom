<?php

namespace App\Listeners\Grade;

use App\Events\Grade\PleaseRecordGradingTimeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GradingRecordDoneListener
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
     * @param  PleaseRecordGradingTime  $event
     * @return void
     */
    public function handle(PleaseRecordGradingTimeEvent $event)
    {
        $exam = $event->exam;
        $request = $event->request;
        //
    }
}
