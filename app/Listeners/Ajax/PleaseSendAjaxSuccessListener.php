<?php

namespace App\Listeners\Ajax;

use App\Events\Ajax\PleaseSendAjaxSuccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

/**
 * Listens for the request to send a failure message to the client using ajax and
 * then sends the message upon hearing the event.
 */
class PleaseSendAjaxSuccessListener
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
     * @param  PleaseSendAjaxSuccess  $event
     */
    public function handle(PleaseSendAjaxSuccess $event)
    {
        $sendMessage = $event->message ? $event->message : 'success';
        $response = [
            'status' => 'success',
            'message' => $sendMessage
        ];

        if ( ! is_null($event->jsonCargo) && is_array($event->jsonCargo) )
        {
            foreach ( $event->jsonCargo as $k => $v )
            {
                $response[ $k ] = $v;
            }
        }

        Log::info('PleaseSendAjaxSuccessListener called | ' . $event->source . '  | ' . json_encode($response));
return response()->json($response);
//            return Response::json($response);

    }
}
