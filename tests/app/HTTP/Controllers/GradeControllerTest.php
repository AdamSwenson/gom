<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 12:59 PM
 */

namespace App\HTTP\Controllers;


use App\ElementScore;
use App\Exam;
use App\GradingTime;
use App\Http\Controllers\GradeController;
use App\QuestionScore;
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
        $examDao = $this->createMock('App\Repositories\Exam\IExamRepository');
        $examDao->shouldReceive('load_all_exams')
            ->andReturn(Exam::all());
        $response = $this->action('GET', 'GradeController@index');
        $this->assertNotEmpty($response);
    }

    public function testGrade()
    {
        $studentDao = $this->createMock('App\Repositories\Student\IStudentRepository');
        $studentDao->shouldReceive('load_students_by_exam')
            ->with($this->exam)
            ->andReturn(Student::all()->random(5));

        $response = $this->action('GET', 'GradeController@grade', $this->exam);
        $this->assertNotEmpty($response);
    }

    public function testRecordScoreQuestion()
    {
        $data = ['question_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];
        $mock = $this->createMock('App\Repositories\Score\IQuestionScoreRepository');
        $mock->shouldReceive('record')
            ->with([$data['question_assignment_id'], $data['student_id'], $data['score']])
            ->andReturn(QuestionScore::all()->random());
        $response = $this->action('POST', 'GradeController@recordScore', $data);
        $this->assertNotNull($response);
    }

    public function testRecordScoreElement()
    {

        $data = ['element_assignment_id' => 1, 'student_id' => 2, 'score' => 3.4];
        $mock = $this->createMock('App\Repositories\Score\IElementScoreRepository');
        $mock->shouldReceive('record')
            ->with([$data['element_assignment_id'], $data['student_id'], $data['score']])
            ->andReturn(ElementScore::all()->random());
        $response = $this->action('POST', 'GradeController@recordScore', $data);
        $this->assertNotNull($response);
    }

    /*
    public function testRecordScoreUnset()
    {
    }
    */


    public function testRecordTime()
    {
        $data = ['examId' => 1, 'studentId' => 2, 'time' => 4.5];
        $mock = $this->createMock('App\Repositories\Time\IGradingTimeRepository');
        $mock->shouldReceive('record')
            ->with([$data['examId'], $data['studentId'], $data['time']])
            ->andReturn(GradingTime::all()->random());
        $result = $this->action('POST', 'GradeController@recordTime', $data);
        $this->assertNotNull($result);
    }

    public function testLoadTime()
    {
        $data = ['examId' => 1, 'studentId' => 2];
        $mock = $this->createMock('App\Repositories\Time\IGradingTimeRepository');
        $mock->shouldReceive('load')
            ->with([$data['examId'], $data['studentId']])
            ->andReturn(GradingTime::all()->random());
        $result = $this->action('GET', 'GradeController@loadTime', $data);
        $this->assertNotNull($result);
    }

/*
    public function testGetAutoSID()
    {
        $this->markTestIncomplete();
//        $studentDao->lookup_autocomplete($this->exam, $request);
//        $autocomplete_handler = new AutocompleteService();
//        $autocomplete_handler->set_response_handler($this->response_handler);
//        $autocomplete_handler->process($this->exam, $request);
    }
*/

/*
    public function testSetTotalExams()
    {
        $this->markTestIncomplete();
    }
*/
}
