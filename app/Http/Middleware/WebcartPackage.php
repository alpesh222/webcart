<?php

namespace App\Http\Middleware;

use Closure;

class WebcartPackage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(config('settings.webcart_package') === '1') {
            return $next($request);
        }
        return $next($request);
//return redirect(route('webcart.activate'));
    }
}
