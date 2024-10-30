<?php

namespace App\Services;

use App\Exceptions\UserAlreadyExistsException;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\Eloquent\RegisterRepository;
use App\Repository\Eloquent\UserRepository;
use App\Traits\HandlesExceptions;
use App\Traits\JWTTokenTrait;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterationService
{
    use JWTTokenTrait;

    private $RegisterRepository;

    public function __construct(RegisterRepository $RegisterRepository)
    {
        $this->RegisterRepository = $RegisterRepository;
    }

    public function registerService($request)
    {
        $user = $this->RegisterRepository->findByEmail($request->email);

        if ($user) {
            throw  new UserAlreadyExistsException();
        }
        $user = $this->RegisterRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $this->generateJWTToken($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function loginService($request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
}
