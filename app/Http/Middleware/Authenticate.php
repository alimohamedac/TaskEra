<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /*public function handle($request, Closure $next) {
        // check if we have an X-Authorization header present
        if($auth = $request->header('X-Authorization')) {
            $request->headers->set('Authorization', $auth);
        }

        return $next($request);
    }*/
}
