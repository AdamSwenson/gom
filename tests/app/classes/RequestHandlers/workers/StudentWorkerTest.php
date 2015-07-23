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

class StudentWorkerTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new StudentWorker;
        $this->student = Student::all()->random();
        $this->exam = Exam::all()->random();
    }


    public function testGetStudent()
    {
        $studentId = $this->student->getId();
    }

    public function testGetAllStudents()
    {
        $examId = $this->exam->getId();
    }

    public function testCreateStudent()
    {
        $lastName = $this->faker->lastName();
        $firstName = $this->faker->firstName();
        $studentId = $this->faker->randomNumber(9);
        $examId = $this->exam->getId();
    }

    public function testDeleteStudent()
    {
        $studentId = $this->student->getId();
    }

//    public function handle($request){}
}
