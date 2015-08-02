<?php

namespace App\Listeners;

use App\Events\ExamReleased;
use App\Events\FeedbackCompilationComplete;
use App\Repositories\Feedback\IFeedbackBuilder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class FeedbackCompileListener
 *
 * This gets notified when an exam is released. It compiles and stores the feedback for the exam.
 * @package App\Listeners
 */
class FeedbackCompileListener implements ShouldQueue
{
    /**
     * @var IFeedbackBuilder
     */
    private $feedbackBuilder;

    /**
     * Create the event listener.
     *
     * @param IFeedbackBuilder $feedbackBuilder
     */
    public function __construct(IFeedbackBuilder $feedbackBuilder)
    {
        //
        $this->feedbackBuilder = $feedbackBuilder;
    }

    /**
     * Handle the event.
     *
     * @param  ExamReleased  $event
     * @return void
     */
    public function handle(ExamReleased $event)
    {
        $feedback = $this->feedbackBuilder->buildFeedback($event->exam->getId());
        if(!empty($feedback))
        {
            //once done, fire the notification that ready for distribution
            event(new FeedbackCompilationComplete($event->exam));
        }

    }
}
