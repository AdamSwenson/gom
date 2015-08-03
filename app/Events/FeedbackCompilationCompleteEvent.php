<?php

namespace App\Events;

use App\Events\Event;
use App\Exam;
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
    /**
     * @var Exam
     */
    private $exam;

    /**
     * Create a new event instance.
     *
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
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
