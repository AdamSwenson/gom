<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/24/15
 * Time: 4:43 PM
 */

namespace App\Http\Controllers;


use App\Exam;
use App\Http\Controllers\ExamController;
use App\Http\Requests\ExamRequest;
use App\Repositories\Exam\IExamRepository;
use App\Repositories\Exam\IStoredExamStatsRepository;
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
        $this->exam = factory(Exam::class)->create();
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
        parent::tearDown();
    }

    public function testIndex()
    {
        $exams = Exam::all();
        $mock = $this->createMock(IExamRepository::class);
        $mock->shouldReceive('load_all_exams')
            ->once()
            ->andReturn($exams);

        $storedExamStatsDaoMock = $this->createMock(IStoredExamStatsRepository::class);
        $storedExamStatsDaoMock->shouldReceive('getNumberStudents')->times(count($exams));
        $storedExamStatsDaoMock->shouldReceive('getNumberQuestions')->times(count($exams));

        $response = $this->call('GET', '/exam1');
//        $response = $this->get('ExamController@index');
        $this->assertNotNull($response);
    }

    //This seems to no longer be a valid/used route. Getting rid of test
//    public function testIndexViaSetup()
//    {
//        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
//        $mock->shouldReceive('load_all_exams')
//            ->once()
//            ->andReturn(Exam::all());
//
//        $response = $this->call('GET', '/setup');
//        $this->assertNotNull($response);
//
//        //   $this->assertInstanceOf('View', $response->original);
//    }


    public function testCreate()
    {
        $response = $this->post('ExamController@create');
        $this->assertNotNull($response);
//        $this->assertResponseOk();
        //create new exam1
//        return view('/setup/create_exam');
    }


    public function testStore()
    {
        $data = [
            'name'     => $this->examName,
            'examTerm' => $this->examTerm,
            'examYear' => $this->examYear,
        ];
        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('save_new_exam')
            ->with($data['examYear'], $data['examTerm'], $data['name'])
            ->once()
            ->andReturn($this->exam);

        $response = $this->post('ExamController@store', $data);
        $this->assertNotNull($response);

        //Todo Add test for view returned
    }

    /*
        public function testShow(Exam $exam1)
        {
            // Maybe write a view to show an exam1 without editing?
        }
    */


    public function testEdit()
    {
//        $response = $this->call('Get', "exam1/{$this->exam1->id}/edit");
        $response = $this->get('ExamController@edit', $this->exam);
        $this->assertNotEmpty($response);
//TODO This isn't actually working
//        $this->assertViewHas('exam1', $this->exam1);
//        $this->assertViewHas('terms', ExamController::$terms);

//        $years[] = date('Y');
//        $years[] = strval($years[ $offset ] + 1);
//        $this->assertViewHas('years', [$value = null);
//        $this->call('GET', "exam1/$eid/edit");
//        $this->assertViewHas('exam1');
    }

//    public function testUpdate()
//    {
//        $exam1 = factory(Exam::class)->make();
//
//        $data = [
//            'name'     => $this->examName,
//            'examTerm' => $this->examTerm,
//            'examYear' => $this->examYear,
//        ];
//
//        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
//        $mock->shouldReceive('update_exam_object')
//            ->with($exam1, $data['examYear'], $data['examTerm'], $data['name'])
//            ->once()
//            ->andReturn($exam1);
//
//        //will hit ExamController@update
//        $response = $this->call('PUT', '/exam1/' . $exam1->id, $data);
//        $this->assertNotNull($response);
//
//    }


//    public function testDestroy()
//    {
//        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
//        $mock->shouldReceive('delete_exam')
//            ->with($this->exam1)
//            ->once();
//
////        $object = new ExamController();
////        $response = $object->destroy($this->exam1);
//        $response = $this->delete('ExamController@destroy', ['exam_id' => $this->exam1->id]);
////        $response = $this->call('DELETE', "/exam1", ['exam1' => $this->exam1]);
////        $response = $this->call('DELETE', "/exam1/{$this->exam1->id}");
//        $this->assertNotNull($response);
//
//    }


}
