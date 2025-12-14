<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User Auth Routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
//* Task Routes */
Route::prefix('tasks')->group(function(){
Route::post('/', [TaskController::class, 'store']);
Route::get('/', [TaskController::class, 'index']);
//Admin only routes
Route::get('/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUserRole');
//
Route::get('/{id}', [TaskController::class, 'show']);
Route::put('/{id}', [TaskController::class, 'update']);
Route::delete('/{id}', [TaskController::class, 'destroy']);
});
// you can replace above with resource route
// Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');

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
});



// Route::get('welcome', [WelcomeController::class, 'index']);
// Route::get('user/{id}', [UserController::class, 'checkUser']);