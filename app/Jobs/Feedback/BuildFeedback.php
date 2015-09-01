<?php

namespace App\Jobs\Feedback;

use App\Exam;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuildFeedback extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $students;

    public $examId;

    /** @var \App\Repositories\Feedback\IFeedbackBuilder */
    protected $feedbackBuilder;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
        $this->feedbackBuilder = app()->make('App\Repositories\Feedback\IFeedbackBuilder');

    }

    /**
     * Execute the job.
     *
     * @param Exam $exam
     */
    public function handle(Exam $exam)
    {
        $this->feedbackBuilder->buildFeedback($exam->id);
    }


}
