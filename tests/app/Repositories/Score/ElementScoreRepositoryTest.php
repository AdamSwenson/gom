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

class ElementScoreRepositoryTest extends \TestCase
{

    protected $object;
    protected $elementAssign;

    public function setUp()
    {
        parent::setUp();
        $this->object = new ElementScoreRepository;
        $this->elementAssign = ElementAssignment::all()->random();
        $this->elementScore = ElementScore::all()->random();
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


    public function testLoad_for_student_on_exam()
    {
        $this->markTestIncomplete();
    }


    public function testUpdateNew()
    {
        $es = ElementScore::all()->random();
        $elementAssignmentId = $es->element_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2);

        $es->delete();
        $this->notSeeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId]);

        $result = $this->object->update($elementAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\ElementScore', $result);
        $this->assertEquals($elementAssignmentId, $result->element_assignment_id);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $this->seeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId, 'score' => $score]);

//        $this->markTestIncomplete();
    }

    public function testUpdatePreexisting()
    {
        $es = ElementScore::all()->random();
        $elementAssignmentId = $es->element_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2);

        $result = $this->object->update($elementAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\ElementScore', $result);
        $this->assertEquals($elementAssignmentId, $result->element_assignment_id);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $this->seeInDatabase('element_scores', ['element_assignment_id' => $elementAssignmentId, 'student_id' => $studentId, 'score' => $score]);
    }


}
