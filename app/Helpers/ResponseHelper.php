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
}
