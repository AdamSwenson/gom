<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:20 PM
 */

namespace App\HTTP\Controllers;


use App\Exam;
use App\Jobs\AsyncStorage\UpdateStoredExamStats;
use App\Question;
use App\QuestionAssignment;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Question\IQuestionRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @property array incoming
 */
class QuestionControllerTest extends \TestCase
{

    use WithoutMiddleware;

//    public $assignmentDao;
//    public $questionDao;
    public $question;
    public $examId;
    protected $object;

    public function setUp()
    {
        parent::setUp();
//        $this->questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        //$this->assignmentDao = $this->createMock('\App\Repositories\Question\IQuestionAssignmentRepository');

        $this->question = Question::all()->random();
        $this->examId = $this->faker->randomNumber(3);
        $this->incoming = [
            'questionName' => $this->faker->text(5),
            'questionDesc' => $this->faker->text(),
        ];
    }

    public function tearDown()
    {
        \Mockery::close();
    }


    public function testIndexByExam()
    {
        $exam = Exam::all()->random();
        $assignmentDao = $this->createMock('App\Repositories\Question\IQuestionAssignmentRepository');
        $assignmentDao->shouldReceive('load_all_for_exam')->andReturn(Question::all());
        $response = $this->action('GET', 'QuestionController@index', ['examId' => $exam->id]);
        $this->assertNotNull($response);
    }

    public function testIndexByClassId()
    {
        $questionDao = $this->createMock('App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('loadQuestionsByClassId')
            ->andReturn(Question::all());
        $response = $this->action('GET', 'QuestionController@index', ['classId' => 3]);
        $this->assertNotNull($response);
    }

    public function testIndexAll()
    {
        $questionDao = $this->createMock('App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('loadAll')
            ->andReturn(Question::all());
        $data = ['examId' => $this->examId];
        $response = $this->action('GET', 'QuestionController@index', $data);
        $this->assertNotNull($response);
    }


    /*
        public function testCreate(QuestionRequest $request)
        {
            // $exam from URL: questions must know which exam to be associated with(?)
        }*/

    public function testStore()
    {
        $return = new Question();
        $return->id = $this->faker->randomNumber(3);
        $questionNumber = $this->faker->randomNumber(2);

        $this->incoming['examId'] = $this->examId;
        $this->incoming['questionNumber'] = $questionNumber;

        $questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        $questionDao
            ->shouldReceive('createQuestion')
            ->with($this->incoming['questionName'], $this->incoming['questionDesc'])
            ->andReturn($return);

        $assignmentDao = $this->createMock('\App\Repositories\Question\IQuestionAssignmentRepository');
        $assignmentDao
            ->shouldReceive('record')
            ->with($this->examId, $return->id, $questionNumber);

        $response = $this->action('POST', 'QuestionController@store', $this->incoming);
        $this->assertNotNull($response);
    }


//    public function testShow()
//    {
//        $response = $this->action('POST', 'QuestionController@show', $this->question);
//        $this->assertNotNull($response);
//    }


//    public function testEdit()
//    {
//        $response = $this->action('POST', 'QuestionController@edit', ['questionId' => 1, 'examId' => $this->examId]);
//        $this->assertNotNull($response);
//
//    }


    public function testUpdate()
    {
        $this->incoming['question'] = $this->question;

        $questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('updateQuestionObject')
            ->with($this->question, $this->incoming['questionName'], $this->incoming['questionDesc']);

        $response = $this->action('POST', 'QuestionController@update', $this->incoming);
        $this->assertNotNull($response);
    }

    public function testUpdateAll()
    {
//        $this->markTestIncomplete();
        $this->incoming['examId'] = $this->examId;
        $qAssignment = QuestionAssignment::all()->random();


        $assignmentDao = $this->createMock(IQuestionAssignmentRepository::class);
        $questionDao = $this->createMock(IQuestionRepository::class);

        //expectations
        $assignmentDao->shouldReceive('updateAll')->with(Exam::find($this->examId));

        $assignmentDao->shouldReceive('load_all_for_exam')->with($this->examId)->andReturn([1, 2]);
        $assignmentDao->shouldReceive('load')->with($this->examId, 1)->andReturn($qAssignment);

        $questionDao->shouldReceive('loadQuestionById')->with($qAssignment->getQuestionId());

        $response = $this->action('POST', 'QuestionController@updateAll', $this->incoming);
        $this->assertNotNull($response);

        //TODO figure out why not picking this up
        //$this->expectsJobs(UpdateStoredExamStats::class);
    }


    public function testDestroy()
    {
        $questionDao = $this->createMock('App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('deleteQuestionObject')->with($this->question);
        $data = ['questionId' => $this->question->getId(), 'examId' => $this->examId];
        $response = $this->action('POST', 'QuestionController@destroy', $data);
        $this->assertNotNull($response);
    }


}
