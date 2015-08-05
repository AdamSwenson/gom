<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/4/15
 * Time: 7:02 PM
 */

namespace Repositories\Score;


use App\Exam;

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
    }


    /**
     * Gets statistics for element scores
     *
     * @param Exam $exam
     */
    public function getElementStatsForExam(Exam $exam)
    {}
}