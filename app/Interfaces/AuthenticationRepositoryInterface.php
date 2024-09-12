<?php

namespace App\Interfaces;

interface AuthenticationRepositoryInterface
{
    public function register($request);
    public function login($request);

}
