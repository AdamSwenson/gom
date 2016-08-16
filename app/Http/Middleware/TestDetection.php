<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class TestDetection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //equiv to $this->app->environment() == 'codeceptWorld' )
        if ( App::environment('codeceptWorld') || isset($_COOKIE['selenium_request']) )
        {

            if ( isset($_COOKIE['selenium_auth']) )
            {
                Auth::loginUsingId((int) $_COOKIE['selenium_auth']);
            }
        }

        return $next($request);
    }
}
