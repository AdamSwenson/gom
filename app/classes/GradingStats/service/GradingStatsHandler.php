<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 5:35 PM
 */

namespace App\classes\GradingStats\service;


use App\classes\ExamClasses\service\INumberExamsManager;
use App\classes\GradingStats\dao\IGradingStatsDAO;
use App\classes\GradingStats\service\StatsDataHolder;
use App\classes\JsonOutputClasses\controllers\IResponseChooser;

class GradingStatsHandler
{
    public $data_holder;

    /** @var  $dao IGradingStatsDAO */
    public $dao;

    /** @var  $response_handler IResponseChooser */
    public $response_handler;

    /**
     * @param IResponseChooser $response_handler
     */
    public function set_response_handler(IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    /**
     * @param IGradingStatsDAO $gradingStatsDAO
     */
    public function set_dao(IGradingStatsDAO $gradingStatsDAO)
    {
        $this->dao = $gradingStatsDAO;
    }

    public function set_number_exams(INumberExamsManager $num_exam_manager)
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
        $this->data_holder = new StatsDataHolder();
    }
}