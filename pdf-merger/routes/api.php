<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::post('/merge-pdfs', [PdfController::class, 'merge']);
Route::get('/health', fn() => response()->json(['status' => 'ok']));