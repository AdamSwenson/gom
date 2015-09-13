<?php

namespace App\Events;

use App\Events\Event;
use App\Exam;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * DEPRECATED
 * DOES NOT REALLY MAKE SENSE TO RUN THIS VIA LISTENERS SINCE THERE'S ONLY
 * ONE THING THAT NEEDS TO LISTEN. RATHER, BETTER TO DISPATCH DIRECTLY TO QUEUE
 * AND THEN LET THE LATER EVENT BE RESPONSIBLE FOR THE NEXT STEPS
 *
 * HOWEVER, NOT GOING TO DELETE THIS EVENT OR PREVENT IT FROM BEING FIRED YET.
 * FUTURE NEEDS MAY MAKE USE OF IT.
 *
 * Event which fires when the user clicks 'release exam'
 *
 * (LIES: ) The various listeners will compile feedback and then handle notifications
 *
 * @package App\Events
 */
class ExamReleasedEvent extends Event
{
    use SerializesModels;

    public $exam;

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
