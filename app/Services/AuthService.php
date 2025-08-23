<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function register(array $data)
    {
        // hash password + ensure enum conversion
        $data['password'] = Hash::make($data['password']);
        $data['role'] = RoleEnum::from($data['role']);

        return $this->users->create($data);
    }

    public function login(array $credentials)
    {
        if (!$token = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        return [
            'token' => $token,
            'user'  => auth('api')->user(),
        ];
    }

    public function logout()
    {
        auth('api')->logout();
    }
}
