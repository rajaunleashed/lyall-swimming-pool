<?php


namespace App\Utilities;


use Illuminate\Http\JsonResponse;

class Helper
{
    public static function successResponse($message, $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function errorResponse($message)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ]);
    }
}
