<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repository\Eloquent\RegisterRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterService
{
    private $RegisterRepository;

    public function __construct(RegisterRepository $RegisterRepository)
    {
        $this->RegisterRepository = $RegisterRepository;
    }

}
