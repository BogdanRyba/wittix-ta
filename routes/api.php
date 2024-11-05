<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'userList']);
        Route::delete('/{id}/delete', [UserController::class, 'destroy']);

    });
    Route::get('delete', [UserController::class, 'userList']);
    Route::post('logout', [AuthController::class, 'logout']);
});
