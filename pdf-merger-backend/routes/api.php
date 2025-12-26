<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsageController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/usage/log', [UsageController::class, 'log']);
Route::middleware(['auth:sanctum'])->get('/usage/logs', [UsageController::class, 'index']);
