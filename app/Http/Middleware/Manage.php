<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Manage
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
        if(Auth::check()) {
            if(Auth::user()->is_active) {
                if(Auth::user()->hasRole() || (Auth::user()->vendor && Auth::user()->vendor->approved)) {
                    return $next($request);
                } else {
                    return redirect('/');
                }
            }
        }

        return abort(404);
    }
}
