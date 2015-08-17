<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/4/15
 * Time: 7:02 PM
 */

namespace App\Repositories\Score;


use App\Exam;
use Illuminate\Support\Facades\DB;

class ScoreStatisticsRepository
{
    /** @var  Exam */
    protected $exam;
    protected $questionAssignmentDao;
    protected $questionScoreDao;
    protected $elementScoreDao;
    protected $elementAssignmentDao;

    public function __construct()
    {
        $this->questionAssignmentDao = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->elementAssignmentDao = app()->make('App\Repositories\Element\IElementAssignmentRepository');
        $this->questionScoreDao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreDao = app()->make('App\Repositories\Score\IElementScoreRepository');
    }

    /**
     * Gets statistics for question scores
     * @param Exam $exam
     */
    public function getQuestionStatsForExam(Exam $exam)
    {
        $this->exam = $exam;
//       DB::statement('CALL question_score_averages_for_exam(:examId, @questionNumber, @questionName, @average)', ['examId' => $exam->getId()]);
        DB::statement('CALL question_score_averages_for_exam(:examId, questionNumber, questionName, average)', ['examId' => $exam->getId()]);
        $result = DB::select('SELECT questionNumber, questionName, average');
//        $result = DB::select('SELECT @questionNumber AS questionNumber, @questionName AS questionName, @average AS average');
        return $result;


    }


    /**
     * Gets statistics for element scores
     *
     * @param Exam $exam
     */
    public function getElementStatsForExam(Exam $exam)
    {}
}