<?php

namespace App\Http\Controllers\Time;

use App\Http\Controllers\Controller;
use App\Repositories\Time\IGradingTimeRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\GradingRequest;

use App\Exam;

/**
 * This handles all api requests having to do with grading time.
 *
 *
 * @package App\Http\Controllers\Api
 */
class TimeController extends Controller
{

    protected $dao;

    /**
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->dao = $dao = app()->make(IGradingTimeRepository::class);

    }

    public function getGradingTime( Exam $exam )
    {
        $out = ['examId' => $exam,
            'elapsedSeconds' => collect($exam->gradingTimes)->sum('seconds')
        ];
        return $out;
    }

    /**
     * Record or add to the time spent grade a particular student's exam
     * @param Exam $exam
     * @param GradingRequest $request
     * @return mixed
     */
    public function recordTime( Exam $exam, GradingRequest $request )
    {
        //Check that user owns the exam
        $this->authorize('access-object', $exam);

        if ( $request->has('student_id') && $request->has('time') ) {
            $time = $this->dao->record($exam->getId(), $request->input('student_id'), $request->input('time'));

            return $time;
        }
    }
}