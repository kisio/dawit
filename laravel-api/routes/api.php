<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

// Register & Login (Public routes)
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (Require authentication with Sanctum)
Route::group(['middleware' => 'auth:sanctum'], function () {
    // CRUD operations for tasks
    Route::get('/tasks', [TaskController::class, 'index']); // Get all tasks
    Route::post('/tasks', [TaskController::class, 'store']); // Create a new task
    Route::put('/tasks/{id}', [TaskController::class, 'update']); // Update an existing task
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // Delete a task

    // Logout (Log out the authenticated user)
    Route::post('/logout', [UserController::class, 'logout']);
});

// Route to get the authenticated user 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

