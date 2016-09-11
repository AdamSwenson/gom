<?php

namespace App\Listeners\Ajax;

use App\Events\Ajax\PleaseSendAjaxFail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

/**
 * Class PleaseSendAjaxFailListener
 * Listens for the request to send a failure message to the client using ajax and
 * then sends the message upon hearing the event.
 *
 * @package App\Listeners\Ajax
 */
class PleaseSendAjaxFailListener
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
     * @param  PleaseSendAjaxFail $event
     * @return void
     */
    public function handle(PleaseSendAjaxFail $event)
    {


        $sendMessage = $event->message ? $event->message : 'failure';
        $response = [
            'status'  => 'fail',
            'message' => $sendMessage,
        ];

        if ( ! is_null($event->jsonCargo) && is_array($event->jsonCargo) )
        {
            foreach ( $event->jsonCargo as $k => $v )
            {
                $response[ $k ] = $v;
            }
        }

        Log::info('PleaseSendAjaxFailListener called | ' . $event->source . '  | ' . json_encode($response));
        return Response::json($response);

    }
}
