<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/21/15
 * Time: 12:11 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\RequestHandlers\dao\IQuestionAssignmentDAOMock;
use App\classes\RequestHandlers\dao\IQuestionDAOMock;
use App\Exam;
use App\Question;

class QuestionWorkerTest extends \TestCase
{

    protected $object;
public $assignmentDao;
    public $dao;

    public function setUp()
    {
        parent::setUp();
        $this->exam = Exam::all()->random();
        $this->object = new QuestionWorker;
        $this->dao = new IQuestionDAOMock();
        $this->assignmentDao = new IQuestionAssignmentDAOMock();
        $this->object->dao = $this->dao;
        $this->object->assignmentDao = $this->assignmentDao;
    }


    public function testGetQuestion()
    {
        $questionId = $this->faker->randomNumber(3);
        $this->object->getQuestion($questionId);

        $this->assertEquals('loadQuestionById', $this->dao->called);
        $this->assertEquals($questionId, $this->dao->calledList[0][1][0]);
    }


    public function testGetAllQuestions()
    {
        $this->object->getAllQuestions();
        $this->assertEquals('loadAll', $this->dao->called);
    }

    public function testGetAllQuestionsWithClassId()
    {
        $classId = 34;
        $this->object->getAllQuestions($classId);
        $this->assertEquals('loadQuestionsByClassId', $this->dao->called);
        $this->assertEquals($classId, $this->dao->calledList[0][1][0]);
    }


    public function testCreateQuestion()
    {
        $examid = $this->exam->id;
//        $examid = 1;
        $questionName = $this->faker->text(10);
        $questionDesc = $this->faker->text(10);
        var_dump($questionName);
        var_dump($questionDesc);
        $order = 4;
        //$exam = Exam::find($this->faker->randomNumber(1));
        $q = new Question();
        $q->id = 1;
        $this->dao->set_response($q);
        $this->object->createQuestion($questionName, $questionDesc, $order, $examid);
        $this->assertEquals('createQuestion', $this->dao->calledList[0][0]);
        $this->assertEquals([$questionName, $questionDesc], $this->dao->calledList[0][1]);

        $this->assertEquals('record', $this->assignmentDao->calledList[0][0]);
        $this->assertEquals($examid, $this->assignmentDao->calledList[0][1][0]);
        $this->assertEquals($order, $this->assignmentDao->calledList[0][1][2]);
    }


    public function testDeleteQuestion()
    {
        $qid = $this->faker->randomNumber(3);
        $this->object->deleteQuestion($qid);
        $this->assertEquals('deleteQuestion', $this->dao->calledList[0][0]);
        $this->assertEquals($qid, $this->dao->calledList[0][1][0]);
    }


    public function testHandle(){}


}
