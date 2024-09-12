<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function login($request)
    {
        $user = User::where('user_name', $request->input('user_name'))->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return 'wrong cradintials';
        }
        $user->token = $user->createToken('token-name', ['server:update'])->plainTextToken;
        return $user;
    }

}
