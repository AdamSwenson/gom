<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 2:49 PM
 */

namespace App\classes\ExamClasses\service;

/**
 * Class ExamServiceParent
 * Defines some methods shared by exam service classes
 * @package App\classes\ExamClasses\service
 */
abstract class ExamServiceParent
{

    /** @var  $cleaner \App\classes\SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    /** @var  $response_handler \App\classes\JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /** @var $exam_dao \App\classes\ExamClasses\dao\IExamDAO  */
    public $exam_dao;

    /** @var  \Exam */
    protected $exam;

    /**
     * Loads the factory for cleaning
     * @param \App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner
     */
    public function load_cleaner(\App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    /**
     * Loads the class which handles exam db interaction
     * @param \App\classes\ExamClasses\dao\IExamDAO $exam_dao
     */
    public function load_exam_dao(\App\classes\ExamClasses\dao\IExamDAO $exam_dao)
    {
        $this->exam_dao = $exam_dao;
    }

    /**
     * Loads the class which handles json response
     * @param \App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler
     */
    public function set_response_handler(\App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }


    /**
     * Loads the exam from request. Issues failure message if could not
     * find the exam.
     * @param $examid
     */
    public function load_exam($examid)
    {
        $this->exam = \ExamQuery::create()->findOneById($examid);
        if (!$this->exam) {
            $this->response_handler->handle_row_count(0);
            die();
        }
    }


}