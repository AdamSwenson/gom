<?php

namespace App\Http\Controllers\Time;

use App\GradingTime;
use App\Http\Controllers\Controller;

use App\Repositories\Time\IGradingTimeRepository;

use App\Http\Requests\Grading\GradingTimeRequest; //old gom
use App\Http\Requests\GradingRequest; // new gom

use App\Exam;
use App\Student;

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

    /**
     * Returns all grading times for an exam
     * @param Exam $exam
     * @return array
     */
    public function getGradingTimes( Exam $exam )
    {
        $c = collect($exam->gradingTimes);

        $out = [
            'examId' => $exam,
            'gradingTimes' => $c,
            'elapsedSeconds' => $c->sum('seconds'),
            'averageSeconds' => $c->average('seconds')
        ];

        return $out;
    }

    /**
     * OLDER VERSION
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

// ---------------------------- New grading

    /**
     * @param Exam $exam
     * @param Student $student
     * @param GradingTimeRequest $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function update( Exam $exam, Student $student, GradingTimeRequest $request )
    {
        $in = ['student_id' => $student->id, 'exam_id' => $exam->id];
        $gt = GradingTime::firstOrCreate($in);
        $gt->seconds = $request->input('time');
        $gt->save();
        return $this->sendAjaxSuccess();
    }

    /**
     * @param Exam $exam
     * @param Student $student
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show( Exam $exam, Student $student )
    {
        $in = ['student_id' => $student->id, 'exam_id' => $exam->id];
        return GradingTime::firstOrCreate($in);
    }


}