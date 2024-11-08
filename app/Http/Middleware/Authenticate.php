<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Redirect to the custom login route if this is a reviewer request
            if ($request->is('reviewer/*')) {
                return route('reviewer.login');
            }

            // Default to main login route for regular users (if defined)
            return route('reviewer.login');
        }
    }
}
