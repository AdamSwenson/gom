<?php

namespace App\Events;

use App\Jobs\Job;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class AsyncJobCompleteEvent
 * Emitted by asynchronously running events upon completion
 *
 * @package App\Events
 */
class AsyncJobCompleteEvent
{
    use InteractsWithSockets, SerializesModels;
    public $job;

    /**
     * @var bool
     */
    public $success;
    /**
     * @var array
     */
    public $payload;

    /**
     * Create a new event instance.
     *
     * @param Job $job
     * @param bool $success
     * @param array $payload
     */
    public function __construct(Job $job, $success=false, $payload=[])
    {
        $this->job = $job;
        $this->success = $success;
        $this->payload = $payload;
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
