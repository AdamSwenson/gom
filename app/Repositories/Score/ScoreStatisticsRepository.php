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

/**
 * This handles calculating statistics on scores.
 * On the first call for an exam, it will load the stats and hold them internally for subsequent calls
 *
 * @package App\Repositories\Score
 */
class ScoreStatisticsRepository implements IScoreStatisticsRepository
{
    /** One of the types of statistical values that can be requested */
    const STAT_MEAN = 'mean';

    /** One of the types of statistical values that can be requested */
    const STAT_MODE = 'mode';

    /** One of the types of statistical values that can be requested */
    const STAT_MEDIAN = 'median';

    public $questionAssignmentMeans = [];
    public $elementAssignmentMeans = [];


    /** @var  Exam */
    protected $exam;

    /** @var \App\Repositories\Question\IQuestionAssignmentRepository */
    protected $questionAssignmentDao;

    /** @var  \App\Repositories\Element\IQuestionScoreRepository */
    protected $questionScoreDao;

    /** @var  \App\Repositories\Element\IElementScoreRepository */
    protected $elementScoreDao;

    /** @var  \App\Repositories\Element\IElementAssignmentRepository */
    protected $elementAssignmentDao;

    /** @var array|Collection Holds arrays of element score stats for the exam. */
    public $elementStats = [];

    /** @var array|Collection Holds arrays of question score stats for the exam. */
    public $questionStats = [];

    public function __construct()
    {
        $this->questionAssignmentDao = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->elementAssignmentDao = app()->make('App\Repositories\Element\IElementAssignmentRepository');
        $this->questionScoreDao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreDao = app()->make('App\Repositories\Score\IElementScoreRepository');
    }

    /**
     * Loads question and element stats for an exam
     * @param Exam $exam
     */
    public function loadStats(Exam $exam)
    {
        $this->loadElementStatsForExam($exam);
        $this->loadQuestionStatsForExam($exam);
    }

    /**
     * Retrieves the mean for a given question assignment.
     * That is, the mean for a question on an exam.
     *
     * @param $questionAssignmentId
     * @return null|float
     */
    public function getQuestionAssignmentMean($questionAssignmentId)
    {
        if( array_key_exists($questionAssignmentId, $this->questionAssignmentMeans) )
        {
            return $this->questionAssignmentMeans[$questionAssignmentId];
        }
        else{
            return null;
        }
    }

    /**
     * Retrieves the mean for a given element assignment.
     * That is, the mean for an element on one exam.
     * @param $elementAssignmentId
     * @return null|float
     */
    public function getElementAssignmentMean($elementAssignmentId)
    {
        if( array_key_exists($elementAssignmentId, $this->elementAssignmentMeans) )
        {
            return $this->elementAssignmentMeans[$elementAssignmentId];
        }
        else{
            return null;
        }
    }

    /**
     * Returns an array of statistical information or the specified value
     * @param Exam $exam
     * @param $questionAssignmentId
     * @param null $returnValueOf
     * @return float|\Illuminate\Support\Collection|null
     * @internal param $question_assignment_id
     */
    public function getStatsForQuestionAssignment(Exam $exam, $questionAssignmentId, $returnValueOf=null)
    {
        //If the question stats storage is empty, load the data
        if( empty($this->questionStats) ){ $this->loadQuestionStatsForExam($exam); }

        $result = $this->questionStats->where('question_assignment_id', $questionAssignmentId);

        if( empty($result )) return null;

        if( ! empty($returnValueOf) )
        {
            switch($returnValueOf)
            {
                case self::STAT_MEAN:
                    return $result[0]['mean'];
                break;

                default:
                    return null;
            }
        }

        //If a specific value wasn't specified, return the whole array
        return $result;
    }



    /**
     * Returns an array of statistical information or the specified value
     * @param Exam $exam
     * @param $elementAssignmentId
     * @param null $returnValueOf
     * @return float|\Illuminate\Support\Collection|null
     * @internal param $element_assignment_id
     */
    public function getStatsForElementAssignment(Exam $exam, $elementAssignmentId, $returnValueOf=null)
    {
        //If the question stats storage is empty, load the data
        if( empty($this->elementStats) ){ $this->loadElementStatsForExam($exam); }

        $result = $this->elementStats->where('elementAssignmentId', $elementAssignmentId);

        if( empty($result )) return null;

        if( ! empty($returnValueOf) )
        {
            switch($returnValueOf)
            {
                case self::STAT_MEAN:
                    return $result[0]['mean'];
                    break;

                default:
                    return null;
            }
        }

        //If a specific value wasn't specified, return the whole array
        return $result;
    }


