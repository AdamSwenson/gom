<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 2:43 PM
 */

namespace App\classes\ExamClasses\service;


class LockManagerTest extends \PHPUnit_Framework_TestCase {

    protected $object;
public $request;
    public $examdao;
    public $response_handler;
    protected function setUp()
    {
        parent::setUp();
        $this->object = new LockManager();
        $this->examdao = new \App\classes\ExamClasses\dao\IExamDAOMock();
        $this->request = new \App\classes\RequestClasses\IRequestMock();
        $this->response_handler = new \App\classes\JsonOutputClasses\controllers\IResponseChooserMock();
        $this->object->set_response_handler($this->response_handler);
        $this->object->load_exam_dao($this->examdao);
    }

    /**
     * @covers \App\classes\ExamClasses\service\LockManager::execute
     */
    public function testExecute_lock()
    {
        $this->request->http = array('task' => \App\classes\ExamClasses\service\LockManager::LOCK_TASK, \App\classes\ExamClasses\service\LockManager::LOCK_KEY => 5);
        $this->request->set_response('lockExam');
        $this->examdao->set_response(TRUE);
        $this->object->execute($this->request);

        $this->assertEquals('lock_exam', $this->examdao->called);
        $this->assertEquals(count($this->response_handler->called_list), 1);
        $this->assertEquals('handle_row_count', $this->response_handler->called);
    }

    /**
     * @covers \App\classes\ExamClasses\service\LockManager::execute
     */
    public function testExecute_unlock()
    {
        $this->request->http = array('task' => \App\classes\ExamClasses\service\LockManager::UNLOCK_TASK, \App\classes\ExamClasses\service\LockManager::UNLOCK_KEY => 5);
        $this->request->set_response('unlockExam');
        $this->object->execute($this->request);
        //$this->assertEquals(1, count($this->examdao->called_list));
        $this->assertEquals('unlock_exam', $this->examdao->called);
        $this->assertEquals(count($this->response_handler->called_list), 1);
        $this->assertEquals('handle_row_count', $this->response_handler->called);
    }


}
