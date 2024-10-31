<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\RegisterationService;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    private $registerationService;

    public function __construct(RegisterationService $registerationService)
    {
        $this->registerationService = $registerationService;
    }

    public function register(UserRegisterRequest $request)
    {
        return $this->registerationService->registerService($request);
    }

    public function login(UserLoginRequest $request)
    {
        return $this->registerationService->loginService($request);
    }
}
