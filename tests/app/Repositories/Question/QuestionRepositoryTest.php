<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 6:39 PM
 */

namespace App\Repositories\Question;


use App\Question;

class QuestionRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new QuestionRepository();
    }


    public function testCreateQuestion()
    {
        //prep
        $questionName = $this->faker->text(20);
        $questionDesc = $this->faker->text(20);
        $maxScore = $this->faker->randomFloat(2, 0, 100);

        //call
        $result = $this->object->createQuestion($questionName, $questionDesc, $maxScore);

        //check
        $this->assertInstanceOf('\App\Question', $result, "returns question");

        $exists = Question::find($result->id);
//        $exists = Question::whereRaw('questionName = ? and questionText = ?', [$questionName, $questionDesc])->get();
        $this->assertNotEmpty($exists);
        $this->assertEquals($questionName, $exists->questionName);
        $this->assertEquals($questionDesc, $exists->questionText);
        $this->assertEquals($maxScore, $exists->max_score);
    }

    /**
     * @test
     */
    public function create_question_w_no_maxScore_set()
    {
        //Prep
        $questionName = $this->faker->text(20);
        $questionDesc = $this->faker->text(20);

        //Call
        $result = $this->object->createQuestion($questionName, $questionDesc);

        //Check
        $this->assertInstanceOf('\App\Question', $result, "returns question");

        $exists = Question::find($result->id);
        $this->assertNotEmpty($exists);
        $this->assertEquals($questionName, $exists->questionName);
        $this->assertEquals($questionDesc, $exists->questionText);
    }

    public function testDeleteQuestion()
    {
        $question = Question::all()->random();
        $this->assertInstanceOf('\App\Question', $question, "ready to test");

        $qid = $question->id;
        $this->object->deleteQuestion($qid);

        $this->assertEmpty(Question::find($qid));
    }

//    /**
//     * @expectedException \Exception
//     */
//    public function testDeleteQuestionExceptionIdWrongType()
//    {
//        $this->object->deleteQuestion('1=1');
//    }

//    /**
//     * @expectedException \Exception
//     */
//    public function testDeleteQuestionExceptionNonexistingId()
//    {
//        $this->object->deleteQuestion(2345664433345);
//    }

    public function testLoadAll()
    {
        $result = $this->object->loadAll();
        $this->assertNotEmpty($result);
        foreach($result as $q)
        {
            $this->assertInstanceOf('\App\Question', $q);
        }
    }

    public function testLoadQuestionById()
    {
        $q = Question::all()->random();
        $qid = $q->id;

        $result = $this->object->loadQuestionById($qid);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Question', $result);
        $this->assertEquals($qid, $result->id);
    }


    /**
     * @expectedException \Exception
     */
    public function testLoadQuestionByIdExceptionIdWrongType()
    {
        $this->object->LoadQuestionById('cat fish');
    }

    /**
     * @expectedException \Exception
     */
    public function testLoadQuestionByIdExceptionNonexistingId()
    {
        $this->object->LoadQuestionById(2345664433345);
    }


    public function testLoadQuestionsByClassId()
    {

    }
}
