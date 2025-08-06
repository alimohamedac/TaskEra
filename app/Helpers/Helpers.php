<?php

namespace App\Helpers;

class Helpers
{
    /**
     * Return a standard JSON response.
     */
    public static function jsonResponse($success, $data = null, $message = null, $statusCode = 200)
    {
        $response = [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];

        $response = array_filter($response, function($value) {
            return !is_null($value);
        });

        return response()->json($response, $statusCode);
    }
}
