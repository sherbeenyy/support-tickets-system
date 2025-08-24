<?php

namespace App\Services;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $users) {}

    public function getAllUsers()
    {
        return $this->users->all();
    }

    public function createUser(CreateUserDTO $dto): User
    {
        return $this->users->create($dto->toArray());
    }

    public function updateUser(UpdateUserDTO $dto): User
    {
        $user = $this->users->findByIdOrFail($dto->id);
        return $this->users->update($user, $dto->toArray());
    }

    public function deleteUser(int $id): void
    {
        $user = $this->users->findByIdOrFail($id);

        if ($user->is_super_admin) {
            throw new \RuntimeException('Super Admin cannot be deleted.');
        }

        $this->users->delete($user);
    }
}