    /**
     * Gets statistics for question scores
     * @param Exam $exam
     */
    protected function loadQuestionStatsForExam(Exam $exam)
    {
        //Clear these values
        $this->exam = $exam;
        $this->questionStats = [];

        $query = <<<MYSQL
        SELECT DISTINCT qa.question_id AS questionId,
        qa.id AS questionAssignmentId,
        AVG(qs.score) AS mean
        FROM question_assignments qa LEFT JOIN question_scores qs ON qa.id = qs.question_assignment_id
        WHERE qa.exam_id = :examId
        GROUP BY qa.id
MYSQL;

        /*
         * Updated for newer mysql
        $query = <<<MYSQL
        SELECT DISTINCT qa.question_id AS questionId, qa.id AS questionAssignmentId, AVG(qs.score) AS mean
        FROM question_assignments qa LEFT JOIN question_scores qs ON qa.id = qs.question_assignment_id
        WHERE qa.exam_id = :examId
        GROUP BY question_assignment_id;
MYSQL;
        */
        $values = ['examId' => $exam->getId()];
        $results = DB::select($query, $values);

        foreach($results as $r)
        {
            $this->questionAssignmentMeans[$r->questionAssignmentId] = $r->mean;
        }

//
//        //Load question assignments
//        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());
//
//        //Load stats for each question assignment
//        foreach($questionAssignments as $qa)
//        {
//            $result = DB::select('SELECT AVG(score) AS mean FROM question_scores WHERE question_assignment_id = :assignId', ['assignId' => $qa->id]);
//            if ( !empty($result) )
//            {
//                $this->questionStats[] = [
//                    'questionAssignmentId' => $qa->getId(),
//                    'questionId' => $qa->getQuestion()->getId(),
//                    'mean' => $result[0]->mean
//                ];
//            }
//            else{
//                $this->questionStats[] = [
//                    'questionAssignmentId' => $qa->getId(),
//                    'questionId' => $qa->getQuestion()->getId(),
//                    'mean' => null
//                ];
//            }
//        }

        //Make the stored array into a laravel collection
      //  $this->questionStats = collect($this->questionStats);

////       DB::statement('CALL question_score_averages_for_exam(:examId, @questionNumber, @questionName, @average)', ['examId' => $exam->getId()]);
//        DB::statement('CALL question_score_averages_for_exam(:examId, questionNumber, questionName, average)', ['examId' => $exam->getId()]);
//        $result = DB::select('SELECT questionNumber, questionName, average');
////        $result = DB::select('SELECT @questionNumber AS questionNumber, @questionName AS questionName, @average AS average');
//        return $result;
    }


    /**
     * Loads statistics for element scores into internally held collection
     * Clears out any previously stored values first
     * @param Exam $exam
     */
    protected function loadElementStatsForExam(Exam $exam)
    {

        $query = <<<MYSQL
        SELECT DISTINCT ea.element_id AS elementId,
            ea.id AS elementAssignmentId,
            AVG(es.score) AS mean
        FROM element_assignments ea LEFT JOIN element_scores es ON ea.id = es.element_assignment_id
        WHERE ea.exam_id = :examId
        GROUP BY ea.id
MYSQL;

/*
 * Replacing to deal with mysql 5.7 problem
        $query = <<<MYSQL
        SELECT DISTINCT ea.element_id AS elementId,
            ea.id AS elementAssignmentId,
            AVG(es.score) AS mean
        FROM element_assignments ea LEFT JOIN element_scores es ON ea.id = es.element_assignment_id
        WHERE ea.exam_id = :examId GROUP BY element_assignment_id;
MYSQL;
*/
        $values = ['examId' => $exam->getId()];
        $results = DB::select($query, $values);

        foreach($results as $r)
        {
            $this->elementAssignmentMeans[$r->elementAssignmentId] = $r->mean;
        }

//
//        //Reset these values
//        $this->exam = $exam;
//        $this->elementStats = [];
//
//        //Load the element assignments
//        $elementAssignments = $this->elementAssignmentDao->load_by_exam($exam->getId());
//
//        //Populate the elementStats with stats
//        foreach($elementAssignments as $ea)
//        {
//            $result = DB::select('SELECT AVG(score) AS mean FROM element_scores WHERE element_assignment_id = :assignId', ['assignId' => $ea->id]);
//            if ( !empty($result) )
//            {
//                $this->elementStats[] = [
//                    'elementAssignmentId' => $ea->getId(),
//                    'elementId' => $ea->getElementId(),
//                    'mean' => $result[0]->mean
//                ];
//            }
//            else{
//                $this->elementStats[] = [
//                    'elementAssignmentId' => $ea->getId(),
//                    'elementId' => $ea->getElementId(),
//                    'mean' => null
//                ];
//            }
//        }

        //Make the stored array into a laravel collection
//        $this->elementStats = collect($this->elementStats);
    }
}