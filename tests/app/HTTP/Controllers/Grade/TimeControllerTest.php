<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/20/16
 * Time: 9:03 PM
 */

namespace App\HTTP\Controllers\Grade;

use App\ElementScore;
use App\Exam;
use App\GradingTime;
use App\Http\Controllers\GradeController;
use App\QuestionScore;
use App\Student;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TimeControllerTest extends \TestCase
{
    use WithoutMiddleware;

    protected $object;
    protected $exam;

    public function setUp()
    {
        parent::setUp();
        $this->object = new TimeControllerTest;
    }


    public function testRecordTime()
    {
        $data = ['examId' => 1, 'studentId' => 2, 'time' => 4.5];
        $mock = $this->createMock('App\Repositories\Time\IGradingTimeRepository');
        $mock->shouldReceive('record')
            ->with([$data['examId'], $data['studentId'], $data['time']])
            ->andReturn(GradingTime::all()->random());
        $result = $this->post('Grade\TimeController@recordTime', $data);
        $this->assertNotNull($result);
    }

}
