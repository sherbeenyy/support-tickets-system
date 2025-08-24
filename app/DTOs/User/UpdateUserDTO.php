<?php

namespace App\DTOs\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UpdateUserDTO
{
    public function __construct(
        public int $id,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $role = null,
    ) {}

    public static function fromRequest(int $id, $request): self
    {
        return new self(
            id: $id,
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
            role: $request->get('role'),
        );
    }

    public static function fromArray(int $id, array $data): self
    {
        return new self(
            id: $id,
            name: Arr::get($data, 'name'),
            email: Arr::get($data, 'email'),
            password: Arr::get($data, 'password'),
            role: Arr::get($data, 'role'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name'     => $this->name,
            'email'    => $this->email,
            'role'     => $this->role,
            'password' => $this->password ? Hash::make($this->password) : null,
        ], fn ($v) => !is_null($v));
    }

    public static function rules(int $id): array
    {
        return [
            'name'     => 'sometimes|string|max:255',
            'email'    => "sometimes|email|unique:users,email,{$id}",
            'password' => 'sometimes|string|min:8|nullable',
            'role'     => 'sometimes|string|in:admin,engineer,user',
        ];
    }
}
