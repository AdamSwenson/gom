<?php

namespace App\Events\Ajax;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class PleaseSendAjaxSuccess
 * Represents a request to send a success message to the client via ajax
 *
 * @package App\Events\Ajax
 */
class PleaseSendAjaxSuccess
{
    use InteractsWithSockets, SerializesModels;
    public $message;
    public $jsonCargo;
    public $source;

    /**
     * Create a new event instance.
     * source will usually be self::class
     * JsonCargo should be a non-json-encoded array
     * @param $message String message
     * @param $jsonCargo JsonCargo should be a non-json-encoded array
     */
    public function __construct($source=null, $message = null, $jsonCargo = null)
    {
        $this->message = $message;
        $this->jsonCargo = $jsonCargo;
        $this->source = $source;
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
