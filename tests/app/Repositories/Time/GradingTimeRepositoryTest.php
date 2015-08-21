<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/21/15
 * Time: 2:40 PM
 */

namespace App\Repositories\Time;


use App\Exam;
use App\GradingTime;

class GradingTimeRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new GradingTimeRepository;
    }

    public function testLoad()
    {
        $gt = GradingTime::all()->random();
        $result = $this->object->load($gt->exam_id, $gt->student_id);

        $this->assertInstanceOf('App\GradingTime', $result, "GradingTime type object loads");
        $this->assertEquals($gt->exam_id, $result->exam_id);
        $this->assertEquals($gt->student_id, $result->student_id);
        $this->assertEquals($gt->seconds, $result->seconds);
    }

    public function testRecord()
    {
       $newTime = $this->faker->randomFloat(3,2);
        $gt = GradingTime::all()->random();
        $result = $this->object->record($gt->exam_id, $gt->student_id, $newTime);

        $db = GradingTime::where('exam_id', $gt->exam_id)->where('student_id', $gt->student_id)->first();
        $this->assertEquals($newTime, $db->seconds, "expected time is in db", 0.001);
//        $this->seeInDatabase('grading_times', ['exam_id' => $gt->exam_id, 'student_id' => $gt->student_id, 'seconds' => $newTime]);
    }

    public function testUpdate()
    {
        $gt = GradingTime::all()->random();
        $newTime = $gt->seconds + $this->faker->randomFloat(3,2);

        $result = $this->object->update($gt->exam_id, $gt->student_id, $newTime);

        $db = GradingTime::where('exam_id', $gt->exam_id)->where('student_id', $gt->student_id)->first();
        $this->assertEquals($newTime, $db->seconds, "expected time is in db", 0.1);
//        $this->seeInDatabase('grading_times', ['exam_id' => $gt->exam_id, 'student_id' => $gt->student_id, 'seconds' => $newTime]);
    }



}
