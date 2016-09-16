<?php

namespace App\Jobs;

use App\Exam;
use App\Http\Requests\GradingRequest;
use App\Repositories\Time\IGradingTimeRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordGradingTime implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $examId;
    protected $studentId;
    protected $time;

    /**
     * Create a new job instance.
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function __construct(Exam $exam, GradingRequest $request)
    {
        //Check that user owns the exam
        //$this->authorize('access-object', $exam);

        $this->examId = $exam->id;
        $this->studentId = $request->has('student_id') ? $request->input('student_id') : null;
        $this->time = $request->has('time') ? $request->input('time') : null;
    }

    /**
     * Record or add to the time spent grading a particular student's exam
     * @return \App\GradingTime|boolean
     */
    public function handle()
    {
        if ( ! empty($this->examId) && ! empty($this->studentId) && ! empty($this->time) )
        {
            $dao = app()->make(IGradingTimeRepository::class);
            $time = $dao->record($this->examId, $this->studentId, $this->time);

            return $time;
        }
        return false;
    }
}
