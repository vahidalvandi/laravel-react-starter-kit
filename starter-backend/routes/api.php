<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

//=== Auth Routes ===//
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

//=== Secured Routes ===//
Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:api');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');
