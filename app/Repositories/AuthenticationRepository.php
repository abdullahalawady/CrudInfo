<?php

namespace App\Repositories;

use App\Interfaces\AuthenticationRepositoryInterface;
use App\Models\User;

class AuthenticationRepository implements AuthenticationRepositoryInterface
{
    public function register($data)
    {
       return   User::create($data);
    }
    public function login($request)
    {

    }

}
