<?php

namespace App\Listeners;

use App\Events\ExamReleasedEvent;
use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\StudentNotificationCompleteEvent;
use App\Jobs\Feedback\NotifyAllStudents;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyStudentsListener
{
    use DispatchesJobs;

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
        $this->dispatch(new NotifyAllStudents($event->getExam()));
        //delay for demo
        //
        //event(new StudentNotificationCompleteEvent());
    }


}
