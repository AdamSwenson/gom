<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 2:39 PM
 */

namespace App\classes\ExamClasses\service;

/**
 * Class LockManager
 * This handles locking and unlocking an exam.
 *
 * @package App\classes\ExamClasses\service
 */
class LockManager extends ExamServiceParent implements IExamStatusManager
{

    /** The array key expected for the exam id in a lock request */
    const UNLOCK_KEY = 'examID';

    /** The array key expected for the exam id in an unlock request */
    const LOCK_KEY = 'examID';

    /** The task string expected for lock operations */
    const LOCK_TASK = 'lockExam';

    /** The task string expected for unlock operations */
    const UNLOCK_TASK = 'unlockExam';

    /** @var  $request \App\classes\RequestClasses\IRequest */
    protected $request;

//    /** @var  $dao \App\classes\ExamClasses\dao\IExamDAO */
//    public $dao;
//
//    /** @var  $response_handler \App\classes\JsonOutputClasses\controllers\IResponseChooser */
//    public $response_handler;
//
//    /**
//     * @param \App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler
//     */
//    public function set_response_handler(\App\classes\JsonOutputClasses\controllers\IResponseChooser $response_handler)
//    {
//        $this->response_handler = $response_handler;
//    }
//
//    public function load_exam_dao(\App\classes\ExamClasses\dao\IExamDAO $exam_dao)
//    {
//        $this->dao = $exam_dao;
//    }


    protected function choose()
    {
        switch ($this->request->task()) {
            case self::UNLOCK_TASK:
                if (isset($this->request->http[self::UNLOCK_KEY])) {
                    $examid = $this->request->http[self::UNLOCK_KEY];
                    $this->unlock($examid);
                }
                break;
            case self::LOCK_TASK:
                if (isset($this->request->http[self::LOCK_KEY])) {
                    $examid = $this->request->http[self::LOCK_KEY];
                    $this->lock($examid);
                }
                break;
            default:
                $this->response_handler->handle_row_count(0);
        }
    }

    /**
     * Carry out the lock
     * @param $examid int
     */
    protected function lock($examid)
    {
        $this->load_exam($examid);
        $result = $this->exam_dao->lock_exam($this->exam);
        $this->respond($result);
    }

    /**
     * Carry out the unlock
     * @param $examid int
     */
    protected function unlock($examid)
    {
        $this->load_exam($examid);
        $result = $this->exam_dao->unlock_exam($this->exam);
        $this->respond($result);
    }

    /**
     * Checks whether the lock or unlock attempt returned a result and
     * then calls the response handler accordingly.
     * @param $result Boolean
     */
    protected function respond($result)
    {
        if ($result) {
            $this->response_handler->handle_row_count(1);
        } else {
            $this->response_handler->handle_row_count(0);
        }
    }

    /**
     * Lock or unlock an exam from a post request
     * @param \App\classes\RequestClasses\IRequest $request
     */
    public function execute(\App\classes\RequestClasses\IRequest $request)
    {
        $this->request = $request;
        $this->choose();
    }


}