<?php
namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait JWTTokenTrait
{
    public function generateJWTToken($user)
    {
        $token = JWTAuth::fromUser($user);
        return $token;
    }
}
