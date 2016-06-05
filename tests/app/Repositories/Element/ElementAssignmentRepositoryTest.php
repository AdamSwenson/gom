<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 10:18 AM
 */

namespace App\Repositories\Element;


use App\Element;
use App\ElementAssignment;
use App\Exam;
use App\Question;
use App\QuestionAssignment;

class ElementAssignmentRepositoryTest extends \TestCase
{

    protected $object;
    protected $assignment;
    protected $exam;
    protected $question;
    protected $questionAssignment;
    protected $element;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementAssignmentRepository();
        $this->exam = Exam::all()->random();
        $this->element = Element::all()->random();
        $this->question = Question::all()->random();
        $this->questionAssignment = QuestionAssignment::all()->random();
        ElementAssignment::where('question_id', $this->question->id)->delete();
    }

    public function testRecord()
    {
        //prep
        //create new element to assign so won't get false failures for multiple assignments of element to same question
        $element = factory('App\Element')->create();
        $subtask = 100;

        //call
        $result = $this->object->record($this->questionAssignment->exam_id, $this->question->id, $element->id, $subtask);

        //check
        $this->assertInstanceOf('\App\Element', $result);
        $this->seeInDatabase('element_assignments',
            [
                'question_id' => $this->question->id,
                'element_id' => $element->id,
                'subtask' => $subtask
            ]);
    }

    public function testLoad_elements()
    {
        $numberElements = 5;
        //prep
        $fixture = $this->makeElementAssignmentsForQuestion($numberElements);
        $examId = $fixture['exam']->id;
        $questionId = $fixture['question']->id;
        $elementIds = $fixture['elementIds'];
        $questionNumber = $fixture['questionNumber'];

//        $ea = ElementAssignment::all()->random();
//        $examId = $ea->exam_id;
//        $questionId = $ea->question_id;
//        $elementId = $ea->element_id;
        //$qAssign = QuestionAssignment::where('exam_id', $examId)->where('question_id', $questionId)->first();
        //$qNum = $qAssign->question_number;

        //call
        $result = $this->object->load_elements($examId, $questionNumber);

        //check
        $this->assertTrue(is_array($result), "should return an array");
//        $this->assertInstanceOf('Illuminate\Support\Collection', $result, "should return a laravel collection ");
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\Element', $r, "object is instance of element model");
        }
//
//
//        $qAssign = QuestionAssignment::all()->random(1);
//
//        $result = $this->object->load_elements($qAssign->exam_id, $qAssign->question_number);
////        $this->assertAttributeNotEmpty('assignments', $this->object, "assignments load");
//      //  $this->assertNotEmpty($result);

    }

    public function testLoad_element_assignments_by_question_number()
    {
        //prep
        $ea = ElementAssignment::all()->random();
        $examId = $ea->exam_id;
        $questionId = $ea->question_id;
        $elementId = $ea->element_id;
        $qAssign = QuestionAssignment::where('exam_id', $examId)->where('question_id', $questionId)->first();
        $qNum = $qAssign->question_number;

        //call
        $result = $this->object->load_element_assignments_by_question_number($examId, $qNum);

        //check
//        $this->assertTrue(is_array($result), "should return an array");
        $this->assertInstanceOf('Illuminate\Support\Collection', $result, "should return a laravel collection ");
        foreach ($result as $r)
        {
            $this->assertInstanceOf('App\ElementAssignment', $r);
        }

    }

    /**
     * @test
     */
    public function LoadByExamReturnsItemsWithProperOrdering()
    {
        //prep
        $elAssign = ElementAssignment::all()->random(1);
        $eid = $elAssign->exam_id;

        //call
        $result = $this->object->load_by_exam($eid);

        //check
        $this->assertInstanceOf('Illuminate\Support\Collection', $result, "should return a laravel collection ");

        $q_nums = [];
        $subtasks = [];
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\ElementAssignment', $r);
            array_push($q_nums, $r->getQuestionNumber());
            array_push($subtasks, $r->subtask);
        }

        //Check that in ascending order by question number
        for($i=0; $i<count($q_nums); $i++)
        {
            if($i>0)
            {
                $this->assertTrue($q_nums[$i] >= $q_nums[$i - 1]);
            }
        }

        //Check that subtasks are in order
        for($i=0; $i<count($subtasks); $i++)
        {
            if($i>0 && ($subtasks[$i] != 1))
            {
                $this->assertTrue($subtasks[$i] >= $subtasks[$i - 1]);
            }
        }

    }

    /**
     * @test
     */
    public function LoadByExamWhereWantToReturnArray()
    {
        $elAssign = ElementAssignment::all()->random(1);
        $eid = $elAssign->exam_id;

        $result = $this->object->load_by_exam($eid, true);

        $this->assertTrue(is_array($result), "should receive an array");

        foreach ($result as $r)
        {
            $this->assertInstanceOf('stdClass', $r);
        }
    }



    public function testLoad_element_assignment_by_element()
    {
        $el_assign = ElementAssignment::all()->random();
        $examId = $el_assign->exam_id;
        $elementId = $el_assign->element_id;

        $result = $this->object->load_element_assignment_by_element($examId, $elementId);

        $this->assertInstanceOf('App\ElementAssignment', $result);
        $this->assertEquals($el_assign->id, $result->id);
        $this->assertEquals($examId, $result->exam_id);
        $this->assertEquals($elementId, $result->element_id);
    }
}
