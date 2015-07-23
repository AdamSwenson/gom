<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/23/15
 * Time: 10:32 AM
 */

namespace App\classes\RequestHandlers\dao;


use App\Element;
use App\ElementAssignment;
use App\Exam;
use App\Question;
use App\QuestionAssignment;

class ElementAssignmentDAOTest extends \TestCase
{

    public $questionAssignment;
    public $question;
    public $exam;
    public $element;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementAssignmentDAO();
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
}
