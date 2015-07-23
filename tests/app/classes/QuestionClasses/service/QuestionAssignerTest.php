<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 1:02 PM
 */

namespace App\classes\QuestionClasses\service;


class QuestionAssignerTest extends \TestCase
{
    public $object;
    public $questiondao;
    public $assignerdao;
    public $response_handler;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionAssigner();
        $this->questiondao = new \App\classes\QuestionClasses\dao\IQuestionDAOMock();
        $this->assignerdao = new \App\classes\QuestionClasses\dao\IQuestionAssignmentDAOMock();
        $this->response_handler = new \App\classes\JsonOutputClasses\controllers\IResponseChooserMock();
    }

    public function testSet_response_handler()
    {
        $this->object->set_response_handler($this->response_handler);
        $this->assertAttributeInstanceOf('\App\classes\JsonOutputClasses\controllers\IResponseChooser', 'response_handler', $this->object);
    }

    public function testSet_question_assigner_dao()
    {
        $this->object->set_question_assigner_dao($this->assignerdao);
        $this->assertAttributeInstanceOf('\App\classes\QuestionClasses\dao\IQuestionAssignmentDAO', 'question_assigner_dao', $this->object);
    }

    public function testSet_question_dao()
    {
        $this->object->set_question_dao($this->questiondao);
        $this->assertAttributeInstanceOf('\App\classes\QuestionClasses\dao\IQuestionDAO', 'question_dao', $this->object);
    }

    /**
     * @covers \App\classes\QuestionClasses\service\QuestionAssigner::record
     */
    public function testRecord()
    {
        $exam = new \Exam();
        $test = array(array('questionText' => 'sample question text', 'questionNumber' => 4));
        $q = new \Question();
        $q->setQuestiontext($test[0]['questionText']);
        $this->questiondao->set_response($q);
//        $questiondao = new \classes\TestingDecorator($this->questiondao);
        $this->object->set_question_dao($this->questiondao);
        $this->object->set_question_assigner_dao($this->assignerdao);

        $this->object->record($exam, $test);

        $this->assertEquals('get_question_from_array', $this->questiondao->called);
        $this->assertEquals($test, $this->questiondao->arguments);

        $this->assertEquals('record', $this->assignerdao->called);
        $this->assertEquals($exam, $this->assignerdao->arguments[0]);
        $this->assertEquals($q, $this->assignerdao->arguments[1]);
        $this->assertEquals($test[0]['questionNumber'], $this->assignerdao->arguments[2]);
    }


}
