<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function createRegistrationResponse($data, $token)
    {
        return [
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $data,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];
    }

    public static function createLoggingResponse($data, $token)
    {
        return [
            'status' => 'success',
            'user' => $data,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];
    }

    public static function createResponse($data)
    {
        return [
            'status' => 'success',
            'message' => 'created successfully',
            'data' => $data,
        ];
    }

    public static function showResponse($data)
    {
        return [
            'status' => 'success',
            'message' => 'showed successfully',
            'data' => $data,
        ];
    }

    public static function updateResponse($data)
    {
        return [
            'status' => 'success',
            'message' => 'update successfully',
            'data' => $data,
        ];
    }

    public static function deleteResponse()
    {
        return [
            'status' => 'success',
            'message' => 'delete successfully',
        ];
    }
}
