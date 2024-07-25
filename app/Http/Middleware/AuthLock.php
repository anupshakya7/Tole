<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AuthLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
	{
		//dd(\Auth::user()->getLockoutTime());
		if(!\Auth::user()){
		   return $next($request);
		}
		// If the user does not have this feature enabled, then just return next. 
		if (!\Auth::user()->hasLockoutTime()) {
			//dd(\Auth::user()->getLockoutTime());
			// Check if previous session was set, if so, remove it because we don't need it here.
			if (session('lock-expires-at')) {
				session()->forget('lock-expires-at');
			}

			return $next($request);
		}

		if ($lockExpiresAt = session('lock-expires-at')) {
			if ($lockExpiresAt < now()) {
				return redirect()->route('locked');
			}
		}

		session(['lock-expires-at' => now()->addMinutes(\Auth::user()->getLockoutTime())]);

		return $next($request);
	}
}