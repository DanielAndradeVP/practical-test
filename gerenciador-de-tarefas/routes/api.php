<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user', [UserController::class, 'store']);

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/task', [TaskController::class, 'listAllTasks']);
        Route::post('/task', [TaskController::class, 'store']);
        Route::put('/task/{id}', [TaskController::class, 'update']);
        Route::delete('/task/{id}', [TaskController::class, 'delete']);
        Route::put('/task/completed/{id}', [TaskController::class, 'taskCompleted']);

        Route::delete('/user/{id}', [UserController::class, 'delete']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::get('/user', [UserController::class, 'listAllUsers']);
        Route::put('/user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'delete']);
    });

Route::middleware('api')
    ->prefix('auth')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });
