<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 9:23 AM
 */

namespace TimerClasses;

use App\classes\JsonOutputClasses\controllers\IResponseChooser;
use classes\TimerClasses\dao\TimerDao;

/**
 * Class GroupTimerHandler
 * Loads and updates group time.
 * Sends results via response_handler
 *
 * @todo Refactor this and exam handler to simplify and share tasks
 * @package TimerClasses
 */
class GroupTimerHandler
{
    public $dao;

    /** @var $time_handler \GroupTime */
    public $time_handler;

    /** @var  $response_handler IResponseChooser */
    public $response_handler;

    public function __construct()
    {
        $this->dao = new TimerDao();
    }

    /**
     * @param IResponseChooser $response_handler
     */
    public function set_response_handler(IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    /**
     * Loads and sends time for the group
     * @param \Exam $exam
     * @param $groupID
     * @return \GroupTime
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function get(\Exam $exam, $groupID)
    {
        $this->load($exam, $groupID);
        $this->format_and_send();
    }

    /**
     * Updates group time
     * @param \Exam $exam
     * @param $groupID
     * @param $seconds
     * @return \GroupTime
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(\Exam $exam, $groupID, $seconds)
    {
        $this->load($exam, $groupID);
        $time = $this->time_handler->getSeconds();
        $time += $seconds;
        $this->time_handler->setSeconds($time);
        $this->time_handler->save();
        $this->format_and_send();
        return $this->time_handler;
    }

    protected function format_and_send()
    {
        if(isset($this->time_handler))
        {
            $r = array('groupID' => $this->time_handler->getGroupid(), 'time' => $this->time_handler->getSeconds());
            $this->response_handler->handle_response($r);
        } else
        {
            $this->response_handler->handle_row_count(0);
        }
    }

    /**
     * Loads and returns a GroupTime object
     * @param \Exam $exam
     * @param $groupID
     * @return \GroupTime
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function load(\Exam $exam, $groupID)
    {
        $this->time_handler = $this->dao->loadGroupTime($exam, $groupID);
//        $this->time_handler = \GroupTimeQuery::create()
//            ->filterByExam($exam)
//            ->filterByGroupid($groupID)
//            ->findOneOrCreate();
//        $this->time_handler->save();

        return $this->time_handler;
    }


}