<?php

namespace App\Traits;

trait ApiResponse
{
    public function responseMessage($status, $message, $code = 200)
    {
        return response()->json(
        [
            'status'  => $status,
            'message' => $message
        ],
        $code);
    }

    public function responseData($status, $data)
    {
        return response()->json(
        [
            'status' => $status,
            'data'   => $data
        ],
        200);
    }

    public function responseToken($data, $token)
    {
        return response()->json(
        [
            'status' => 'Success',
            'data'   => $data,
            'token'  => $token
        ],
        200);
    }

    public function successResponse($message)
    {
        return response(
        [
            'status'  => 'Success',
            'message' => $message
        ],
        200);
    }    
}