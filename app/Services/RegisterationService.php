<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Exceptions\UserAlreadyExistsException;
use App\Helpers\ResponseHelper;
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

        return ResponseHelper::createRegistrationResponse($user, $token);
    }

    public function loginService($request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            throw new UnauthorizedException();
        }

        $user = Auth::user();

        return ResponseHelper::createLoggingResponse($user, $token);
    }
}
