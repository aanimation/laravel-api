<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    UserController
};

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/update/{userId}', [UserController::class, 'update']);
    Route::post('/delete/{userId}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
