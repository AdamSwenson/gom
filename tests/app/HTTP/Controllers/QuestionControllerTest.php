<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 5:20 PM
 */

namespace App\HTTP\Controllers;


use App\Question;
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
        $this->incoming = ['questionName' => $this->faker->text(5), 'questionDesc' => $this->faker->text()];
    }

    public function tearDown()
    {
        \Mockery::close();
    }


    public function testIndexByExam()
    {
        $assignmentDao = $this->createMock('\App\Repositories\Question\IQuestionAssignmentRepository');
        $assignmentDao->shouldReceive('load_all_for_exam')->once()->andReturn(Question::all());
        $response = $this->action('POST', 'QuestionController@index', ['examId' =>5]);
        $this->assertNotNull($response);
    }

    public function testIndexByClassId()
    {
        $questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('loadQuestionsByClassId')
            ->once()
            ->andReturn(Question::all());
        $response = $this->action('GET', 'QuestionController@index', ['classId' => 3]);
        $this->assertNotNull($response);
    }

    public function testIndexAll()
    {
        $questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('loadAll')
            ->once()
            ->andReturn(Question::all());
        $response = $this->action('GET', 'QuestionController@index');
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


    public function testShow()
    {
     $response = $this->action('POST', 'QuestionController@show', $this->question);
        $this->assertNotNull($response);
    }


  /*  public function testEdit()
    {

//        return view('', compact('question'));
    }*/


    public function testUpdate()
    {
        $this->incoming['question'] = $this->question;

        $questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('updateQuestionObject')
            ->with($this->question, $this->incoming['questionName'], $this->incoming['questionDesc']);

        $response = $this->action('POST', 'QuestionController@update', $this->incoming);
        $this->assertNotNull($response);
    }

//    public function testUpdateAll()
//    {
//        // this function will take a request and process all the questions therein.
//        /* it will:
//            -Create a new question if the id is empty
//            -update an existing question if the id exists
//            -set the order property for each question
//            -pass the first questionId and examId to ElementController@
//        */
//        $data['examId'] = $exam;
//        $data['questionId'] = 1;
//        return view('setup.edit_element')->with(['data' => $data]);
//    }


    public function testDestroy()
    {
        $questionDao = $this->createMock('\App\Repositories\Question\IQuestionRepository');
        $questionDao->shouldReceive('deleteQuestionObject')->with($this->question)->once();
        $response = $this->action('POST', 'QuestionController@destroy', ['questionId' => $this->question->getId()]);
        $this->assertNotNull($response);
    }



}
