<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 5:35 PM
 */

namespace App\classes\GradingStats\service;


class GradingStatsHandler
{
    public $data_holder;

    /** @var  $dao \App\classes\GradingStats\dao\IGradingStatsDAO */
    public $dao;

    /** @var  $response_handler \App\classes\JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /**
     * @param \App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler
     */
    public function set_response_handler(\App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    /**
     * @param \App\classes\GradingStats\dao\IGradingStatsDAO $gradingStatsDAO
     */
    public function set_dao(\App\classes\GradingStats\dao\IGradingStatsDAO $gradingStatsDAO)
    {
        $this->dao = $gradingStatsDAO;
    }

    public function set_number_exams(\App\classes\ExamClasses\service\INumberExamsManager $num_exam_manager)
    {
        $this->dao->set_number_exams($num_exam_manager);
    }

    public function get_all(\Exam $exam)
    {
        $this->load_data_holder();
        $this->data_holder->load_from_array($this->dao->get_percentage_complete());
        $this->data_holder->load_from_array($this->dao->getPagesPerMinute(10));
        $this->response_handler->handle_response($this->data_holder->return_array());
    }

    public function load_data_holder()
    {
        $this->data_holder = new \App\classes\GradingStats\service\StatsDataHolder();
    }
}