<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            JWTAuth::parseToken()->authenticate();
          } catch (Exception $message) {
            if ($message instanceof TokenInvalidException) {
              return jsonResponse(null, 400, 'Token is Invalid');
            } else if ($message instanceof TokenExpiredException) {
              return jsonResponse(null, 401, 'Token is Expired');
            } else if ($message instanceof TokenBlacklistedException) {
              return jsonResponse(null, 403, 'Token is Blacklisted');
            } else {
              return jsonResponse(null, 404, 'Authorization Token not found');
            }
          }
          return $next($request);
    }

}