<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/4/15
 * Time: 4:22 PM
 */

namespace App\classes\TimerClasses;

use App\classes\JsonOutputClasses\controllers\IResponseChooser;
use classes\TimerClasses\dao\TimerDao;

/**
 * Class ExamTimerHandler
 * Handles interaction with exam time db
 *
 * @package classes\TimerClasses
 */
class ExamTimerHandler
{
    public $dao;

    /** @var $time_handler \GradingTime */
    public $time_handler;

    /** @var  $response_handler IResponseChooser */
    public $response_handler;

    /**
     * @param IResponseChooser $response_handler
     */
    public function set_response_handler(IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    public function __construct()
    {
     $this->dao = new TimerDao();
    }

    /**
     * Loads and sends time for the group
     * @param \Exam $exam
     * @param \Student $student
     */
    public function get(\Exam $exam, \Student $student)
    {
        $this->load($exam, $student);
        $this->format_and_send();
    }

    /**
     * Updates the grading time of a student exam
     * @param \Exam $exam
     * @param \Student $student
     * @param $seconds
     * @return \GradingTime
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, \Student $student, $seconds)
    {
        $this->load($exam, $student);
        $time = $this->time_handler->getSeconds();
        $time += $seconds;
        $this->time_handler->setSeconds($time);
        $this->time_handler->save();
        $this->format_and_send();
        return $this->time_handler;
    }


    /**
     * Builds the json expected by javascript
     */
    protected function format_and_send()
    {
        if(isset($this->time_handler))
        {
            $r = array('time' => $this->time_handler->getSeconds());
            $this->response_handler->handle_response($r);
        } else
        {
            $this->response_handler->handle_row_count(0);
        }
    }

    /**
     * Loads a grading time object
     * @param \Exam $exam
     * @param \Student $student
     * @return \GradingTime
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function load(\Exam $exam, \Student $student)
    {
        $this->time_handler =  $this->dao->loadGradingTime($exam, $student);
        //\GradingTimeQuery::create()->filterByExam($exam)->filterByStudent($student)->findOneOrCreate();
        return $this->time_handler;
    }


}