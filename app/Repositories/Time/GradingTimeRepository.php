<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/12/15
 * Time: 1:19 PM
 */

namespace App\Repositories\Time;


use App\GradingTime;
use Illuminate\Support\Collection;

class GradingTimeRepository implements IGradingTimeRepository
{
    /**
     * Loads the time already spent grade a particular student's exam
     * @param $examId
     * @param $studentId
     */
    public function load($examId, $studentId)
    {
        return GradingTime::where('exam_id', $examId)->where('student_id', $studentId)->first();
    }

    /**
     * Records a total grade time in the database. If a time already exists for the student, this will overwrite it.
     * If you instead want to add the time to the preexisting time, use GradingTimeRepository::update()
     *
     * @param integer $examId
     * @param integer $studentId
     * @param float $totalGradingTime
     */
    public function record($examId, $studentId, $totalGradingTime)
    {
        \DB::statement('CALL record_grading_time(:examId, :studentId, :gradingTime)', ['examId' => $examId, 'studentId' => $studentId, 'gradingTime' => $totalGradingTime]);
        return $this->load($examId, $studentId);
    }

    /**
     * Adds an interval in seconds to the time spent grade a particular student's exam
     *
     * @param integer $examId
     * @param integer $studentId
     * @param float $timeToAdd
     */
    public function update($examId, $studentId, $timeToAdd)
    {
        \DB::statement('CALL record_grading_time(:examId, :studentId, :toAdd)', ['examId' => $examId, 'studentId' => $studentId, 'toAdd' => $timeToAdd]);
        return $this->load($examId, $studentId);
    }


    /**
     * Returns a collection of gradingTime objects for the exam
     * in the order that the students were graded.
     * @param integer $examId
     * @return Collection|null
     */
    public function getTimesForExamByGradedOrder($examId)
    {
        return GradingTime::where('exam_id', $examId)->orderBy('updated_at')->get();
    }



}