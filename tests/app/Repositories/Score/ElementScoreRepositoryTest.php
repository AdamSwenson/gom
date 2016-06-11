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


//        $this->fixture = $this->makeElementAssignmentsForQuestion(2);
        $this->elementScore = factory(ElementScore::class)->create();
        $this->elementAssign = ElementAssignment::find($this->elementScore->element_assignment_id);
        $this->exam = Exam::find($this->elementAssign->exam_id);
//        $this->elementScore = factory(ElementScore::class)->create(['element_id' => $this->elementAssign->id]);
    }


    public function testLoad()
    {
        $assignId = $this->elementScore->element_assignment_id;
        $studentId = $this->elementScore->student_id;

        $result = $this->object->load($assignId, $studentId);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\ElementScore', $result);
        $this->assertEquals($assignId, $result->element_assignment_id);
        $this->assertEquals($studentId, $result->student_id);

        $this->assertAttributeInstanceOf('App\ElementScore', 'score_object', $this->object);

//        $this->markTestIncomplete();
//        $elementAssignmentId, $studentId
//        $this->score_object = ElementScore::onStudentElementAssignment($studentId, $elementAssignmentId)->first();

//        return $this->score_object;
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
    //prep
    $es = $this->elementScore;
    $elementAssignmentId = $es->element_assignment_id;
    $studentId = $es->student_id;
    $text = $this->faker->text();

//    $es->delete();
//    $this->notSeeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId]);

    //call
    $this->object->recordCommentText($elementAssignmentId, $studentId, $text);

    //result
    $this->seeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId, 'comment_text' => $text]);

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
        foreach($result as $r)
        {
            $this->assertEquals($studentId, $r->student_id);
        }
    }


    public function testUpdateNew()
    {
        #prep
        $elementAssignmentId = factory(ElementAssignment::class)->create()->id;
        $studentId = factory(Student::class)->create()->id;
        $score = $this->faker->randomFloat(2,0,10);

        #call
        $result = $this->object->update($elementAssignmentId, $studentId, $score);

        #check
        $this->assertNotEmpty($result);
//        $this->assertInstanceOf('App\ElementScore', $result);
//        $this->assertEquals($elementAssignmentId, $result->element_assignment_id);
//        $this->assertEquals($studentId, $result->student_id);
//        $this->assertEquals($score, $result->score);
        $this->seeInDatabase('element_scores',
                             [
                                 'element_assignment_id' => $elementAssignmentId,
                                 'student_id' => $studentId,
                                 'score' => $score
                             ]);

//        $this->markTestIncomplete();
    }

    public function testUpdatePreexisting()
    {
        $es = $this->elementScore;
        $elementAssignmentId = $es->element_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2,0,10);

        $result = $this->object->update($elementAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
//        $this->assertInstanceOf('App\ElementScore', $result);
//        $this->assertEquals($elementAssignmentId, $result->element_assignment_id);
//        $this->assertEquals($studentId, $result->student_id);
//        $this->assertEquals($score, $result->score);
        $this->seeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId, 'score' => $score]);
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
        $this->notSeeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId]);
    }


    /*
    public function testScoreTooBig()
    {}
    */
}
