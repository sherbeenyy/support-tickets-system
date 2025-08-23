<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Engineer\TicketController;
use App\Http\Controllers\CommentController;



// Homepage (login page)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Handle login form submission
Route::post('/', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web');

// Protected dashboards
Route::prefix('admin')->middleware(['auth:web', 'role:admin,super_admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // Users management
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');

});

Route::middleware(['auth:web', 'role:tech_lead,engineer'])->group(function () {
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/tickets/{ticket}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});



Route::middleware(['auth:web', 'role:engineer'])->prefix('engineer')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'index'])->name('engineer.dashboard');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});





