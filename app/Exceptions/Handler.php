<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle API exceptions using our global ApiResponse
     */
    public function handleApiException(Throwable $exception)
    {
        // Validation errors (422)
        if ($exception instanceof ValidationException) {
            return ApiResponse::validationError(
                $exception->errors(),
                'Validation Error'
            );
        }

        // Model not found (404)
        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::notFound('Resource not found');
        }

        // 404 Not Found
        if ($exception instanceof NotFoundHttpException) {
            return ApiResponse::notFound('Page not found');
        }

        // Unauthorized (401)
        if ($exception instanceof UnauthorizedHttpException) {
            return ApiResponse::error('Unauthorized', null, 401);
        }

        // Unauthenticated (401)
        if ($exception instanceof AuthenticationException) {
            return ApiResponse::error('Unauthenticated', null, 401);
        }
    
        // Forbidden (403)
        if ($exception instanceof AccessDeniedHttpException) {
            return ApiResponse::error('Forbidden', null, 403);
        }

        // Server errors (500)
        if (app()->environment('production')) {
            return ApiResponse::error('Internal server error', null, 500);
        }

        // Development: Show actual error
        return ApiResponse::error(
            'Development error: ' . $exception->getMessage(),
            null,
            500
        );
    }
}