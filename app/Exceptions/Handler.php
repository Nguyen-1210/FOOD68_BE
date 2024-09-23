<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException as ExceptionsUnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ExceptionsUnauthorizedException $e, $request) {
          return jsonResponse(null, 403, $e->getMessage());
      });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return jsonResponse(null, 401, $exception->getMessage());
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        if ($e instanceof ModelNotFoundException) {
            $model = class_basename($e->getModel());
            return jsonResponse($e->getMessage(), 404, $model . ' Not Found');
        }

        return parent::render($request, $e);
    }

    // public function render($request, Throwable $exception): JsonResponse|Response
    // {
    //   // dd($exception);
    //     if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
    //         return response()->json(['error' => 'Token is Expired'], 401);
    //     } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
    //         return response()->json(['error' => 'Token is Invalid'], 400);
    //     } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
    //         return response()->json(['error' => 'Token is Blacklisted'], 403);
    //     } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
    //         return response()->json(['error' => 'Authorization Token not found'], 404);
    //     }

    //     return parent::render($request, $exception);
    // }
}