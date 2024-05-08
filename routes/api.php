<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/user', [AuthController::class, 'show']);
    Route::get('/logout', [AuthController::class, 'revokeTokens']);
    Route::resource('/classes', CourseController::class)->only(['index', 'show']);
    Route::resource('/student', StudentController::class)->only(['show']);
});
