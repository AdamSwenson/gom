<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:08 AM
 */

namespace App\Repositories\Score;


use App\ElementAssignment;
use App\ElementScore;
use App\Exam;
use App\Student;

class ElementScoreRepositoryTest extends \TestCase
{

    public $fixture;
    public $exam;
    public $elementScore;
    protected $object;
    protected $elementAssign;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementScoreRepository;

        //A fresh score, element assignment, and exam for every test!
        $this->elementScore = factory(ElementScore::class)->create();
        $this->elementAssign = ElementAssignment::find($this->elementScore->element_assignment_id);
        $this->exam = Exam::find($this->elementAssign->exam_id);
    }


    public function testLoad()
    {
        $assignId = $this->elementScore->element_assignment_id;
        $studentId = $this->elementScore->student_id;

        $result = $this->object->load($assignId, $studentId);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\ElementScore', $result);
        $this->assertEquals($assignId, $result->element_assignment_id, "has correct assignment id");
        $this->assertEquals($studentId, $result->student_id, "has correct student id");

        $this->assertAttributeInstanceOf('App\ElementScore', 'score_object', $this->object);

    }

//
//    public function testLoad_all_for_question_number()
////IQuestionAssignmentRepository $questionAssigner, $examId, $questionNumber)
//    {
//        $this->markTestIncomplete();
////        $assignment = $questionAssigner->load($examId, $questionNumber);
////        ElementScore::whereHas('questionAssignment', function($query, $assignment){
////            $query->where('id', $assignment->getId());
////        });
//    }


    public function testRecordCommentText()
    {
        #prep
        $es = $this->elementScore;
        $elementAssignmentId = $es->element_assignment_id;
        $studentId = $es->student_id;
        $text = $this->faker->text();

        #call
        $this->object->recordCommentText($elementAssignmentId, $studentId, $text);

        #check
        $this->assertDatabaseHas('element_scores', [
            'element_assignment_id' => $elementAssignmentId,
            'student_id'            => $studentId,
            'comment_text'          => $text,
        ]);

    }


    public function testLoad_for_student_on_exam()
    {
        //Prep
        $es = $this->elementScore;
        $studentId = $es->student_id;
        $ea = ElementAssignment::find($es->element_assignment_id);
        $examId = $ea->exam_id;

        //Call
        $result = $this->object->load_for_student_on_exam($examId, $studentId);

        //Check
        foreach ( $result as $r )
        {
            $this->assertEquals($studentId, $r->student_id);
        }
    }


    public function testUpdateWhereNew()
    {
        #prep
        $elementAssignmentId = $this->elementAssign->id;
        $studentId = $this->elementScore->student_id;
        $score = $this->faker->randomFloat(2, 0, 10);

        #call
        $result = $this->object->update($elementAssignmentId, $studentId, $score);

        #check
        $this->assertNotEmpty($result);
        //load from db to check (the float score messes up the assertions for
        //looking in db)
        $inDb = ElementScore::where('element_assignment_id', $elementAssignmentId)->where('student_id', $studentId)->first();
        $this->assertInstanceOf(ElementScore::class, $inDb);
        $this->assertEquals($score, $inDb->score, 'expected score found in db', 0.001);

    }

    /**
     * Todo fails
     */
    public function testUpdateWherePreexisting()
    {
        #prep
        $es = $this->elementScore;
        $elementAssignmentId = $es->element_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2, 0, 10);

        #call
        $result = $this->object->update($elementAssignmentId, $studentId, $score);

        #check
        $this->assertNotEmpty($result);
        //load from db to check (the float score messes up the assertions for
        //looking in db)
        $inDb = ElementScore::where('element_assignment_id', $elementAssignmentId)
            ->where('student_id', $studentId)
            ->first();
        $this->assertInstanceOf(ElementScore::class, $inDb, "returned an element score object");
        $this->assertEquals($score, $inDb->score, 'expected score found in db', 0.001);

    }


    public function testDeleteScore()
    {
        //prep
        $es = $this->elementScore;
        $elementAssignmentId = $es->element_assignment_id;
        $studentId = $es->student_id;

        //call
        $result = $this->object->deleteScore($elementAssignmentId, $studentId);

        //check
        $this->assertTrue($result, "returns as expected");
        $this->assertDatabaseMissing('element_scores', [
            'element_assignment_id' => $elementAssignmentId,
            'student_id'            => $studentId,
        ]);
    }


    /*
    public function testScoreTooBig()
    {}
    */
}
