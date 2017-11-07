<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/29/15
 * Time: 10:10 AM
 */

namespace App;


use App\QuestionAssignment;
use Illuminate\Support\Facades\DB;

class QuestionTest extends \TestCase
{

    public $question;
    protected $object;
    protected $exam;

    public function setUp()
    {
        parent::setUp();
    }

    public function loginAndMakeQuestion()
    {
        \Auth::loginUsingId(self::$userid);
        $this->object = new Question;
        $this->question = Question::all()->random();
        $this->exam = Exam::all()->random();
    }

    public function testGetQuestionNumber()
    {

        #prep
        $qnum = 3;
        $exam = factory(Exam::class)->create();
        $question = factory(Question::class)->create();
        $qid = $question->id;

        $qa = new QuestionAssignment();
        $qa->exam_id = $exam->id;
        $qa->question_id = $question->id;
        $qa->question_number = $qnum;
        $qa->save();

        #call
        $this->object = Question::find($qid);
        $result = $this->object->getQuestionNumber($exam->id);

        #check
        $this->assertEquals($qnum, $result, "question number is correct");

//        /* We know that question_id = 1 should be the first question on exam1 1 */
//        $target_question_id = 1;
//        $target_exam_id = 1;
//        $expected_question_number = 1;
//
//        /* So, let's get that question and make sure that it is question number 1*/
//        $this->object = Question::find($target_question_id);
//        $result = $this->object->getQuestionNumber($target_exam_id);
//        $this->assertEquals($expected_question_number, $result, "question number is correct");
    }

    /**
     * @test
     */
    public function setQuestionNumber_where_no_other_question_is_already_assigned()
    {

        $qnum = 3;
        $exam = factory(Exam::class)->create();
        $question = factory(Question::class)->create();
        $qid = $question->id;

        #call
        $this->object = Question::find($qid);
        $result = $this->object->setQuestionNumber($exam->id, $qnum);

        //Check that has been entered into the database in correct place
        $this->assertDatabaseHas('question_assignments',
                             [
                                 'exam_id' => $exam->id,
                                 'question_id' => $question->id,
                                 'question_number' => $qnum
                             ]);


//
//
//        /* Completely reset and re-seed the database */
//        $this->prepareDatabase();
//        $this->loginAndMakeQuestion();
//
//        //Use a question number we can be sure is not already assigned (because it's three digits)
//        $qnum = $this->faker->randomNumber(3);
//
//        //call
//        $result = $this->question->setQuestionNumber($this->exam1->getId(), $qnum);
//
//        //check
//        $this->assertInstanceOf('App\Question', $result);
//        $this->assertDatabaseHas('question_assignments', ['exam_id' => $this->exam1->getId(), 'question_id' => $this->question->getId(), 'question_number' => $qnum]);
    }

    /**
     * @test
     */
    public function testSetQuestionNumber_where_there_is_a_pre_existing_assignment()
    {
        $qnum = 3;
        $exam = factory(Exam::class)->create();
        $question = factory(Question::class)->create();
        $otherQuestion = factory(Question::class)->create();
        $qid = $question->id;

        $qa = new QuestionAssignment();
        $qa->exam_id = $exam->id;
        $qa->question_id = $otherQuestion->id;
        $qa->question_number = $qnum;
        $qa->save();

        #call
        $this->object = Question::find($qid);
        $result = $this->object->setQuestionNumber($exam->id, $qnum);

        //Check that has been entered into the database in correct place
        $this->assertDatabaseHas('question_assignments',
                             [
                                 'exam_id' => $exam->id,
                                 'question_id' => $question->id,
                                 'question_number' => $qnum
                             ]);

        //Make sure that pre-existing question has been removed
        $this->assertDatabaseMissing('question_assignments',
                                [
                                    'exam_id' => $exam->id,
                                    'question_id' => $otherQuestion->id
                                ]);


//        /* Completely reset and re-seed the database */
//        $this->prepareDatabase();
//        $this->loginAndMakeQuestion();
//
//        /*
//        Question_id = 6 is the first question not on exam1 1.
//        So let's replace the second question (question_id = 2) with it to simulate the user
//        creating a new question, deleting an existing question, and moving the new question
//        into the existing question's place
//        */
//        $target_exam_id = 1;
//        $target_question_number = 2;
//        $question_id_to_replace = 2;
//        $question_id_to_add = 6;
//
//        $this->object = Question::find($question_id_to_add);
//        $result = $this->object->setQuestionNumber($target_exam_id, $target_question_number);
//
//        //Check that returned a question object
//        $this->assertInstanceOf('App\Question', $result);
//        //Check that returned object has correct id
//        $this->assertEquals($question_id_to_add, $result->id);

//        //Check that has been entered into the database in correct place
//        $this->assertDatabaseHas('question_assignments',
//                             [
//                                 'exam_id' => $target_exam_id,
//                                 'question_id' => $question_id_to_add,
//                                 'question_number' => $target_question_number
//                             ]);
//
//        //Make sure that pre-existing question has been removed
//        $this->assertDatabaseMissing('question_assignments',
//                             [
//                                 'exam_id' => $target_exam_id,
//                                 'question_id' => $question_id_to_replace
//                             ]);
    }

    #------------ foreign keys
    public function testExam()
    {
        $this->loginAndMakeQuestion();
        foreach($this->question->exam as $e){
            $this->assertInstanceOf('App\Exam', $e);
        }
    }

    public function testUser()
    {
        $this->loginAndMakeQuestion();
        $this->assertInstanceOf('App\User', $this->question->user);
    }

    public function testQuestionAssignments()
    {
        $this->loginAndMakeQuestion();
        foreach($this->question->questionAssignments as $e)
        {
            $this->assertInstanceOf('App\Exam', $e);
        }
    }

    public function testScores()
    {
        $this->loginAndMakeQuestion();
        foreach($this->question->scores as $s)
        {
            $this->assertInstanceOf('App\QuestionScore', $s);
        }
    }

}
