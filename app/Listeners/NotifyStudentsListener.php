<?php

namespace App\Listeners;

use App\Events\ExamReleasedEvent;
use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\StudentNotificationCompleteEvent;
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
     * @param ExamReleasedEvent|FeedbackCompilationCompleteEvent $event
     */
    public function handle(FeedbackCompilationCompleteEvent $event)
    {
        //delay for demo
        //
        event(new StudentNotificationCompleteEvent());
    }


}
