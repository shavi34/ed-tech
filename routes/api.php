<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/user', [AuthController::class, 'show'])->name('auth.show');
    Route::get('/logout', [AuthController::class, 'revokeTokens']);

    Route::resource('/classes', CourseController::class)->only(['index', 'show']);
    Route::resource('/students', StudentController::class)->only(['show']);
    Route::get('/classes/{class}/students', [CourseController::class, 'students'])->name('class.students');
});
