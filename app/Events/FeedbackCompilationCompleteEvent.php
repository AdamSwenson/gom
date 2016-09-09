<?php

namespace App\Events;

use App\Events\Event;
use App\Exam;
use App\Student;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class FeedbackCompilationCompleteEvent
 *
 * Fires when student feedback has been compiled
 *
 * @package App\Events
 */
class FeedbackCompilationCompleteEvent extends Event
{
    use SerializesModels;
    protected $student;
    /**
     * @var Exam
     */
    private $exam;

    /**
     * Create a new event instance.
     *
     * @param Exam $exam
     * @param null|Student $student
     */
    public function __construct(Exam $exam, $student=null)
    {
        $this->exam = $exam;
        if($student){
            $this->student = $student;
        }
    }

    /**
     * Whether the feedback compilation event was for a single student
     * instead of for all students
     * @return bool
     */
    public function wasForSingleStudent(){
        if($this->student){
            return true;
        }
        return false;
    }

    /**
     * Whether the feedback compilation event was for all students
     * or just or a single student
     * @return bool
     */
    public function wasForAllStudents(){
        return ! $this->wasForSingleStudent();
    }


    public function getExamId()
    {
        return $this->exam->getId();
    }

    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
