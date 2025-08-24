<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Enums\RoleEnum;
use App\Http\Controllers\Admin\Apis\ApiUserController;
use App\Http\Controllers\Engineer\Api\ApiTicketController;



Route::post('/login', [AuthController::class, 'loginApi']);

//jwt required 
Route::middleware('auth:api')->group(function () {
//admin only routes
    Route::prefix("admin/users")->middleware([ 'role:' . RoleEnum::Admin->value])->group(function () {
        Route::get('/getall', [ApiUserController::class, 'Apiindex']);
        Route::post('/create', [ApiUserController::class, 'Apistore']);
        Route::put('/{user}', [ApiUserController::class, 'Apiupdate']);
        Route::delete('/{user}', [ApiUserController::class, 'Apidestroy']);
    });
//engineers only routes
    Route::prefix("engineer")->middleware(['role:' . RoleEnum::Engineer->value])->group(function () {
        Route::get('/tickets', [ApiTicketController::class, 'index']);
        Route::post('/tickets', [ApiTicketController::class, 'store']);
        Route::get('/tickets/{id}', [ApiTicketController::class, 'show']);
        Route::put('/tickets/{ticket}', [ApiTicketController::class, 'update']);
        Route::delete('/tickets/{ticket}', [ApiTicketController::class, 'destroy']);
    });


    // Tech Lead-only route
    Route::get('/techlead/dashboard', function () {
        return response()->json(['message' => 'Welcome Tech Lead!']);
    })->middleware('role:' . RoleEnum::TechLead->value);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
