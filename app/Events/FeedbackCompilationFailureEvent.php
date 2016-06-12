<?php

namespace App\Events;

use App\Events\Event;
use App\Exam;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FeedbackCompilationFailureEvent extends Event
{
    use SerializesModels;
    /**
     * @var Exam
     */
    private $exam;

    /** @var  Holds the exception caught */
    public $exception;

    /**
     * Create a new event instance.
     *
     * @param Exam $exam
     * @param $exception
     */
    public function __construct(Exam $exam, $exception = null)
    {
        $this->exam = $exam;
        $this->exception = $exception;
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
