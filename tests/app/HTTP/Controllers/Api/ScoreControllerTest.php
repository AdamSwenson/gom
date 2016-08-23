<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/20/16
 * Time: 8:04 PM
 */

namespace App\HTTP\Controllers\Api;


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
//        $this->mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $this->exam = factory(Exam::class)->create(); //all()->random();
//        $mock = Mockery::mock('\App\Repositories\Exam\IExamRepository');
//        $this->app->instance('\App\Repositories\Exam\IExamRepository', $mock);
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
            ->with([$data['question_assignment_id'], $data['student_id'], $data['score']])
            ->andReturn($questionScore);
        $response = $this->action('POST', 'Api\ScoreController@recordScore', $data);
        $this->assertNotNull($response);
    }


}
