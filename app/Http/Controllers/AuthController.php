<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $user = new User;

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('sanctum-api')->plainTextToken;

        return $this->responseToken($user, $token);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials))
        {
            $user  = auth()->user();
            $token = $user->createToken('sanctum-api')->plainTextToken;

            return $this->responseToken($user, $token);
        }

        return $this->responseMessage('Error', 'Email or password is invalid');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->responseMessage('Success', 'Logout is successfully');
    }
}