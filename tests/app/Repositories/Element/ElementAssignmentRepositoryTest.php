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
//        parent::setUp();
//        $this->object = new ElementAssignmentRepository;
//        $this->exam = Exam::all()->random();
//        $this->question = Question::all()->random();
//        $this->element = Element::all()->random();
//        $this->questionAssignment = QuestionAssignment::all()->random();
//        $this->assignment = ElementAssignment::all()->random();
//    }
//

        parent::setUp();
        $this->object = new ElementAssignmentRepository();
        $this->exam = Exam::all()->random();
        $this->element = Element::all()->random();
        $this->question = Question::all()->random();
        $this->questionAssignment = QuestionAssignment::all()->random();
        ElementAssignment::where('question_assignment_id', $this->questionAssignment->id)->delete();
    }

    public function testRecord()
    {

        $result = $this->object->record($this->questionAssignment->exam_id, $this->questionAssignment->question_id,
            $this->element->getId(), 4);
        $this->assertInstanceOf('\App\ElementAssignment', $result);
    }

    public function testLoad_elements()
    {
        $elAssign = ElementAssignment::all()->random(1);

        $result = $this->object->load_elements($elAssign->questionAssignment->exam_id,
            $elAssign->questionAssignment->question_number);
        $this->assertAttributeNotEmpty('assignments', $this->object, "assignments load");
        $this->assertNotEmpty($result);
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\Element', $r);
        }
    }

    public function testLoad_elements_by_question_number()
    {
        $elAssign = ElementAssignment::all()->random();
        $result = $this->object->load_element_assignments_by_question_number($elAssign->questionAssignment->exam_id,
            $elAssign->questionAssignment->question_number);
        $this->assertAttributeNotEmpty('assignments', $this->object, "assignments load");
        $this->assertNotEmpty($result);
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\ElementAssignment', $r);
        }
    }

    public function testLoad_by_exam()
    {
        $elAssign = ElementAssignment::all()->random(1);
        $eid = $elAssign->questionAssignment->exam_id;

        $result = $this->object->load_by_exam($eid);
        foreach ($result as $r)
        {
            $this->assertInstanceOf('\App\ElementAssignment', $r);
        }
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
//        //todo fix so works
//        $this->seeInDatabase('question_assignments',
//            ['exam_id' => $this->exam->getId(), 'question_id' => $this->question_id]);
//        $this->seeInDatabase('element_assignments', ['element_id' => $this->element->getId(), 'subtask' => $subtask]);
//
//    }
}
