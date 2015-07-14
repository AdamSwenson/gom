<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 5:06 PM
 */

namespace App\classes\ExamClasses\service;


class ReleaseManagerTest extends \PHPUnit_Framework_TestCase {

    public $manager_factory;
    protected $object;
    public $request;
    public $examdao;
    public $response_handler;

    protected function setUp()
    {
        parent::setUp();
        $this->object = new ReleaseManager();
        $this->examdao = new \App\classes\ExamClasses\dao\IExamDAOMock();
        $this->request = new \App\classes\RequestClasses\IRequestMock();
        $this->response_handler = new \App\classes\JsonOutputClasses\controllers\IResponseChooserMock();
        $this->manager_factory = new \App\classes\PseudoIDClasses\service\IManagerFactoryMock();
        $this->object->set_response_handler($this->response_handler);
        $this->object->load_exam_dao($this->examdao);
    }

    /**
     * @covers App\classes\ExamClasses\service\ReleaseManager::execute
     * @covers App\classes\ExamClasses\service\ReleaseManager::release
     * @covers App\classes\ExamClasses\service\ReleaseManager::choose
     * @covers App\classes\ExamClasses\service\ReleaseManager::respond
     */
    public function testExecute_release(){
        $this->object->set_pseudoID_manager($this->manager_factory);
        $this->request->http = array('task' => ReleaseManager::RELEASE_TASK, ReleaseManager::RELEASE_KEY => 5);
        $this->request->set_response(ReleaseManager::RELEASE_TASK);
        $this->examdao->set_response(TRUE);
        $this->object->execute($this->request);

        $this->assertContains('create_pseudoIDs', $this->manager_factory->called);
        $this->assertContains('mark_exam_released', $this->examdao->called);
        $this->assertEquals(count($this->response_handler->called_list), 1);
        $this->assertEquals('handle_row_count', $this->response_handler->called);
    }

    /**
     * @covers App\classes\ExamClasses\service\ReleaseManager::execute
     * @covers App\classes\ExamClasses\service\ReleaseManager::unrelease
     * @covers App\classes\ExamClasses\service\ReleaseManager::choose
     * @covers App\classes\ExamClasses\service\ReleaseManager::respond
     */
    public function testExecute_unrelease()
    {
        $this->object->set_pseudoID_manager($this->manager_factory);
        $this->request->http = array('task' => ReleaseManager::UNRELEASE_TASK, ReleaseManager::UNRELEASE_KEY => 5);
        $this->request->set_response(ReleaseManager::UNRELEASE_TASK);
        $this->object->execute($this->request);

        $this->assertContains('remove_pseudoIDs', $this->manager_factory->called);
        $this->assertEquals(count($this->examdao->called_list), 1);
        $this->assertContains('unmark_exam_released', $this->examdao->called);
        $this->assertEquals(count($this->response_handler->called_list), 1);
        $this->assertEquals('handle_row_count', $this->response_handler->called);
    }


    /**
     * @covers App\classes\ExamClasses\service\ReleaseManager::set_pseudoID_manager
     */
    public function testSet_pseudoID_manager()
    {
        $this->object->set_pseudoID_manager($this->manager_factory);
        $this->assertAttributeInstanceOf('\App\classes\PseudoIDClasses\service\IManagerFactory', 'pseudoID_manager', $this->object);
    }

}
