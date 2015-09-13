<?php

namespace App\Listeners;

use App\Events\ExamReleasedEvent;
use App\Events\FeedbackCompilationCompleteEvent;
use App\Jobs\Feedback\NotifyAllStudents;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Listens for the command to notify all students and dispatches the
 * job which handles notification
 *
 * @package App\Listeners
 */
class NotifyStudentsListener
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event. Dispatches a NotifyAllStudents event to the emails queue.
     *
     * @param ExamReleasedEvent|FeedbackCompilationCompleteEvent $event
     */
    public function handle(FeedbackCompilationCompleteEvent $event)
    {
        $job = (new NotifyAllStudents($event->getExam()))->onQueue('emails');
        $this->dispatch($job);
    }


}
