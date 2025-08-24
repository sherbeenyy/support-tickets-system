<?php

namespace App\Http\Controllers\Admin\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\UserService;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;

class ApiUserController extends Controller
{
    public function __construct(private UserService $service) {}

    public function Apiindex()
    {
        return response()->json([
            'status' => true,
            'data'   => $this->service->getAllUsers(),
        ]);
    }

    public function Apistore(StoreUserRequest $request)
    {
        $dto  = CreateUserDTO::fromRequest($request);
        $user = $this->service->createUser($dto);

        return response()->json([
            'status'  => true,
            'message' => 'User created successfully.',
            'data'    => $user,
        ], 201);
    }

    public function Apiupdate(UpdateUserRequest $request, int $id)
    {
        $dto  = UpdateUserDTO::fromRequest($id, $request);
        $user = $this->service->updateUser($dto);

        return response()->json([
            'status'  => true,
            'message' => 'User updated successfully.',
            'data'    => $user,
        ]);
    }


    public function Apidestroy(int $id)
    {
        try {
            $this->service->deleteUser($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found.',
            ], 404);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 403);
        }

        return response()->json([
            'status'  => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
