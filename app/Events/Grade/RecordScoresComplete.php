<?php

namespace App\Events\Grade;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RecordScoresComplete
{
    use InteractsWithSockets, SerializesModels;
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
        //
        $this->exam = $exam;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
