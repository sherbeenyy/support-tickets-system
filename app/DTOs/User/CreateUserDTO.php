<?php

namespace App\DTOs\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $role,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            role: $request->get('role'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: Arr::get($data, 'name'),
            email: Arr::get($data, 'email'),
            password: Arr::get($data, 'password'),
            role: Arr::get($data, 'role'),
        );
    }

    public function toArray(): array
    {
        return [
            'name'  => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ];
    }

    public static function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:admin,engineer,user',
        ];
    }
}
