<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/24/15
 * Time: 4:43 PM
 */

namespace HTTP\Controllers;


use App\Exam;
use App\Http\Controllers\ExamController;
use App\Http\Requests\ExamRequest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Laracasts\TestDummy\Factory;
use Mockery\Mock;

class ExamControllerTest extends \TestCase
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
        $this->exam = Exam::all()->random();
//        $mock = Mockery::mock('\App\Repositories\Exam\IExamRepository');
//        $this->app->instance('\App\Repositories\Exam\IExamRepository', $mock);
        $this->eid = $this->faker->randomNumber(3);
        $this->examName = $this->faker->text(5);
        $this->examTerm = $this->faker->text(5);
        $this->examYear = $this->faker->year();

        $this->examData = [
            'examId' => $this->exam->getId(),
            'name' => $this->examName,
            'term' => $this->examTerm,
            'year' => $this->examYear
        ];
    }

    public function tearDown()
    {
           \Mockery::close();

    }

    public function testIndex()
    {
        $mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('load_all_exams')
            ->andReturn(Exam::all());

//        $view='/setup/select_exam';
//        $this->registerNestedView($view);

        $response = $this->action('GET', 'ExamController@index');
        $this->assertNotNull($response);

//        $this->assertNestedViewHas($view, '/setup/select_exam');

//        $this->assertInstanceOf('View', $response->original);
    }

    public function testIndexViaSetup()
    {
        $mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('load_all_exams')->andReturn(Exam::all())->once();
        $response = $this->call('GET', 'setup');
        $this->assertNotNull($response);

     //   $this->assertInstanceOf('View', $response->original);
    }


    public function testCreate()
    {
        $response = $this->action('POST', 'ExamController@create');
        $this->assertNotNull($response);
//        $this->assertResponseOk();
        //create new exam
//        return view('/setup/create_exam');
    }


    public function testStore()
    {
        $mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('save_new_exam')
            ->with($this->examData['year'], $this->examData['term'], $this->examData['name'])
            ->once()
        ->andReturn($this->exam);

        $response = $this->action('POST', 'ExamController@store', $this->examData);
        $this->assertNotNull($response);

        //Todo Add test for view returned
    }

    /*
        public function testShow(Exam $exam)
        {
            // Maybe write a view to show an exam without editing?
        }
    */


    public function testEdit()
    {
        $response = $this->action('GET', 'ExamController@edit', $this->eid);
        $this->assertNotEmpty($response);
//        $this->call('GET', "exam/$eid/edit");
//        $this->assertViewHas('exam');
    }

    public function testUpdate()
    {
        $mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('update_exam_object')
            ->with($this->exam, $this->examData['year'], $this->examData['term'], $this->examData['name'])
            ->once()->andReturn($this->exam);;

        $response = $this->action('POST', 'ExamController@update', $this->examData);
        $this->assertNotNull($response);


        //TODO Check proper view returned
    }


    public function testDestroy()
    {
        $mock = $this->createMock('\App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('delete_exam_object')
            ->with($this->exam)
            ->once();

        $response = $this->action('POST', 'ExamController@destroy', $this->exam);
        $this->assertNotNull($response);

        //TODO Test for view
    }


}
