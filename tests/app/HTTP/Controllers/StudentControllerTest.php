<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 11:05 AM
 */

namespace App\HTTP\Controllers;


use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\Mock;

class StudentControllerTest extends \TestCase
{
    use WithoutMiddleware;

    public $student;
    public $dao;
    protected $object;

    public function setUp()
    {
        \Mockery::close();
        parent::setUp();
        $this->student = Student::all()->random();
        $this->dao = \Mockery::mock('\App\Repositories\Student\IStudentRepository');
        $this->app->instance('\App\Repositories\Student\IStudentRepository', $this->dao);
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
        parent::tearDown();
        \Mockery::close();
    }

//
//    public function testIndex()
//    {
//
//    }

//
//    public function testCreate()
//    {
//        //
//    }


    public function testStore()
    {
        $data = [
            'lastName' => $this->faker->lastName(),
            'firstName' => $this->faker->firstName(),
            'studentId' => $this->faker->randomNumber(9),
            'email' => $this->faker->email()
        ];

        $dao = $this->createMock('\App\Repositories\Student\IStudentRepository');
        $dao->shouldReceive('create_student')->with($data)->andReturn($this->student);

        $response = $this->action('POST', 'StudentController@store', $data);
        $this->assertNotNull($response);
    }


    public function testShow()
    {
        $this->dao->shouldReceive('load_student_by_id')->with($this->student)->andReturn($this->student);
        $response = $this->action('POST', 'StudentController@show', $this->student);
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
        $this->dao->shouldReceive('delete_student_by_object')->with($this->student)->andReturn(true);
        $response = $this->action('POST', 'StudentController@destroy', $this->student);
        $this->assertNotNull($response);
    }
}
