<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return jsonResponse(null, 401, 'Uauthenticated');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ($jwt = $request->cookie('access_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}