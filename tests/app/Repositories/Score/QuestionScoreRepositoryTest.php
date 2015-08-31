<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:09 AM
 */

namespace App\Repositories\Score;


use App\QuestionScore;

class QuestionScoreRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionScoreRepository;
    }

    public function testLoad_for_student_on_exam()
    {
//        $examId, $studentId
    }

    public function testLoad_all_for_question_number()
    {
//        $examId, $questionNumber
        $this->markTestIncomplete();
    }


    public function testLoad()
    {
        $es = QuestionScore::all()->random();
        $questionAssignmentId = $es->question_assignment_id;
        $studentId = $es->student_id;

        $this->score_object = QuestionScore::where('student_id', $studentId)->where('question_assignment_id', $questionAssignmentId)->first();
        return $this->score_object;

        $this->markTestIncomplete();
//        $questionAssignmentId, $studentId
//
//        $this->score_object = QuestionScore::onStudentQuestionAssignment($studentId, $questionAssignmentId)->first();
//        return $this->score_object;
    }


    public function testUpdateNew()
    {
        $es = QuestionScore::all()->random();
        $questionAssignmentId = $es->question_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2, 0, 10);

        $es->delete();
        $this->notSeeInDatabase('question_scores', ['question_assignment_id' => $questionAssignmentId, 'student_id' => $studentId]);

        $result = $this->object->update($questionAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\QuestionScore', $result);
        $this->assertEquals($questionAssignmentId, $result->question_assignment_id);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $this->seeInDatabase('question_scores', ['question_assignment_id' => $questionAssignmentId, 'student_id' => $studentId, 'score' => $score]);
    }

    public function testUpdatePreexisting()
    {
        $es = QuestionScore::all()->random();
        $questionAssignmentId = $es->question_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2, 0, 10);

        $result = $this->object->update($questionAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\QuestionScore', $result);
        $this->assertEquals($questionAssignmentId, $result->question_assignment_id);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $this->seeInDatabase('question_scores', ['question_assignment_id' => $questionAssignmentId, 'student_id' => $studentId, 'score' => $score]);
    }


    public function testDeleteScore()
    {
        //prep
        $qs = QuestionScore::all()->random();
        $questionAssignmentId = $qs->question_assignment_id;
        $studentId = $qs->student_id;

        //call
        $result = $this->object->deleteScore($questionAssignmentId, $studentId);

        //check
        $this->assertTrue($result, "returns as expected");
        $this->notSeeInDatabase('question_scores', [
            'question_assignment_id' => $questionAssignmentId,
            'student_id' => $studentId
        ]);
    }
}
