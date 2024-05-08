<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/user', [AuthController::class, 'show']);
    Route::get('/logout', [AuthController::class, 'revokeTokens']);

    Route::resource('/classes', CourseController::class)->only(['index', 'show']);
    Route::resource('/students', StudentController::class)->only(['show']);
    Route::get('/classes/{class}/students', [CourseController::class, 'students'])->can('list', Course::class);
});
