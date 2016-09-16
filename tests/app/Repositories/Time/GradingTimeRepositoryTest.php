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
use Illuminate\Support\Collection;

class GradingTimeRepositoryTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new GradingTimeRepository;
        $this->gt = factory(GradingTime::class)->create();
        $this->exam = $this->gt->exam;
        //Exam::where('id', self::$examId)->first();

    }

    public function testLoad()
    {
        //$gt = GradingTime::all()->random();
        $result = $this->object->load($this->gt->exam_id, $this->gt->student_id);

        $this->assertInstanceOf('App\GradingTime', $result, "GradingTime type object loads");
        $this->assertEquals($this->gt->exam_id, $result->exam_id);
        $this->assertEquals($this->gt->student_id, $result->student_id);
        $this->assertEquals($this->gt->seconds, $result->seconds);
    }

    public function testRecord()
    {
        $newTime = $this->faker->randomFloat(3, 0, 100);
        //$this->gt = GradingTime::all()->random();
        $result = $this->object->record($this->gt->exam_id, $this->gt->student_id, $newTime);

        $db = GradingTime::where('exam_id', $this->gt->exam_id)->where('student_id', $this->gt->student_id)->first();
        $this->assertEquals($newTime, $db->seconds, "expected time is in db", 0.1);
//        $this->seeInDatabase('grading_times', ['exam_id' => $this->gt->exam_id, 'student_id' => $this->gt->student_id, 'seconds' => $newTime]);
    }

    public function testUpdate()
    {
        //$this->gt = factory(GradingTime::class)->create();
//        $this->gt = GradingTime::all()->random();
        $newTime = $this->gt->seconds + $this->faker->randomFloat(2, 0, 100);

        $result = $this->object->update($this->gt->exam_id, $this->gt->student_id, $newTime);

        $db = GradingTime::where('exam_id', $this->gt->exam_id)->where('student_id', $this->gt->student_id)->first();
        $this->assertEquals($newTime, $db->seconds, "expected time is in db", 0.001);
//        $this->seeInDatabase('grading_times', ['exam_id' => $this->gt->exam_id, 'student_id' => $this->gt->student_id, 'seconds' => $newTime]);
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
            if ( ! is_null($prior) )
            {
                $this->assertTrue($currentTime->gte($prior), "This exam was graded after the exam in the previous element of the result");
            }
            $prior = $currentTime;
            //TODO improve the test data so that all grading times don't have the same updated_at
        }

        //Check that loaded all exams
        foreach ( GradingTime::where('exam_id', $this->exam->id)->get() as $this->gt )
        {
            $this->assertContains($this->gt->student_id, $studentIds, "Expected student id was loaded");
        }

    }


}
