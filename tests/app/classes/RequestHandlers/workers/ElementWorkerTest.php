<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 10:00 AM
 */

namespace App\classes\RequestHandlers\workers;


use App\classes\RequestHandlers\dao\IElementAssignmentDAOMock;
use App\classes\RequestHandlers\dao\IElementDAOMock;
use App\Comment;
use App\Element;
use App\classes\RequestHandlers\dao\ElementDAO;
use App\Exam;

class ElementWorkerTest extends \TestCase
{

    public $object;
    public $dao;
    public $element;
    public $assignmentDao;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementWorker;
        $this->dao = new IElementDAOMock();
        $this->assignmentDao = new IElementAssignmentDAOMock();
        $this->object->dao = $this->dao;
        $this->object->assignmentDao = $this->assignmentDao;
        $this->element = Element::all()->random();
    }


    public function testGetElement()
    {
        $elementId = $this->element->id;
        $this->object->getElement($elementId);

        $this->assertEquals('loadElementById', $this->dao->called);
        $this->assertEquals($elementId, $this->dao->called_list[0][1][0]);
    }

    public function testGetAllElements()
    {
        $questionId = 2;
        $this->object->getAllElements($questionId);
    }

    public function testCreateElement()
    {
        $elementName = $this->faker->text(5);
        $respGeneric = $this->faker->text(5);
        $respAbsent = $this->faker->text(5);
        $respPoor = $this->faker->text(5);
        $respFair = $this->faker->text(5);
        $respGood = $this->faker->text(5);

        $examId = 345;
        $questionNumber = 3;
        $subtask = 2;

        $eid = 45;
        $e = new Element();
        $e->id = $eid;

        $this->dao->set_response($e);
        $this->object->createElement($examId, $questionNumber, $subtask, $elementName, $respGeneric, $respAbsent, $respPoor, $respFair, $respGood);

        //check that first called create element
        $this->assertEquals('createElement', $this->dao->called_list[0][0]);
        $this->assertEquals($elementName, $this->dao->called_list[0][1][0]);
        $this->assertEquals('', $this->dao->called_list[0][1][1]);
        $this->assertEquals($respGeneric, $this->dao->called_list[0][1][2]);

        //check that called make valenced
        $this->assertEquals('addValencedContent', $this->dao->called_list[1][0]);
        $this->assertEquals($eid, $this->dao->called_list[1][1][0]);
        $this->assertEquals(Comment::VALENCE_ABSENT, $this->dao->called_list[1][1][1]);
        $this->assertEquals($respAbsent, $this->dao->called_list[1][1][2]);

        $this->assertEquals('addValencedContent', $this->dao->called_list[2][0]);
        $this->assertEquals($eid, $this->dao->called_list[2][1][0]);
        $this->assertEquals(Comment::VALENCE_POOR, $this->dao->called_list[2][1][1]);
        $this->assertEquals($respPoor, $this->dao->called_list[2][1][2]);

        $this->assertEquals('addValencedContent', $this->dao->called_list[3][0]);
        $this->assertEquals($eid, $this->dao->called_list[3][1][0]);
        $this->assertEquals(Comment::VALENCE_OK, $this->dao->called_list[3][1][1]);
        $this->assertEquals($respFair, $this->dao->called_list[3][1][2]);

        $this->assertEquals('addValencedContent', $this->dao->called_list[4][0]);
        $this->assertEquals($eid, $this->dao->called_list[4][1][0]);
        $this->assertEquals(Comment::VALENCE_EXCELLENT, $this->dao->called_list[4][1][1]);
        $this->assertEquals($respGood, $this->dao->called_list[4][1][2]);

        $this->assertEquals('record', $this->assignmentDao->called_list[0][0]);
        $this->assertEquals($examId, $this->assignmentDao->called_list[0][1][0]);
        $this->assertEquals($questionNumber, $this->assignmentDao->called_list[0][1][1]);
        $this->assertEquals($eid, $this->assignmentDao->called_list[0][1][2]);
        $this->assertEquals($subtask, $this->assignmentDao->called_list[0][1][3]);


    }

    public function testDeleteElement()
    {
        $elementId = $this->element->id;
        $this->object->deleteElement($elementId);
        $this->assertEquals('deleteElement', $this->dao->called);
        $this->assertEquals($elementId, $this->dao->called_list[0][1][0]);
    }

//    public function testHandle()
//    {}

}
