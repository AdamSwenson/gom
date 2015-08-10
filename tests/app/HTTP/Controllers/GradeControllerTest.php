<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 12:59 PM
 */

namespace App\HTTP\Controllers;


use App\Exam;
use App\Http\Controllers\GradeController;
use App\Student;

class GradeControllerTest extends \TestCase
{

    protected $object;
    protected $exam;

    public function setUp()
    {
        parent::setUp();
        $this->exam = Exam::all()->random();
    }

    public function tearDown()
    {
        \Mockery::close();

    }

    public function testIndex()
    {
        $examDao = $this->getMock('App\Repositories\Exam\IExamRepository');
        $examDao->shouldReceive('load_all_exams')
            ->andReturn(Exam::all());
        $response = $this->action('GET', 'ExamController@index');
        $this->assertNotEmpty($response);
    }

    public function testGrade()
    {
        $studentDao = $this->getMock('App\Repositories\Student\IStudentRepository');
        $studentDao->shouldReceive('load_students_by_exam')
            ->with($this->exam)
            ->andReturn(Student::all()->random(5));

        $response = $this->action('GET', 'ExamController@grade', $this->exam);
        $this->assertNotEmpty($response);
    }

    public function testRecordScore()
    {
        $this->markTestIncomplete();
    }




    public function testGetAutoSID()
    {
        $this->markTestIncomplete();
//        $studentDao->lookup_autocomplete($this->exam, $request);
//        $autocomplete_handler = new AutocompleteService();
//        $autocomplete_handler->set_response_handler($this->response_handler);
//        $autocomplete_handler->process($this->exam, $request);
    }


    public function testSetTotalExams()
    {
        $this->markTestIncomplete();
    }

}
