<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/26/15
 * Time: 11:05 AM
 */

namespace App\HTTP\Controllers;


use App\Student;

class StudentControllerTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentControllerTest;
        $this->student = Student::all()->random();
        $this->dao = $this->createMock('\App\Repositories\Student\IStudentRepository');
    }


    public function testIndex()
    {

    }


    public function testCreate()
    {
        //
    }


    public function testStore()
    {
        $data = [
            'lastName' => $this->faker->lastName(),
            'firstName' => $this->faker->firstName(),
            'studentId' => $this->faker->randomNumber(9),
            'email' => $this->faker->email()
        ];
        $this->dao->shouldReceive('create_student')->with($data)->shouldReturn($this->student);

        $response = $this->action('POST', 'StudentController@store', $data);
        $this->assertNotNull($response);
    }


    public function testShow()
    {
        $this->dao->shouldReceive('load_student_by_id')->with($this->student)->shouldReturn($this->student);
        $response = $this->action('POST', 'StudentController@show', $this->student);
        $this->assertNotNull($response);
    }


    public function testEdit()
    {
        //
    }


    public function testUpdate()
    {
        //
    }

    public function testDestroy()
    {
        $this->dao->shouldReceive('delete_student_by_object')->with($this->student)->shouldReturn(true);
        $response = $this->action('POST', 'StudentController@destroy', $this->student);
        $this->assertNotNull($response);
    }
}
