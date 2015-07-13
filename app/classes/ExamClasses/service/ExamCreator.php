<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 9:38 AM
 */

namespace App\classes\ExamClasses\service;

/**
 * Class ExamCreator
 * Handles creating a new exam from incoming request
 * @package classes\App\classes\ExamClasses\service
 */
class ExamCreator extends ExamServiceParent
{
//    /** @var  $response_handler \App\classes\JsonOutputClasses\controllers\IResponseChooser */
//    public $response_handler;

    /** @var  $restrictor_dao \App\classes\RestrictorClasses\dao\IRestrictorDAO */
    public $restrictor_dao;

    public $current_exam_manager;

    /**
     * @param mixed $current_exam_manager
     */
    public function setCurrentExamManager(\App\classes\ExamClasses\service\CurrentExamManager $current_exam_manager)
    {
        $this->current_exam_manager = $current_exam_manager;
    }

//    /** @var $exam_dao \App\classes\ExamClasses\dao\IExamDAO  */
//    public $exam_dao;
//
//    public function set_response_handler(\App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler)
//    {
//        $this->response_handler = $response_handler;
//    }
//
//    /**
//     * @param \App\classes\ExamClasses\dao\IExamDAO $exam_dao
//     */
//    public function load_exam_dao(\App\classes\ExamClasses\dao\IExamDAO $exam_dao)
//    {
//        $this->exam_dao = $exam_dao;
//    }

    /**
     * @param \App\classes\RestrictorClasses\dao\IRestrictorDAO $restrictor_dao
     */
    public function load_restrictor_dao(\App\classes\RestrictorClasses\dao\IRestrictorDAO $restrictor_dao)
    {
        $this->restrictor_dao = $restrictor_dao;
    }

    /**
     * Handles creating a new exam. Calls response handler and current exam manager
     * to set the new exam as the current one.
     * @param array $incoming
     * @return \Exam
     */
    public function create_exam(array $incoming)
    {
        $year = $this->restrictor_dao->load_year($incoming['year']);
        $term = $this->restrictor_dao->load_term($incoming['term']);
        $topic = $this->restrictor_dao->load_topic($incoming['examTopic']);

        $exam = $this->exam_dao->save_new_exam($year, $term, $topic);
        $cnt = isset($exam) ? 1 : 0;

        if($cnt === 1)
        {
            if(!empty($this->current_exam_manager))
            {
                $this->current_exam_manager->set_current_exam($exam->getId());
            }
        }
        $this->response_handler->handle_row_count($cnt);
        return $exam;
    }
}