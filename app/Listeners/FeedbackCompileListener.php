<?php

namespace App\Listeners;

use App\Events\ExamReleasedEvent;
use App\Events\FeedbackCompilationCompleteEvent;
use App\Repositories\Feedback\IFeedbackBuilder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * DEPRECATED
 * DOES NOT REALLY MAKE SENSE TO RUN THIS VIA LISTENERS SINCE THERE'S ONLY
 * ONE THING THAT NEEDS TO LISTEN. RATHER, BETTER TO DISPATCH DIRECTLY TO QUEUE
 * AND THEN LET THE LATER EVENT BE RESPONSIBLE FOR THE NEXT STEPS
 *
 *
 * Class FeedbackCompileListener
 *
 * This gets notified when an exam is released. It compiles and stores the feedback for the exam.
 *
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
        $this->feedbackBuilder = $feedbackBuilder;
    }

    /**
     * Handle the event.
     *
     * @param  ExamReleasedEvent  $event
     * @return void
     */
    public function handle(ExamReleasedEvent $event)
    {
        $examId = $event->getExamId();
        $feedback = $this->feedbackBuilder->buildFeedback($examId);
        if(!empty($feedback))
        {
            //once done, fire the notification that ready for distribution
            $exam = $event->getExam();
            event(new FeedbackCompilationCompleteEvent($exam));
        }

    }

//    public function displayProgress()
//    {
//        echo view('feedback.progress_compiling');
//    }
}
