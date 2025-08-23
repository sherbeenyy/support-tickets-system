<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;
use App\Enums\RoleEnum;
use App\Http\Controllers\Admin\UserManagementController;


// Auth routes (open to everyone)
Route::post('/login', [AuthController::class, 'loginApi']);

//Protected routes (JWT required)
Route::middleware('auth:api')->group(function () {

//admin only routes
Route::middleware(['auth:api', 'role:admin'])->prefix('admin/users')->group(function () {
    Route::get('/getall', [UserManagementController::class, 'index']);   // List users
    Route::post('/create', [UserManagementController::class, 'store']);  // Create user
    Route::put('/{id}', [UserManagementController::class, 'update']); // Update info
    Route::delete('/{id}', [UserManagementController::class, 'destroy']); // Delete
});

    // Engineer-only route
    Route::get('/engineer/dashboard', function () {
        return response()->json(['message' => 'Welcome Engineer!']);
    })->middleware('role:' . RoleEnum::Engineer->value);

    // Tech Lead-only route
    Route::get('/techlead/dashboard', function () {
        return response()->json(['message' => 'Welcome Tech Lead!']);
    })->middleware('role:' . RoleEnum::TechLead->value);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
