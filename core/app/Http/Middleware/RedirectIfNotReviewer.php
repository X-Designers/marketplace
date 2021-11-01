<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotReviewer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'reviewer')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('reviewer.login');
        }
        return $next($request);
    }
}
