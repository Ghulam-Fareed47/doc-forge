<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/usage/log', [UsageController::class, 'log']);
Route::middleware(['auth:sanctum'])->get('/usage/logs', [UsageController::class, 'index']);

// Public blogs endpoint
Route::get('/blogs', [BlogController::class, 'publicIndex']);

// Admin routes (protected by auth:sanctum, admin check is done in controller)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/analytics', [AdminController::class, 'analytics']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::put('/users/{user}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
    Route::get('/usage-logs', [AdminController::class, 'usageLogs']);

    // Blog management
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::get('/blogs/{blog}', [BlogController::class, 'show']);
    Route::put('/blogs/{blog}', [BlogController::class, 'update']);
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']);
});
