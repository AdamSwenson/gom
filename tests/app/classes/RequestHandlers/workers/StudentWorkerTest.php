<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 7:28 PM
 */

namespace App\classes\RequestHandlers\workers;


use App\Exam;
use App\Student;
use classes\RequestHandlers\dao\IStudentDAOMock;

class StudentWorkerTest extends \TestCase
{


    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentWorker;
        $this->student = Student::all()->random();
        $this->exam = Exam::all()->random();
        $this->dao = new IStudentDAOMock();
        $this->object->dao = $this->dao;
    }


    public function testGetStudent()
    {
        $studentId = $this->faker->randomNumber(9);
        $this->dao->set_response(new Student());
        $result = $this->object->getStudent($studentId);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\App\Student', $result);
        $this->assertEquals('load_student_by_id', $this->dao->called);
    }

    public function testGetAllStudents()
    {
        $this->object->getAllStudents();
        $this->assertEquals('load_all_students', $this->dao->called);
    }

    public function testCreateStudent()
    {
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();
        $studentId = $this->faker->randomNumber(9);
        $examId = $this->faker->randomNumber(3);

        $this->object->createStudent($lastName, $firstName, $studentId, $examId);

        $this->assertEquals('create_student', $this->dao->called);
        $this->assertEquals($lastName, $this->dao->called_list[0][1][0]);
        $this->assertEquals($firstName, $this->dao->called_list[0][1][1]);
        $this->assertEquals($studentId, $this->dao->called_list[0][1][2]);
    }

    public function testDeleteStudent()
    {
        $studentId = $this->faker->randomNumber(9);
        $this->object->deleteStudent($studentId);
        $this->assertEquals('delete_student_by_id', $this->dao->called);
        $this->assertEquals($studentId, $this->dao->called_list[0][1][0]);
    }

//    public function testHandle($request){}
}
