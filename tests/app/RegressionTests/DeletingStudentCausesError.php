<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/20/15
 * Time: 3:40 PM
 */

namespace RegressionTests;


use App\Student;

class DeletingStudentCausesError extends \TestCase
{

    protected $object;
    protected $students;

    public function setUp()
    {
        parent::setUp();
        $this->students = Student::all();
    }


    public function testRegression()
    {
        $toDelete = $this->students[1];
        $deletedStudentId = $toDelete->getId();

        $response = $this->call('POST', '/exam/{exam}/student/updateAll', ['name' => 'Taylor']);

    }
}