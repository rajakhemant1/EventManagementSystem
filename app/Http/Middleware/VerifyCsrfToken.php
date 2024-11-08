<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'talk-proposals/*',
    ];

    protected function tokensMatch($request)
    {
        // Skip CSRF token verification in the testing environment
        if (app()->environment('testing')) {
            return true;
        }

        return parent::tokensMatch($request);
    }
}
