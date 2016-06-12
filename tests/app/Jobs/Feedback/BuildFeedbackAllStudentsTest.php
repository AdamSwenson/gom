<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 2:11 PM
 */

namespace App\Jobs\Feedback;


use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\FeedbackCompilationFailureEvent;
use App\Exam;
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Student;

class BuildFeedbackAllStudentsTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function test_handle()
    {
        #prep
        $exam = factory(Exam::class)->create();

        $mock = $this->createMock(IFeedbackBuilder::class);
        $mock->shouldReceive('buildFeedback')
            ->once()
            ->with($exam->id)
            ->andReturn('feedback');
        $this->expectsEvents(FeedbackCompilationCompleteEvent::class);

        #call
        $this->object = new BuildFeedbackAllStudents($exam);
        $this->object->handle();
    }


    /** @test */
    public function handleFailureCase()
    {
        #prep
        $exam = factory(Exam::class)->create();

        $mock = $this->createMock(IFeedbackBuilder::class);
        $mock->shouldReceive('buildFeedback')
            ->once()
            ->with($exam->id);
        $this->expectsEvents(FeedbackCompilationFailureEvent::class);

        #call
        $this->object = new BuildFeedbackAllStudents($exam);
        $this->object->handle();
    }

}
