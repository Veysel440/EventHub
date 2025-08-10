<?php

namespace App\Exceptions;

use App\Shared\Exceptions\ApiException;
use App\Shared\Support\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if (!$request->expectsJson()) { return null; }

            if ($e instanceof ValidationException) {
                return response()->json(
                    ApiResponse::error('validation_error', $e->errors()), 422
                );
            }

            if ($e instanceof AuthenticationException) {
                return response()->json(ApiResponse::error('unauthenticated'), 401);
            }

            if ($e instanceof AuthorizationException) {
                return response()->json(ApiResponse::error('forbidden'), 403);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json(ApiResponse::error('not_found'), 404);
            }

            if ($e instanceof ApiException) {
                return response()->json(ApiResponse::error($e->getMessage(), $e->errors), $e->status);
            }

            if ($e instanceof HttpExceptionInterface) {
                return response()->json(ApiResponse::error($e->getMessage()), $e->getStatusCode());
            }

            // fallback
            return response()->json(ApiResponse::error('server_error'), 500);
        });
    }
}
