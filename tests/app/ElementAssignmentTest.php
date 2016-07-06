<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/29/15
 * Time: 9:29 AM
 */

namespace App;


class ElementAssignmentTest extends \TestCase
{

    public $assignment;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = factory(ElementAssignment::class)->create();
        $this->assignment = $this->object;
    }

    public function testSetSubtask()
    {
        $v = $this->faker->randomDigit();
        $this->object->setSubtask($v);
        $this->assertEquals($v, $this->object->subtask);
    }

    public function testGetSubtask()
    {
        $v = $this->faker->randomDigit();
        $this->object->subtask = $v;
        // $this->assertNotEmpty($this->object->getSubtask());
        $this->assertEquals($v, $this->object->getSubtask());

    }

//    public function testGetQuestionNumber()
//    {
//
////        $v = $this->faker->randomDigit();
////        $this->object->question_number = $v;
//        $this->assertNotEmpty($this->assignment->getQuestionNumber());
////        $this->assertEquals($v, $this->assignment->getQuestionNumber());
//    }
#--------------- Queries


    public function testScopeOnExam()
    {
        $eid = $this->object->exam_id;
        $result = ElementAssignment::onExam($eid);//$a['exam_id']);
        $this->assertNotEmpty($result);
        foreach ( $result as $r )
        {
            $this->assertInstanceOf('App\Exam', $r);
        }

    }

//
//    public function testScopeQuestionNumber()
//    {
//        $qa = QuestionAssignment::find($this->assignment->question_assignment_id);
//        $qnum = $qa->question_number;
//        $result = ElementAssignment::questionNumber($qnum);
//        $this->assertNotEmpty($result);
//        foreach($result as $r)
//        {
//            $this->assertInstanceOf('App\ElementAssignment', $r);
//        }
//    }

# -------------- Foreign key associations
//    public function testUser()
//    {
//        $this->assertInstanceOf(User::class, $this->assignment->user);
//    }

//    public function testComments()
//    {
//        foreach($this->assignment->comments as $c){
//            $this->assertInstanceOf('App\Comment', $c);
//        }
//   }

//    public function testExam()
//    {
//        $this->assertInstanceOf('App\Exam', $this->assignment->exam);
// }


    public function testElement()
    {
        $this->assertInstanceOf('App\Element', $this->assignment->element);
    }

    public function testElementScores()
    {
        #prep
        $elementScore = factory(ElementScore::class)->create();

        $ea = ElementAssignment::find($elementScore->element_assignment_id);

        #call
        $result = $ea->elementScores;

        #check
        $this->assertNotNull($result, "something returned");

        foreach ( $result as $item )
        {
            $this->assertInstanceOf(ElementScore::class, $item, "object is an element score");
        }
    }

    public function testQuestion()
    {
        $this->assertInstanceOf('App\Question', $this->assignment->question);
    }

//    public function testQuestionAssignment()
//    {
//        $this->assertInstanceOf('App\QuestionAssignment', $this->assignment->questionAssignment);
////        return $this->belongsTo('App\QuestionAssignment');
//    }


    /* -------------------------------- Getters -------------------------------- */


    public function testGetElementId()
    {
        #prep
        $ea = factory(ElementAssignment::class)->create();
        $eid = $ea->element->id;

        #call
        $result = $ea->getElementId();

        #check
        $this->assertEquals($eid, $result, "matches expected id");
    }


    public function testGetElementAssignmentId()
    {
        #prep
        $ea = factory(ElementAssignment::class)->create();
        $eaid = $ea->id;

        #call
        $result = $ea->getElementAssignmentId();

        #check
        $this->assertEquals($eaid, $result, "matches expected id");
    }


    public function getElementName()
    {
        #prep
        $ea = factory(ElementAssignment::class)->create();
        $name = $ea->element->name;

        #call
        $result = $ea->getElementName();

        #check
        $this->assertEquals($name, $result, "matches expected name");
    }

}
