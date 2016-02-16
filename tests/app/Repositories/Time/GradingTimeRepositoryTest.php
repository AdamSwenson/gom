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
    static public $examId = 1;

    public function setUp()
    {
        parent::setUp();
        $this->object = new GradingTimeRepository;
        $this->exam = Exam::where('exam_id', self::$examId)->first();
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
        $newTime = $this->faker->randomFloat(3, 0, 100);
        $gt = GradingTime::all()->random();
        $result = $this->object->record($gt->exam_id, $gt->student_id, $newTime);

        $db = GradingTime::where('exam_id', $gt->exam_id)->where('student_id', $gt->student_id)->first();
        $this->assertEquals($newTime, $db->seconds, "expected time is in db", 0.1);
//        $this->seeInDatabase('grading_times', ['exam_id' => $gt->exam_id, 'student_id' => $gt->student_id, 'seconds' => $newTime]);
    }

    public function testUpdate()
    {
        $gt = GradingTime::all()->random();
        $newTime = $gt->seconds + $this->faker->randomFloat(3, 0, 100);

        $result = $this->object->update($gt->exam_id, $gt->student_id, $newTime);

        $db = GradingTime::where('exam_id', $gt->exam_id)->where('student_id', $gt->student_id)->first();
        $this->assertEquals($newTime, $db->seconds, "expected time is in db", 0.1);
//        $this->seeInDatabase('grading_times', ['exam_id' => $gt->exam_id, 'student_id' => $gt->student_id, 'seconds' => $newTime]);
    }

    /** @test */
    public function getTimesForExamByGradedOrder()
    {
        //call
        $result = $this->object->getTimesForExamByGradedOrder($this->exam->id);

        //check
        $this->assertInstanceOf(Collection::class, $result, "Returns a laravel collection");

        $prior = null;
        $studentIds = [];
        //Check that properly ordered
        foreach ( $result as $r )
        {
            $this->assertInstanceOf(GradingTime::class, $r, "Items in collection are GradingTime objects");
            //append the student id to the array so can check if got all of them
            $studentIds[] = $r->student_id;

            //check if in expected order
            $currentTime = $r->updated_at;
            if(! is_null($prior)){
                $this->assertTrue($currentTime->gte($prior), "This exam was graded after the exam in the previous element of the result");
            }
            $prior = $currentTime;
            //TODO improve the test data so that all grading times don't have the same updated_at
        }

        //Check that loaded all exams
        foreach ( GradingTime::where('exam_id', $this->exam->id)->get() as $gt )
        {
            $this->assertContains($gt->student_id, $studentIds, "Expected student id was loaded");
        }

    }


}
