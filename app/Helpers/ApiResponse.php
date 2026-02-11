<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = "Success", int $code = 200): JsonResponse
    {
        return response()->json([
            "success" => true,
            "message" => $message,
            "data" => $data,
        ], $code);
    }

    public static function error(string $message = "Error", $errors = null, int $code = 422): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
            "errors" => $errors,
        ], $code);
    }
}
