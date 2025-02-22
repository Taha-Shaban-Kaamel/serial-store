<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::resource('user', UserController::class)->middleware('auth:sanctum');
// Route::resource('users',[UserController::class,'index'])->middleware('auth:sanctum');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('roles', [UserController::class, 'role'])->middleware(['auth:sanctum', 'abilities:full access']);
Route::post('assign-role', [UserController::class, 'assignRole'])->middleware(['auth:sanctum', 'abilities:full access']);



// http://127.0.0.1:8000/api/login



