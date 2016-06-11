<?php
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

class ExamControllerCest
{
    public $exam;
    public $examData;
    public $examYear;
    public $examTerm;
    public $examName;
    protected $object;


    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function setUp(FunctionalTester $I)
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

        $eid = $this->exam->getId();
        $this->examData = [
            'exam_id' => $eid,
            'name' => $this->examName,
            'examTerm' => $this->examTerm,
            'examYear' => $this->examYear
        ];
    }


    public function testIndex(FunctionalTester $I)
    {
//        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
//        $mock->shouldReceive('load_all_exams')
//            ->once()
//            ->andReturn(Exam::all());
//        $response = $this->action('GET', 'ExamController@index');
//        $this->assertNotNull($response);
    }

    public function testIndexViaSetup(FunctionalTester $I)
    {
//        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
//        $mock->shouldReceive('load_all_exams')
//            ->once()
//            ->andReturn(Exam::all());
//
//        $response = $this->call('GET', '/setup');
//        $this->assertNotNull($response);

        //   $this->assertInstanceOf('View', $response->original);
    }


    public function testCreate(FunctionalTester $I)
    {
//        $response = $this->action('POST', 'ExamController@create');
//        $this->assertNotNull($response);
////        $this->assertResponseOk();
        //create new exam
//        return view('/setup/create_exam');
    }


    public function testStore(FunctionalTester $I)
    {
//        $data = [
//        'name' => $this->examName,
//        'examTerm' => $this->examTerm,
//        'examYear' => $this->examYear
//    ];
//        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
//        $mock->shouldReceive('save_new_exam')
//            ->with($data['examYear'], $data['examTerm'], $data['name'])
//            ->once()
//            ->andReturn($this->exam);
//
//        $response = $this->action('POST', 'ExamController@store', $data);
//        $this->assertNotNull($response);

        //Todo Add test for view returned
    }

    /*
        public function testShow(Exam $exam)
        {
            // Maybe write a view to show an exam without editing?
        }
    */


    public function testEdit(FunctionalTester $I)
    {
        $response = $this->action('GET', 'ExamController@edit', $this->eid);
        $this->assertNotEmpty($response);
//        $this->call('GET', "exam/$eid/edit");
//        $this->assertViewHas('exam');
    }

    public function testUpdate(FunctionalTester $I)
    {
        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('update_exam_object')
            ->with($this->exam, $this->examData['examYear'], $this->examData['examTerm'], $this->examData['name'])
            ->once()
            ->andReturn($this->exam);

        $response = $this->action('PUT', 'ExamController@update', $this->examData);
        $this->assertNotNull($response);


        //TODO Check proper view returned
    }


    public function testDestroy(FunctionalTester $I)
    {
        $mock = $this->createMock('App\Repositories\Exam\IExamRepository');
        $mock->shouldReceive('delete_exam')
            ->with($this->exam)
            ->once();

//        $object = new ExamController();
//        $response = $object->destroy($this->exam);
        $response = $this->action('DELETE', 'ExamController@destroy', ['exam_id' => $this->exam->id] );
//        $response = $this->call('DELETE', "/exam", ['exam' => $this->exam]);
//        $response = $this->call('DELETE', "/exam/{$this->exam->id}");
        $this->assertNotNull($response);

    }



}
