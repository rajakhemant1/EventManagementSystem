<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedSpeaker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the speaker is authenticated
        if (Auth::guard('speaker')->check()) {
            // Redirect to speaker's dashboard if already logged in
            return redirect()->route('speaker.dashboard');
        }

        // Allow request to proceed if not authenticated
        return $next($request);
    }
}
