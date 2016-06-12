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
use App\Student;

class NotifySingleStudentTest extends \TestCase
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
        $student = factory(Student::class)->create();

        $mock = $this->createMock(INotifyStudentsHelper::class);
        $mock->shouldReceive('sendEmailToStudent')
            ->once()
            ->with(\Mockery::type(Exam::class), \Mockery::type(Student::class));

        $this->expectsEvents(StudentNotificationCompleteEvent::class);

        #call
        $this->object = new NotifySingleStudent($exam, $student);
        $this->object->handle();
    }



    public function handleFailureCase()
    {
        //TODO Add error handing
//        $exam = factory(Exam::class)->create();
//        $student = factory(Student::class)->create();
//
//        $mock = $this->createMock(IFeedbackBuilder::class);
//        $mock->shouldReceive('recompileFeedbackForStudent')
//            ->once()
//            ->with($exam->id, \Mockery::type(Student::class));
//        $this->expectsEvents(FeedbackCompilationFailureEvent::class);
//        $this->object = new BuildFeedbackOneStudent($exam, $student);
//        $this->object->handle();
    }

}
