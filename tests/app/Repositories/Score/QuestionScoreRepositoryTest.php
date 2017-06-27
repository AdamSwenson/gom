<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 9:09 AM
 */

namespace App\Repositories\Score;


use App\Exam;
use App\Question;
use App\QuestionAssignment;
use App\QuestionScore;

class QuestionScoreRepositoryTest extends \TestCase
{
    static public $examId = 1;
    public $questionAssignment;
    protected $object;
    protected $questionScore;
    protected $exam;
    protected $assignments;

    public function setUp()
    {
        parent::setUp();
        \Auth::loginUsingId(self::$userid);
        $this->object = new QuestionScoreRepository;
        $this->questionScore = factory(QuestionScore::class)->create();
        $this->questionAssignment = QuestionAssignment::find($this->questionScore->question_assignment_id);
        $this->exam = Exam::find($this->questionAssignment->exam_id);

//        $this->exam = Exam::find(self::$examId);
        $this->assignments = [$this->questionAssignment];
    }

    public function testLoad_for_student_on_exam()
    {
        //prep
        $numQuestions = 3;
        $questionScore = factory(QuestionScore::class)->create();
        $studentId = $questionScore->student_id;
        $exam = factory(Exam::class)->create();
        $questionAssignments = [];
        $questionAssignmentIds = [];

        for($i=1; $i<=$numQuestions; $i++){
            $question = factory(Question::class)->create();
            $qa = $this->makeQuestionAssignment($exam, $question, $i);
            $questionAssignments[] = $qa;
            $questionAssignmentIds[] = $qa->id;
        }
//
//        $qa = QuestionAssignment::find($this->questionScore->question_assignment_id);
//        $examId = $qa->exam_id;
//        $questionAssignments = QuestionAssignment::where('exam_id', $examId)->get();
//        $questionAssignmentIds = [];
//        foreach ($questionAssignments as $q)
//        {
//            $questionAssignmentIds[] = $q->id;
//        }

        //call
        $result = $this->object->load_for_student_on_exam($exam->id, $studentId);

        //check
        foreach ($result as $r)
        {
            $this->assertInstanceOf('stdClass', $r, 'returns std class object');
            //   $this->assertEquals($studentId, $r->student_id, 'has correct student id');
            $this->assertTrue($r->questionScore >= 0, "Question score has 0 or greater value");
            $this->assertTrue($r->questionName != '', "Question name not an empty string");
            $this->assertContains($r->questionAssignmentId, $questionAssignmentIds, "Question assignment belongs to the exam");
        }
    }

    /** @test */
    public function load_total_for_student_on_exam()
    {
        //prep
        $studentId = $this->questionScore->student_id;
        $qa = QuestionAssignment::find($this->questionScore->question_assignment_id);
        $examId = $qa->exam_id;
        $questionAssignments = QuestionAssignment::where('exam_id', $examId)->get();
        $expectedTotal = 0;
        foreach ($questionAssignments as $q)
        {
            $expectedTotal += QuestionScore::where('question_assignment_id', $q->id)->where('student_id', $studentId)->first()->score;
        }

        //call
        $result = $this->object->load_total_for_student_on_exam($examId, $studentId);

        //check
        $this->assertEquals($expectedTotal, $result, "Totals match");
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
        foreach ($result as $r)
        {
            $this->assertInstanceOf('stdClass', $r, 'returns stdClass object');
//            $this->assertEquals($qa->question_assignment_id, $r->question_assignment_id, 'has correct question assignment id');
        }
    }

    /** @test */
    public function load_all_for_exam_with_default_key()
    {
        //call
        $result = $this->object->load_all_for_exam($this->exam->id);

        //check
        $this->assertTrue(is_array($result), "Returned an array");

        foreach ($this->assignments as $assignment)
        {
            $this->assertArrayHasKey($assignment->question_number, $result, "Result array has question number key");
            $scores = QuestionScore::where('question_assignment_id', $assignment->id)->get();
            foreach ($scores as $score)
            {
                $this->assertContains($score->score, $result[$assignment->question_number], "Score in results array");
            }
        }
    }

    public function testLoad()
    {
        //prep
        $es = factory(QuestionScore::class)->create();
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
        $es = factory(QuestionScore::class)->create();
        $questionAssignmentId = $es->question_assignment_id;
        $studentId = $es->student_id;
        $score = $this->faker->randomFloat(2, 0, 10);

        $es->delete();
        $this->assertDatabaseMissing('question_scores', [
            'question_assignment_id' => $questionAssignmentId,
            'student_id' => $studentId,
        ]);

        $result = $this->object->update($questionAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\QuestionScore', $result);
        $this->assertEquals($questionAssignmentId, $result->question_assignment_id);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $retrieved = QuestionScore::where('question_assignment_id', $questionAssignmentId)->where('student_id', $studentId)->first();
        $this->assertNotNull($retrieved);
        $this->assertEquals($score, $retrieved->score, 0.001);
    }

    public function testUpdatePreexisting()
    {
        $questionAssignmentId = $this->questionAssignment->id;
        $studentId = $this->questionScore->student_id;
        $score = $this->questionScore->score;
//        $es = factory(QuestionScore::class)->create();
//        $questionAssignmentId = $es->question_assignment_id;
//        $studentId = $es->student_id;
//        $score = $this->faker->randomFloat(2, 0, 10);

        $result = $this->object->update($questionAssignmentId, $studentId, $score);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('App\QuestionScore', $result);
        $this->assertEquals($questionAssignmentId, $result->question_assignment_id);
        $this->assertEquals($studentId, $result->student_id);
        $this->assertEquals($score, $result->score);
        $this->assertDatabaseHas('question_scores', [
            'question_assignment_id' => $questionAssignmentId,
            'student_id' => $studentId,
            'score' => $score,
        ]);
    }


    public function testDeleteScore()
    {
        #prep
        $qs = factory(QuestionScore::class)->create();
        $questionAssignmentId = $qs->question_assignment_id;
        $studentId = $qs->student_id;

        #call
        $result = $this->object->deleteScore($questionAssignmentId, $studentId);

        #check
        $this->assertTrue($result, "returns as expected");
        $this->assertDatabaseMissing('question_scores', [
            'question_assignment_id' => $questionAssignmentId,
            'student_id' => $studentId,
        ]);
    }
}
