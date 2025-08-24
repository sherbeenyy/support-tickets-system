<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\UserService;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;

class UserManagementController extends Controller
{
    public function __construct(private UserService $service) {}

    public function index()
    {
        $users = $this->service->getAllUsers();
        return view('admin.users', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

// Admin\UserManagementController

    public function store(StoreUserRequest $request)
    {
        $dto = CreateUserDTO::fromRequest($request);
        $this->service->createUser($dto);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $dto = UpdateUserDTO::fromRequest($user->id, $request);
        $this->service->updateUser($dto);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }


    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }


    public function destroy(User $user)
    {
        try {
            $this->service->deleteUser($user->id);
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
