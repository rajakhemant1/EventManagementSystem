<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ReviewerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isReviewer()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied.');
    }
}
