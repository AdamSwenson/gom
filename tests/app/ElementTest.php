<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/30/15
 * Time: 9:16 AM
 */

namespace App;


class ElementTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Element;
        $this->element = Element::all()->random();
        $this->elementAssign = ElementAssignment::all()->random();
    }

    public function testSetAsQuestionTask()
    {
        $qa = QuestionAssignment::all()->random();
        $examId = $qa->exam_id;
        $questionId = $qa->question_id;
        $enum = $this->faker->randomNumber(3);
        $result = $this->element->setAsQuestionTask($examId, $questionId, $enum);

        $this->assertInstanceOf('App\Element', $result);
        $this->seeInDatabase('element_assignments',
            ['question_id' => $questionId, 'exam_id' => $examId, 'element_id' => $this->element->getId(), 'subtask' => $enum]); //not the most perfect test
    }


//    public function testGetQuestionTaskNumber()
//    {
//        $qaid = $this->elementAssign->question_assignment_id;
//        $this->object->id = $this->elementAssign->element_id;
//        $result = $this->object->getQuestionTaskNumber($qaid);
//        $this->assertTrue(is_integer($result));
//    }


    public function testSetElementName()
    {
        $test = $this->faker->text();
        $this->object->setElementName($test);
        $this->assertEquals($test, $this->object->elementName);
    }


    public function testSetCommentText()
    {
        $test = $this->faker->text();
        $this->object->setCommentText($test);
        $this->assertEquals($test, $this->object->commentText);
    }


    public function testGetElementName()
    {
        $this->assertNotEmpty($this->element->getElementName());
    }


    public function testGetCommentText()
    {
        $this->assertNotEmpty($this->element->getCommentText());
    }

#----------------- foreign keys
    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->element->user);
    }

//    public function testElementAssignments()
//    {
//        foreach($this->element->elementAssignments as $r)
//        $this->assertInstanceOf('App\ElementAssignment', $r);
//    }

//    public function testQuestionAssignments()
//    {
//        foreach ($this->element->questionAssignments as $r)
//        {
//            $this->assertInstanceOf('App\QuestionAssignment', $r);
//        }
//    }


//    public function testExam()
//    {
//        foreach($this->element->exam as $r)
//        {
//            $this->assertInstanceOf('App\ElementScore', $r);
//        }
//    }

    public function testScores()
    {
        foreach ($this->element->scores as $r)
        {
            $this->assertInstanceOf('App\ElementScore', $r);
        }
    }

    public function testComments()
    {
        foreach ($this->element->comments as $r)
        {
            $this->assertInstanceOf('App\Comment', $r);
        }
    }

//    public function testQuestions()
//    {
//        foreach($this->element->questions as $r)
//        {
//            $this->assertInstanceOf('App\Question', $r);
//        }
//    }
}
