<?php

namespace App\Events;

use App\Events\Event;
use App\Exam;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class ExamReleased
 * Event which fires when the user clicks 'release exam'
 *
 * The various listeners will compile feedback and then handle notifications
 *
 * @package App\Events
 */
class ExamReleased extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
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
