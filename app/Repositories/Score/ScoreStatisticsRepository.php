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
    //-------------- Data holders ---------------------------------------------
    /** @var array Means of question assignments (assignmentId as key) */
    public $questionAssignmentMeans = [];

    /** @var array Means of element assignments (assignmentId as key) */
    public $elementAssignmentMeans = [];

    /** @var array|Collection Holds arrays of element score stats objects for the exam. This has
     * elementAssignmentIds as keys. The value for each elementAssignmentId is a stdClass object.
     * This object has the attributes:
     *      elementId
     *      elementAssignmentId,
     *      elementName,
     *      mean,
     *      standardDeviation,
     *      maxScore,
     *      minScore,
     *      numberAnswers
     */
    public $elementAssignmentStats = [];

    /** @var array|Collection Holds arrays of element score stats for the exam. NOT USED */
    public $elementStats = [];

    /** @var array|Collection Holds arrays of question score stats for the exam. */
    public $questionStats = [];

    /** @var array|Collection Holds arrays of question score stats for the exam. This has
     * questionAssignmentIds as keys. The value for each questionAssignmentId is a stdClass object.
     * This object has the attributes:
     *      questionId
     *      questionAssignmentId,
     *      questionNumber
     *      questionName,
     *      mean,
     *      standardDeviation,
     *      maxScore,
     *      minScore,
     *      numberAnswers
     */
    public $questionAssignmentStats = [];

    /** @var  Exam */
    protected $exam;

    //-------------- Repositories ---------------------------------------------
    /** @var  \App\Repositories\Element\IElementScoreRepository */
    protected $elementScoreDao;

    /** @var  \App\Repositories\Element\IElementAssignmentRepository */
    protected $elementAssignmentDao;

    /** @var \App\Repositories\Time\GradingTimeRepository|\App\Repositories\Time\IGradingTimeRepository */
    protected $gradingTimeDao;

    /** @var \App\Repositories\Question\IQuestionAssignmentRepository */
    protected $questionAssignmentDao;

    /** @var  \App\Repositories\Element\IQuestionScoreRepository */
    protected $questionScoreDao;

    public function __construct()
    {
        $this->questionAssignmentDao = app()->make('App\Repositories\Question\IQuestionAssignmentRepository');
        $this->elementAssignmentDao = app()->make('App\Repositories\Element\IElementAssignmentRepository');
        $this->questionScoreDao = app()->make('App\Repositories\Score\IQuestionScoreRepository');
        $this->elementScoreDao = app()->make('App\Repositories\Score\IElementScoreRepository');
        $this->gradingTimeDao = app()->make('App\Repositories\Time\IGradingTimeRepository');
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
     * @param Exam $exam
     * @return \Illuminate\Support\Collection
     */
    public function getScoresAndTimesByGradedOrder(Exam $exam)
    {
        //TODO Add student Id so user can identify anomalies
        $results = [];
        $times = $this->gradingTimeDao->getTimesForExamByGradedOrder($exam->id);
        foreach ($times as $t)
        {
            $totalScore = $this->questionScoreDao->load_total_for_student_on_exam($exam->id, $t->student_id);
            $results[] = [
                "dateTime" => $t->updated_at->toDateTimeString(),
                "totalScore" => $totalScore,
                "seconds" => $t->seconds,
                "studentIdentifier" => $t->student->getStudentId(),
                "studentName" => $t->student->getFullName()
            ];
        }

        return collect($results);
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
        $questionAssignmentId = (string)$questionAssignmentId;

        if (array_key_exists($questionAssignmentId, $this->questionAssignmentMeans))
        {
            return $this->questionAssignmentMeans[$questionAssignmentId];
        } else
        {
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
        if (array_key_exists($elementAssignmentId, $this->elementAssignmentMeans))
        {
            return $this->elementAssignmentMeans[$elementAssignmentId];
        } else
        {
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
    public function getStatsForQuestionAssignment(Exam $exam, $questionAssignmentId, $returnValueOf = null)
    {
        //If the question stats storage is empty, load the data
        if (empty($this->questionStats))
        {
            $this->loadQuestionStatsForExam($exam);
        }

        $result = $this->questionStats->where('question_assignment_id', $questionAssignmentId);

        if (empty($result))
        {
            return null;
        }

        if (!empty($returnValueOf))
        {
            switch ($returnValueOf)
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
    public function getStatsForElementAssignment(Exam $exam, $elementAssignmentId, $returnValueOf = null)
    {
        //If the question stats storage is empty, load the data
        if (empty($this->elementStats))
        {
            $this->loadElementStatsForExam($exam);
        }

        $result = $this->elementStats->where('elementAssignmentId', $elementAssignmentId);

        if (empty($result))
        {
            return null;
        }

        if (!empty($returnValueOf))
        {
            switch ($returnValueOf)
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
        $query = <<<MYSQL
        SELECT DISTINCT qa.question_id AS questionId,
            qa.id AS questionAssignmentId,
            qa.question_number AS questionNumber,
            q.questionName AS questionName,
            AVG(qs.score) AS mean,
            STD(qs.score) AS standardDeviation,
            MAX(qs.score) AS maxScore,
            MIN(qs.score) AS minScore,
            COUNT(qs.score) AS numberAnswers
        FROM question_assignments qa LEFT JOIN question_scores qs ON qa.id = qs.question_assignment_id
        INNER JOIN questions q ON qa.question_id = q.id
        WHERE qa.exam_id = :examId
        GROUP BY qa.id
MYSQL;

        $values = ['examId' => $exam->getId()];
        $results = DB::select($query, $values);

        foreach ($results as $r)
        {
            //calculate the median and add to the results
            $medianResult = $this->getQuestionAssignmentMedian($r->questionAssignmentId);
            $r->median = $medianResult;

            $this->questionAssignmentStats[$r->questionAssignmentId] = $r;
            $this->questionAssignmentMeans[$r->questionAssignmentId] = $r->mean;
        }
        //Make the stored array into a laravel collection
        $this->questionAssignmentStats = collect($this->questionAssignmentStats);
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
            ea.subtask AS subtask,
            qa.question_number AS questionNumber,
            e.elementName AS elementName,
            AVG(es.score) AS mean,
            STD(es.score) AS standardDeviation,
            MAX(es.score) AS maxScore,
            MIN(es.score) AS minScore,
            COUNT(es.score) AS numberAnswers
        FROM element_assignments ea LEFT JOIN element_scores es ON ea.id = es.element_assignment_id
        INNER JOIN elements e ON ea.`element_id` = e.id
        INNER JOIN question_assignments qa ON qa.question_id = ea.question_id
        WHERE ea.exam_id = :examId
        GROUP BY ea.id
MYSQL;

        $values = ['examId' => $exam->getId()];
        $results = DB::select($query, $values);

        foreach ($results as $r)
        {
            $medianResult = $this->getElementAssignmentMedian($r->elementAssignmentId);
            $r->median = $medianResult;

            $quartiles = $this->getElementAssignmentQuartiles($r->elementAssignmentId);
            $r->percentile25 = $quartiles['quartile1'];
            $r->percentile75 = $quartiles['quartile3'];

            $this->elementAssignmentStats[$r->elementAssignmentId] = $r;
            $this->elementAssignmentMeans[$r->elementAssignmentId] = $r->mean;
        }
        //Make the stored array into a laravel collection
        $this->elementAssignmentStats = collect($this->elementAssignmentStats);
    }

    /**
     * Find the median for the element assignment
     *
     * @param $elementAssignmentId
     * @return float
     */
    public function getElementAssignmentMedian($elementAssignmentId)
    {
        //from http://stackoverflow.com/questions/1291152/simple-way-to-calculate-median-with-mysql
        $query = <<<MYSQL
        SELECT AVG(t1.score) AS score FROM (
        SELECT @rownum:=@rownum+1 AS `row_number`, d.score
        FROM element_scores d,  (SELECT @rownum:=0) r
        WHERE element_assignment_id = :elementAssignmentId1
        ORDER BY d.score
        ) AS t1,
        (
            SELECT count(*) AS total_rows
            FROM element_scores d
            WHERE element_assignment_id = :elementAssignmentId2
        ) AS t2
        WHERE 1
        AND t1.row_number IN ( floor((total_rows+1)/2), floor((total_rows+2)/2) )
MYSQL;

        $values = ['elementAssignmentId1' => $elementAssignmentId, 'elementAssignmentId2' => $elementAssignmentId ];
        $result = DB::select($query, $values);

        return $result[0]->score;
    }

    /**
     * Find the median for the question assignment
     *
     * @param $questionAssignmentId
     * @return float
     */
    public function getQuestionAssignmentMedian($questionAssignmentId)
    {
        //from http://stackoverflow.com/questions/1291152/simple-way-to-calculate-median-with-mysql
        $query = <<<MYSQL
        SELECT AVG(t1.score) AS score FROM (
        SELECT @rownum:=@rownum+1 AS `row_number`, d.score
        FROM question_scores d,  (SELECT @rownum:=0) r
        WHERE question_assignment_id = :questionAssignmentId1
        ORDER BY d.score
        ) AS t1,
        (
            SELECT count(*) AS total_rows
            FROM question_scores d
            WHERE question_assignment_id = :questionAssignmentId2
        ) AS t2
        WHERE 1
        AND t1.row_number IN ( floor((total_rows+1)/2), floor((total_rows+2)/2) )
MYSQL;


        $values = ['questionAssignmentId1' => $questionAssignmentId, 'questionAssignmentId2' => $questionAssignmentId ];
        $result = DB::select($query, $values);

        return $result[0]->score;
    }


    /**
     * Calculates the 25th and 75th percentiles for element scores
     * @param $elementAssignmentId
     * @return array Keys quartile1 and quartile3
     */
    public function getElementAssignmentQuartiles($elementAssignmentId){

        //probably first need to do
//        SET @@group_concat_max_len := @@max_allowed_packet;
        //from http://rpbouman.blogspot.com/2008/07/calculating-nth-percentile-in-mysql.html
        $query = <<<MYSQL
        SELECT
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(
            GROUP_CONCAT(score ORDER BY score SEPARATOR ','),
                ',', 25/100 * COUNT(*) + 1), ',', -1) AS DECIMAL) AS `quartile1`,
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(
            GROUP_CONCAT(score ORDER BY score SEPARATOR ','),
            ',', 75/100 * COUNT(*) + 1), ',', -1) AS DECIMAL) AS `quartile3`
        FROM element_scores
        WHERE element_assignment_id = :elementAssignmentId
MYSQL;
//        SELECT
//            CAST(SUBSTRING_INDEX(
//            SUBSTRING_INDEX(
//                GROUP_CONCAT(                 -- 1) make a sorted list of values
//                    f.score
//                    ORDER BY f.score
//                    SEPARATOR ','
//                )
//            ,   ','                           -- 2) cut at the comma
//            ,   25/100 * COUNT(*) + 1         --    at the position beyond the 25% portion
//            )
//        ,   ','                               -- 3) cut at the comma
//        ,   -1                                --    right after the desired list entry
//        ) AS `percentile25`
//        FROM element_scores AS f
//        WHERE f.element_assignment_id = :elementAssignmentId;
//MYSQL;

        $values = ['elementAssignmentId' => $elementAssignmentId];
        $result = DB::select($query, $values);

        return [
            'quartile1' => $result[0]->quartile1,
            'quartile3' => $result[0]->quartile3
        ];
    }



}