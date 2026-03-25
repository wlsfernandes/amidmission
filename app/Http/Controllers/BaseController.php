<?php

namespace App\Http\Controllers;

use App\Services\SystemLogger;
use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    protected function success(string $message, array $data = [], int $code = 200): JsonResponse
    {
        SystemLogger::log($message, 'info', request()->route()?->getName());

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error(string $message, \Throwable $e = null, int $code = 500): JsonResponse
    {
        SystemLogger::log(
            $message,
            'error',
            request()->route()?->getName(),
            $e ? [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ] : []
        );

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
