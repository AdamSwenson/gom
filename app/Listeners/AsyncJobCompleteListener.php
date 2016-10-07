<?php

namespace App\Listeners;

use App\Events\AsyncJobCompleteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AsyncJobCompleteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AsyncJobCompleteEvent $event
     * @return void
     */
    public function handle(AsyncJobCompleteEvent $event)
    {
        $status = $event->success ? 'success' : 'fail';
        $payload = $event->payload ? $event->payload : false;

        $jobName = " | Job: "; //. $event->job->getName();
        $statusMessage = " | status: " . $status;
        $payloadMessage = $payload ? " | payload: " . $payload : '';
        Log::info("Asynchronous job completed " . $jobName . $statusMessage . $payloadMessage);

    }
}
