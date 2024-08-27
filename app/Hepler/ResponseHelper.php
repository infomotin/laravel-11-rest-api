<?php

namespace App\Hepler;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    //  *FUNCIONES DE success
    //  *@param string $status
    //  *@param string $message
    //  *@param string $data
    //  *@param string $statusCode
    //  *
    //  *
    //  *
    //  *


    public static function success($status = null, $message = null, $data = null, $statusCode = 200){

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error($status = null, $message = null, $data = null, $statusCode = 400){

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
     }
}

