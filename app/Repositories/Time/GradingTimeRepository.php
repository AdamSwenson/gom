<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/12/15
 * Time: 1:19 PM
 */

namespace App\Repositories\Time;


use App\GradingTime;

class GradingTimeRepository implements IGradingTimeRepository
{

    /**
     * Records or updates the time spent grading a particular student's exam
     *
     * @param $examId
     * @param $studentId
     * @param $timeToAdd
     */
    public function update($examId, $studentId, $timeToAdd)
    {
        DB::statement('CALL record_grading_time(:examId, :studentId, :toAdd', ['examId' => $examId, 'studentId' => $studentId, 'toAdd' => $timeToAdd]);
        return $this->load($examId, $studentId);
    }

    /**
     * Loads the time already spent grading a particular student's exam
     * @param $examId
     * @param $studentId
     */
    public function load($examId, $studentId)
    {
        return GradingTime::where('exam_id', $examId)->where('student_id', $studentId)->first();
    }


}