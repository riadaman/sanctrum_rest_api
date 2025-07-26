<?php

namespace App\Helper;

class ResponseHelper
{
    public static function success($data, $message = '', $status = 'success', $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = '', $status = 'error', $code = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null
        ], $code);
    }
}
