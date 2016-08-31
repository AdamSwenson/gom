<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordGradingTime implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function handle(Exam $exam, GradingRequest $request)
    {
        $this->recordTime($exam, $request);
    }

    /**
     * Record or add to the time spent grade a particular student's exam
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function recordTime(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        if ( $request->has('student_id') && $request->has('time') )
        {
            $dao = app()->make('App\Repositories\Time\IGradingTimeRepository');
            $time = $dao->record($exam->getId(), $request->input('student_id'), $request->input('time'));

            return $time;
        }
    }

}
