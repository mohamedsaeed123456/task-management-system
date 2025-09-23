<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tasks\TaskController;
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('me', [AuthController::class, 'me']);
   Route::post('logout', [AuthController::class, 'logout']);

   // Task routes
   Route::get('tasks', [TaskController::class, 'index']);
   Route::post('tasks', [TaskController::class, 'store']);
   Route::get('tasks/{task}', [TaskController::class, 'show']);
   Route::put('tasks/{task}', [TaskController::class, 'update']);
   Route::post('tasks/{task}/assign-user', [TaskController::class, 'assignUser']);
   Route::post('tasks/{task}/dependencies', [TaskController::class, 'addDependencies']);
});

