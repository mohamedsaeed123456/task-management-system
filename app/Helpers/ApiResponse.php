<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse
{
    public static function success(
        string $message = 'Success',
        $data = null,
        int $status = Response::HTTP_OK
    ): JsonResponse {
        $response = [
            'success' => true,
            'status' => $status,
            'message' => $message,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    public static function error(
        string $message = 'Error',
        $errors = null,
        int $status = Response::HTTP_BAD_REQUEST,
        $data = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'status' => $status,
            'message' => $message,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'data' => $data,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    public static function created(string $message = 'Created', $data = null): JsonResponse
    {
        return self::success($message, $data, Response::HTTP_CREATED);
    }

    public static function validationError($errors, string $message = 'Validation Error'): JsonResponse
    {
        return self::error($message, $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function notFound(string $message = 'Not Found'): JsonResponse
    {
        return self::error($message, null, Response::HTTP_NOT_FOUND);
    }
}