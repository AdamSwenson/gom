<?php

namespace App\Http\Middleware;

use Closure;

class TranslateItem
{
    /**
     * For requests to the Item controller, we inject
     * the correct OG model (Question, Exam, Element)
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //

        return $next($request);
    }
}
