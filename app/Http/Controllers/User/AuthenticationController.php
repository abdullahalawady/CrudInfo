<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthenticationService;

class AuthenticationController extends BaseController
{
    public $authenticationService;
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;

    }
    public function register(RegisterRequest $request)
    {
        $res = $this->authenticationService->register($request);
        return $res != 'faild' ? $this->respondData(new UserResource($res), 'Sign Up Successfully') : $this->respondError('something Error');
    }
    public function login(LoginRequest $request)
    {
        $res = $this->authenticationService->login($request);
        return $res != 'wrong cradintials' ? new UserResource($res) : $this->respondError('Wrong creaintails');
    }
}
