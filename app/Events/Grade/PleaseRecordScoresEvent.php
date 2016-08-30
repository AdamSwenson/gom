<?php

namespace App\Events\Grade;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PleaseRecordScoresEvent
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var Exam
     */
    private $exam;
    /**
     * @var GradingRequest
     */
    private $request;

    /**
     * Create a new event instance.
     *
     * @param Exam $exam
     * @param GradingRequest $request
     */
    public function __construct(Exam $exam, GradingRequest $request)
    {
        //
        $this->exam = $exam;
        $this->request = $request;
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
