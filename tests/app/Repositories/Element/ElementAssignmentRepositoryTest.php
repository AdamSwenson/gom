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
        $subtask = $this->faker->randomNumber(3);
        $result = $this->object->record($this->questionAssignment->exam_id, $this->question->id, $this->element->id, $subtask);
        $this->assertInstanceOf('\App\Element', $result);
        $this->seeInDatabase('element_assignments',
            [
                'question_id' => $this->question->id,
                'element_id' => $this->element->id,
                'subtask' => $subtask
            ]);
    }

    public function testLoad_elements()
    {
        //TODO this needs to be fixed to ensure that there is always the expected value in the db
        $qAssign = QuestionAssignment::all()->random(1);

        $result = $this->object->load_elements($qAssign->exam_id,
            $qAssign->question_number);
//        $this->assertAttributeNotEmpty('assignments', $this->object, "assignments load");
      //  $this->assertNotEmpty($result);
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\Element', $r);
        }
    }

    public function testLoad_elements_by_question_number()
    {
        //TODO this needs to be fixed to ensure that there is always the expected value in the db
        $qAssign = QuestionAssignment::all()->random(1);

        $result = $this->object->load_element_assignments_by_question_number($qAssign->exam_id,
            $qAssign->question_number);
       // $this->assertAttributeNotEmpty('assignments', $this->object, "assignments load");
       // $this->assertNotEmpty($result);
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\ElementAssignment', $r);
        }
    }

    /**
     * TODO: Add check to make sure ordered by question_number, subtask
     */
    public function testLoad_by_exam()
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

        //Todo: Still not well-ordered



    }

    /**
     * TODO: Add check to make sure ordered by question_number, subtask
     */
    public function testLoad_by_examReturnArray()
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

//
//    public function testLoad_elements()
//    {
//        $examId = $this->questionAssignment->exam_id;
//        $questionNumber = $this->questionAssignment->question_number;
//
//        $result = $this->object->load_elements($examId, $questionNumber);
//        if (count($result) > 0)
//        {
//            $this->assertInstanceOf('\App\Element', $result[0]);
//        }
//
//    }
//
//    public function testLoad_element_assignments_by_question_number()
//    {
//        $qnum = $this->assignment->questionAssignment()->question_number;
//        $examId = $this->assignment->exam()->getId();
//        $result = $this->object->load_element_assignments_by_question_number($examId, $qnum);
//        $this->assertNotEmpty($result);
//        $this->assertInstanceOf('\App\ElementAssignment', $result);
//
//    }
//
//    public function testLoad_by_exam()
//    {
//        $result = $this->object->load_by_exam($this->assignment->exam()->getId());
//        $this->assertNotEmpty($result);
//        $this->assertInstanceOf('\App\ElementAssignment', $result);
//     }
//
//    public function testRecord()
//    {
//        $subtask = $this->faker->randomNumber(3);
//        $result = $this->object->record($this->exam->getId(), $this->question->getId(), $this->element->getId(),
//            $subtask);
//        $this->assertInstanceOf('\App\ElementAssignment', $result);
//

//        $this->seeInDatabase('question_assignments',
//            ['exam_id' => $this->exam->getId(), 'question_id' => $this->question_id]);
//        $this->seeInDatabase('element_assignments', ['element_id' => $this->element->getId(), 'subtask' => $subtask]);
//
//    }
}
