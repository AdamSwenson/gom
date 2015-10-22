<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 11:05 AM
 */

namespace App\HTTP\Controllers;


use App\Kumi;
use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\Mock;

class StudentControllerTest extends \TestCase
{
    use WithoutMiddleware;

    public $student;
//    public $dao;
    protected $object;

    public function setUp()
    {
//        \Mockery::close();
        parent::setUp();
        $this->student = Student::all()->random();
        // $this->dao = \Mockery::mock('\App\Repositories\Student\IStudentRepository');
        //$this->app->instance('\App\Repositories\Student\IStudentRepository', $this->dao);
//        $this->dao = $this->createMock('\App\Repositories\Student\IStudentRepository');
        // $this->object = new StudentController($this->dao);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
//        parent::tearDown();
        \Mockery::close();
    }


    public function testIndex()
    {
        $response = $this->action('GET', 'StudentController@index');
        $this->assertNotNull($response);
    }

/*    public function testCreate()
    {
        $this->markTestIncomplete();
    }*/


    public function testStore()
    {
        //TODO Improve this test by testing for the values being passed around

        $numStudents = 3;
        $processor_mock = $this->createMock('App\Jobs\StudentImport\IImportStudentsFromCsv');
        $processor_mock->shouldReceive('handle')
            ->andReturn(Student::all()->random($numStudents));

        $kumi_repository_processor_mock = $this->createMock('App\Repositories\Student\IKumiRepository');
        $kumi_repository_processor_mock
            ->shouldReceive('create')->andReturn(Kumi::all()->random());

        $dao = $this->createMock('App\Repositories\Student\IStudentRepository');
        $dao->shouldReceive('create_student')
            ->times($numStudents)
            ->andReturn(Student::all()->random());

        $data = [
            'exam_id' => 1,
            'lastName' => $this->faker->lastName(),
            'firstName' => $this->faker->firstName(),
            'studentId' => $this->faker->randomNumber(9),
            'email' => $this->faker->email()
        ];

        $response = $this->action('POST', 'StudentController@store', $data);
        $this->assertNotNull($response);
    }


    public function testShow()
    {
        $dao = $this->createMock('\App\Repositories\Student\IStudentRepository');

        $dao->shouldReceive('load_student_by_id')->with($this->student)->andReturn($this->student);
        $response = $this->action('GET', 'StudentController@show', $this->student);
        $this->assertNotNull($response);
    }

//
//    public function testEdit()
//    {
//        //
//    }
//
//
//    public function testUpdate()
//    {
//        //
//    }

    public function testDestroy()
    {
        $dao = $this->createMock('\App\Repositories\Student\IStudentRepository');
        $dao->shouldReceive('delete_student_by_object')->with($this->student)->andReturn(true);
        $response = $this->action('DELETE', 'StudentController@destroy', $this->student);
        $this->assertNotNull($response);
    }


    /**
     * @test
     */
    public function validateStudents()
    {


    }
}
