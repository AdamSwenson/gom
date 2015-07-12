<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 4:40 PM
 */

namespace GradingStats\dao;

/**
 * Class GradingStatsDAO
 * This handles all database requests for statistical features of the dashboard
 *
 * @author adam
 * @package GradingStats\dao
 */
class GradingStatsDAO implements IGradingStatsDAO
{

    /** @var $exam \Exam Holds the \Exam object */
    protected $exam;

    const DEFAULT_LIMIT = 10;

    /** @var  $total_exams Total number of exams to grade  */
    public $total_exams;

    public function set_number_exams(\ExamClasses\service\INumberExamsManager $num_exam_manager)
    {
        $this->total_exams = $num_exam_manager->get_number_exams();
    }

    public function set_exam(\Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * Gets the pages divided by time of the past exams
     * @param  int   $limit
     * @return array
     */
    public function getPagesPerMinute($limit)
    {
        $ei = \ExamInfoQuery::create()->filterByExam($this->exam)->orderByUpdatedAt()->joinWith('time_grading.seconds')->find();
        foreach($ei as $e){
//            $e->getPages() / $e->g
        }
//        (is_numeric($limit) ? $slimit = $limit : $slimit = self::DEFAULT_LIMIT );
//        $this->query = "SELECT go.gradedOrder, ROUND(ei.pages/(gt.seconds/60), 2) AS ppm
//                FROM gradingTime gt INNER JOIN examInfo ei ON gt.examID = ei.examID AND gt.sid = ei.sid
//                INNER JOIN gradedOrder go ON go.examID = ei.examID AND go.sid = ei.sid
//                WHERE ei.examID = :examID
//                ORDER BY go.gradedOrder DESC
//                LIMIT $slimit";
////            $this->query = "SELECT gradedOrder, ROUND(pages/(seconds/60), 2) AS ppm FROM gradingTime NATURAL JOIN examInfo NATURAL JOIN gradedOrder
////                            WHERE examID = :examID
////                            ORDER BY gradedOrder DESC
////                            LIMIT $limit";
////            $this->query = "SELECT gradedOrder, ROUND(pages/(gradingTime/60), 2) AS ppm FROM examInfo NATURAL JOIN gradedOrder
////                            WHERE examID = :examID
////                            ORDER BY gradedOrder DESC
////                            LIMIT $limit";
//        $this->vals = array('examID' => $this->exam->displayID());
//        $this->returnAssocAll();
//
//        return $this->resultAssoc;
//        } else {
//            throw \Exception('Non numeric limit passed to grading_speed');
//        }
    }

    public function getCalcluatedTimeStats()
    {
        $this->query = "CALL grading_stats(:examID, :total_exams, @AveragePPM, @totalGraded, @remainingExams, @gradeRemaining, @gradeElapsed, @workElapsed, @workRemaining)";
        $this->vals = array('examID' => $this->exam->displayID(), 'total_exams' => $this->total_exams->getProperty());
        $this->returnAssocFirst();

        return $this->resultAssoc;
    }

    /**
     * Calculates the percentage complete
     * @return array Associative array with keys examsGraded, examsUngraded, pctComplete
     */
    public function getPercentageComplete()
    {
        $graded_exams = \ExamInfoQuery::create()->filterByExam($this->exam)->count();
        $ungraded = $this->total_exams - $graded_exams;
        $pct_complete = $graded_exams / $this->total_exams;
        return array('examsGraded' => $graded_exams, 'examsUngraded' => $ungraded, 'pctComplete' => $pct_complete);
    }

}