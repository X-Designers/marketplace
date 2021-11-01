<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckReviewerStatus
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
        if (Auth::guard('reviewer')->check()) {
            $reviewer = Auth::guard('reviewer')->user();
            if ($reviewer->status && $reviewer->tv  && $reviewer->sv && $reviewer->ev) {
                return $next($request);
            } else {
                return redirect()->route('reviewer.authorization');
            }
        }
        abort(403);
    }
}
