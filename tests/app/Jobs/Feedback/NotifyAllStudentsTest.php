<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 2:20 PM
 */

namespace App\Jobs\Feedback;


use App\Events\StudentNotificationCompleteEvent;
use App\Exam;

class NotifyAllStudentsTest extends \TestCase
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
        $mock = $this->createMock(INotifyStudentsHelper::class);
        $mock->shouldReceive('sendEmailToAllGradedStudents')
            ->once()
            ->with(\Mockery::type(Exam::class));
        $this->expectsEvents(StudentNotificationCompleteEvent::class);

        #call
        $this->object = new NotifyAllStudents($exam);
        $this->object->handle();
    }



    public function handleFailureCase()
    {
        //TODO Add error handing
//        $exam1 = factory(Exam::class)->create();
//        $student = factory(Student::class)->create();
//
//        $mock = $this->createMock(IFeedbackBuilder::class);
//        $mock->shouldReceive('recompileFeedbackForStudent')
//            ->once()
//            ->with($exam1->id, \Mockery::type(Student::class));
//        $this->expectsEvents(FeedbackCompilationFailureEvent::class);
//        $this->object = new BuildFeedbackOneStudent($exam1, $student);
//        $this->object->handle();
    }

}
