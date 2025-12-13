<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::post('/merge-pdfs', [PdfController::class, 'merge']);
Route::post('/split-pdf', [PdfController::class, 'split']);
Route::post('/compress-pdf', [PdfController::class, 'compress']);
Route::post('/pdf-to-images', [PdfController::class, 'pdfToImages']);
Route::post('/images-to-pdf', [PdfController::class, 'imagesToPdf']);
Route::post('/extract-text', [PdfController::class, 'extractText']);
Route::post('/watermark-pdf', [PdfController::class, 'watermark']);
Route::get('/health', fn() => response()->json(['status' => 'ok']));