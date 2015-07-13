<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 5:04 PM
 */

namespace App\classes\ExamClasses\service;

use Map\PseudoIDTableMap;
use Propel\Runtime\Propel;

/**
 * Class ReleaseManager
 * Handles making exam available to students or removing its availability
 * @package App\classes\ExamClasses\service
 */
class ReleaseManager extends ExamServiceParent implements IExamStatusManager
{

    /** The array key expected for the exam id in a release request */
    const RELEASE_KEY = 'examID';
    /** The array key expected for the exam id in an unrelease request */
    const UNRELEASE_KEY = 'examID';

    /** The task string expected for release operations */
    const RELEASE_TASK = 'releaseExam';

    /** The task string expected for unrelease operations */
    const UNRELEASE_TASK = 'unreleaseExam';

    /** @var  $request \App\classes\RequestClasses\IRequest */
    protected $request;

    /** @var  $pseudoID_manager \App\classes\PseudoIDClasses\service\IManagerFactory */
    protected $pseudoID_manager;

    /**
     * The main publicly called function.
     * @param \App\classes\RequestClasses\IRequest $request
     */
    public function execute(\App\classes\RequestClasses\IRequest $request)
    {
        $this->request = $request;
        $this->choose();
    }

    /**
     * Determines which actions to take based on the incoming request
     */
    protected function choose()
    {
        switch ($this->request->task()) {
            case self::UNRELEASE_TASK:
                if (isset($this->request->http[self::UNRELEASE_KEY])) {
                    $examid = $this->request->http[self::UNRELEASE_KEY];
                    $this->unrelease($examid);
                }
                break;
            case self::RELEASE_TASK:
                if (isset($this->request->http[self::RELEASE_KEY])) {
                    $examid = $this->request->http[self::RELEASE_KEY];
                    $this->release($examid);
                }
                break;
            default:
                $this->response_handler->handle_row_count(0);
        }
    }

    /**
     * Carry out the release. This involves making temporary ids for each
     * student and then marking the exam released.
     * TODO: Add operations on users table
     * TODO ensure error logging on failure
     * @param $examid int
     */
    protected function release($examid)
    {
        $this->load_exam($examid);
        $conn = Propel::getWriteConnection(PseudoIDTableMap::DATABASE_NAME);
        try {
            $this->pseudoID_manager->create_pseudoIDs($conn, $this->exam);
            $this->exam_dao->set_connection($conn);
            $result = $this->exam_dao->mark_exam_released($this->exam);
            $conn->commit();
            $this->respond($result);
        } catch (\Exception $e) {
            $conn->rollBack();
            $this->response_handler->handle_row_count(0);
        }
    }

    /**
     * Remove temporary ids and mark the exam unreleased
     * TODO: Add operations on users table
     * TODO ensure error logging on failure
     * @param $examid int
     */
    protected function unrelease($examid)
    {
        $this->load_exam($examid);
        $conn = Propel::getWriteConnection(PseudoIDTableMap::DATABASE_NAME);
        try {
            $this->pseudoID_manager->remove_pseudoIDs($conn, $this->exam);
            $this->exam_dao->set_connection($conn);
            $result = $this->exam_dao->unmark_exam_released($this->exam);
            $conn->commit();
            $this->respond($result);
        } catch (\Exception $e) {
            $conn->rollBack();
            $this->response_handler->handle_row_count(0);
        }
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
     * Loads the object which handles pseudoID operations
     * @param \App\classes\PseudoIDClasses\service\IManagerFactory $pseudoID_manager
     */
    public function set_pseudoID_manager(\App\classes\PseudoIDClasses\service\IManagerFactory $pseudoID_manager)
    {
        $this->pseudoID_manager = $pseudoID_manager;
    }

}