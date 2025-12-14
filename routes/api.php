<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//* Task Routes */
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
// you can replace above with resource route
// Route::apiResource('tasks', TaskController::class);

// Profiles Routes
Route::apiResource('profiles', ProfileController::class);
//
Route::get('user/{id}/profile', [UserController::class, 'getProfile']);
//
Route::get('user/{id}/tasks', [UserController::class, 'getTasks']);
Route::get('task/{id}/user', [TaskController::class, 'getTaskUser']);
// Routes for Categories and Tasks
Route::post('task/{id}/categories', [TaskController::class, 'assignCategories']);
Route::get('task/{id}/categories', [TaskController::class, 'getTaskCategories']);




// Route::get('welcome', [WelcomeController::class, 'index']);
// Route::get('user/{id}', [UserController::class, 'checkUser']);
