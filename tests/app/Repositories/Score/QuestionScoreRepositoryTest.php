<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:09 AM
 */

namespace App\Repositories\Score;


use App\QuestionAssignment;
use App\QuestionScore;

class QuestionScoreRepositoryTest extends \TestCase
{

    protected $object;
    protected $questionScore;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionScoreRepository;
        $this->questionScore = QuestionScore::all()->random();
    }

    public function testLoad_for_student_on_exam()
    {
        //prep
        $studentId = $this->questionScore->student_id;
        $qa = QuestionAssignment::find($this->questionScore->question_assignment_id);
        $examId = $qa->exam_id;

        //call
        $result = $this->object->load_for_student_on_exam($examId, $studentId);

        //check
        foreach($result as $r)
        {
            $this->assertInstanceOf('stdClass', $r, 'returns std class object');
    //        $this->assertEquals($studentId, $r->student_id, 'has correct student id');
        }
    }

    public function testLoad_all_for_question_number()
    {
        //prep
        $qa = QuestionAssignment::find($this->questionScore->question_assignment_id);
        $examId = $qa->exam_id;
        $qnum = $qa->question_number;

        //call
        $result = $this->object->load_all_for_question_number($examId, $qnum);

        //check
        foreach($result as $r)
        {
            $this->assertInstanceOf('stdClass', $r, 'returns stdClass object');
//            $this->assertEquals($qa->question_assignment_id, $r->question_assignment_id, 'has correct question assignment id');
        }
    }


    public function testLoad()
    {
        //prep
        $es = QuestionScore::all()->random();
        $score = $es->score;
        $questionAssignmentId = $es->question_assignment_id;
        $studentId = $es->student_id;

        //call
        $result = $this->object->load($questionAssignmentId, $studentId);

        //check
        $this->assertInstanceOf('App\QuestionScore', $result);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $this->assertEquals($questionAssignmentId, $result->question_assignment_id);
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
