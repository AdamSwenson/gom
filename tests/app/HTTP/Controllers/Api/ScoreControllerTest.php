<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/20/16
 * Time: 8:04 PM
 */

namespace App\HTTP\Controllers\Grade;


use App\Element;
use App\ElementScore;
use App\Exam;
use App\Http\Controllers\ExamController;
use App\Http\Requests\ExamRequest;
use App\QuestionScore;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Laracasts\TestDummy\Factory;
use Mockery\Mock;


class ScoreControllerTest extends \TestCase
{
    use WithoutMiddleware;

//    public $mock;
    public $exam;
    public $examData;
    public $examYear;
    public $examTerm;
    public $examName;
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->exam = factory(Exam::class)->create();
        $this->eid = $this->faker->randomNumber(3);
        $this->examName = $this->faker->text(5);
        $this->examTerm = $this->faker->text(5);
        $this->examYear = $this->faker->year();

        $eid = $this->exam->getId();
        $this->examData = [
            'exam_id'  => $eid,
            'name'     => $this->examName,
            'examTerm' => $this->examTerm,
            'examYear' => $this->examYear,
        ];
    }

    public function tearDown()
    {
        \Mockery::close();
    }


    public function testRecordScoreQuestion()
    {
        $questionScore = factory(QuestionScore::class)->create();
        $data = ['examId' => 1, 'question_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];

        $mock = $this->createMock('App\Repositories\Score\IQuestionScoreRepository');
        $mock->shouldReceive('record')
            ->once()
            ->with([$data['question_assignment_id'], $data['student_id'], $data['score']])
            ->andReturn($questionScore);

        $response = $this->action('POST', 'Grade\ScoreController@recordScore', $data);
        $this->assertNotNull($response);
    }

    public function testRecordScoreElementNoComment()
    {
        $element = factory(Element::class)->create();
        $data = ['examId' => 1, 'element_id' => $element->id, 'student_id' => 2, 'score' => 3.4];
        $mock = $this->createMock('App\Repositories\Score\IElementScoreRepository');
        $mock->shouldReceive('load_element_assignment_by_element')
            ->once()
            ->with([$data['examId'], $data['element_id']])
            ->andReturn($element->id);

        $mock->shouldReceive('record')
            ->once()
            ->with([$data['element_id'], $data['student_id'], $data['score']]);

        $response = $this->action('POST', 'Grade\ScoreController@recordScore', $data);
        $this->assertNotNull($response);
    }

    /**
     * @test
     */
    public function testRecordScoreElementWithComment()
    {
        $element = factory(Element::class)->create();
        $data = ['examId' => 1, 'element_id' => $element->id, 'student_id' => 2, 'score' => 3.4, 'comment_text' => $this->faker->text(5)];
        $mock = $this->createMock('App\Repositories\Score\IElementScoreRepository');
        $mock->shouldReceive('load_element_assignment_by_element')
            ->once()
         //   ->with([$data['examId'], $data['element_id']])
            ->andReturn($element->id);

        $mock->shouldReceive('record')
            ->once();
            //->with([$data['element_id'], $data['student_id'], $data['score']]);


        $mock->shouldReceive('recordCommentText')
            ->once()
            ->with([$data['element_id'], $data['student_id'], $data['comment_text']]);

        $response = $this->action('POST', 'Grade\ScoreController@recordScore', $data);
        $this->assertNotNull($response);
    }


    public function testRemoveScore(){
        $data = ['examId' => 1, 'question_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];

        $mock = $this->createMock('App\Repositories\Score\IQuestionScoreRepository');
        $mock->shouldReceive('deleteScore')
            ->once()
            ->with([$data['question_assignment_id'], $data['student_id']]);

        $response = $this->action('POST', 'Grade\ScoreController@removeScore', $data);
        $this->assertNotNull($response);
    }

    /**
     * @test
     * @group bugs
     */
    public function recordScoreWhenExamIsAlreadyReleased(){
        #prep
        $this->exam->released = 1;
        $this->exam->save();
        $questionScore = factory(QuestionScore::class)->create();

        $data = ['examId' => $this->exam->id,
                 'question_assignment_id' => $questionScore->question_assignment_id,
                 'student_id' => 2,
                 'score' => 3.4];
        $mock = $this->createMock('App\Repositories\Score\IQuestionScoreRepository');
        $mock->shouldReceive('record')
            ->once()
            //->with([$data['question_assignment_id'], $data['student_id'], $data['score']])
            ->andReturn($questionScore);
        $response = $this->action('POST', 'Grade\ScoreController@recordScore', $data);
        $this->assertNotNull($response);
    }

}
