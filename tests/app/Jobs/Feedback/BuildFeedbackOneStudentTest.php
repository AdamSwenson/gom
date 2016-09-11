<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 12:17 PM
 */

namespace App\Jobs\Feedback;


use App\Events\FeedbackCompilationCompleteEvent;
use App\Events\FeedbackCompilationFailureEvent;
use App\Exam;
use App\Repositories\Feedback\IFeedbackBuilder;
use App\Student;

class BuildFeedbackOneStudentTest extends \TestCase
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
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();

        $mock = $this->createMock(IFeedbackBuilder::class);
        $mock->shouldReceive('recompileFeedbackForStudent')
            ->once()
            ->with($exam->id, \Mockery::type(Student::class))
            ->andReturn('feedback');
        $this->expectsEvents(FeedbackCompilationCompleteEvent::class);

        $this->object = new BuildFeedbackOneStudent($exam, $student);
        dispatch($this->object);
    }


    /** @test */
    public function handleFailureCase()
    {
        $exam = factory(Exam::class)->create();
        $student = factory(Student::class)->create();

        $mock = $this->createMock(IFeedbackBuilder::class);
        $mock->shouldReceive('recompileFeedbackForStudent')
            ->once()
            ->with($exam->id, \Mockery::type(Student::class));
        $this->expectsEvents(FeedbackCompilationFailureEvent::class);
        $this->object = new BuildFeedbackOneStudent($exam, $student);
//        $this->object->handle();
        dispatch($this->object);
    }
}
