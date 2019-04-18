<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogAllRequests
{
    private $logger;

    public function __construct(  )
    {
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    public function handle( Request $request, Closure $next )
    {

//        if ( $this->app->environment('local', 'testing') ) {

        Log::info('Dump request',
            [
                'request' => $request,
            ]);
//    }
        return $next($request);

    }
}
