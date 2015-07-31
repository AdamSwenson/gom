<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/29/15
 * Time: 10:10 AM
 */

namespace App;


use Illuminate\Support\Facades\DB;

class QuestionTest extends \TestCase
{

    public $question;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new Question;
        $this->question = Question::all()->random();
    $this->exam = Exam::all()->random();
    }


    public function testGetQuestionNumber()
    {

    }

    public function testSetQuestionNumber()
    {
        $qnum = $this->faker->randomNumber(3);
        $result = $this->question->setQuestionNumber($this->exam->getId(), $qnum);

        $this->assertInstanceOf('App\Question', $result);
        $this->seeInDatabase('question_assignments', ['exam_id' => $this->exam->getId(), 'question_id' => $this->question->getId(), 'question_number' => $qnum]);

    }

    public function testSetQuestionNumberPreExisting()
    {
        $preexisting = QuestionAssignment::all()->random();
        $questionId = $preexisting->question_id;
        $examId = $preexisting->exam_id;

        $q = DB::table('questions')->where('id', '!=', $questionId)->first();
        $question = Question::find($q->id);
        $result = $question->setQuestionNumber($examId, $preexisting->question_number);

        $this->assertInstanceOf('App\Question', $result);
        $this->seeInDatabase('question_assignments', ['exam_id' => $examId, 'question_id' => $question->getId(), 'question_number' => $preexisting->question_number]);

    }

    #------------ foreign keys
    public function testExam()
    {
        foreach($this->question->exam as $e){
            $this->assertInstanceOf('App\Exam', $e);
        }
    }



    public function testUser()
    {
        $this->assertInstanceOf('App\User', $this->question->user);
    }

    public function testQuestionAssignments()
    {
        foreach($this->question->questionAssignments as $e)
        {
            $this->assertInstanceOf('App\Exam', $e);
        }
//        $this->markTestIncomplete();
    }

    public function testScores()
    {
        foreach($this->question->scores as $s)
        {
            $this->assertInstanceOf('App\QuestionScore', $s);
        }
    }

}
