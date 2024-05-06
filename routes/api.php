<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
