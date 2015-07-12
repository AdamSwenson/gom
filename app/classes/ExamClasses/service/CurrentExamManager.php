<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 10:44 AM
 */

namespace ExamClasses\service;

/**
 * Class CurrentExamManager
 * handles storing current exam in session and retrieving
 * from session
 * @package ExamClasses\service
 */
class CurrentExamManager {

    protected function load_exam($examID)
    {
        return \ExamQuery::create()
            ->filterById($examID)
            ->findOne();
    }

    public function get_current_exam(){
        if (isset($_SESSION) && isset($_SESSION['examID'])){
            return $this->load_exam($_SESSION['examID']);
//            return \ExamQuery::create()->filterById($_SESSION['examID'])->findOne();
        }
        else{
            return FALSE;
        }
    }

    /**
     * Sets an exam as the current one
     * @param $examID
     * @return bool
     */
    public function set_current_exam($examID)
    {
        $exam = $this->load_exam($examID);
        if($exam){
            $_SESSION['examID'] = $exam->getId();
            return $exam;
        }
        else{
            return FALSE;
        }
    }

}