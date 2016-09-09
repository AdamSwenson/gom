<?php

namespace App\Listeners;

use App\Events\ExamReleasedEvent;
use App\Events\FeedbackCompilationCompleteEvent;
use App\Jobs\Feedback\NotifyAllStudents;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Listens for feedback compilation to be complete. Once it is, it dispatches the
 * job which handles notification
 *
 * @package App\Listeners
 */
class NotifyStudentsListener
{
    use DispatchesJobs;

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
     * Handle the FeedbackCompilationComplete event. Dispatches a NotifyAllStudents event to the emails queue.
     *
     * @param ExamReleasedEvent|FeedbackCompilationCompleteEvent $event
     */
    public function handle(FeedbackCompilationCompleteEvent $event)
    {
        if($event->wasForAllStudents()){
            $job = (new NotifyAllStudents($event->getExam()))->onQueue(self::QUEUE_TO_USE);
            $this->dispatch($job);
        }
        elseif ($event->wasForSingleStudent()){
            //TODO actions to do if compiled a single student's feedback
        }

    }


}
