<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pdf\MergePdfRequest;
use App\Http\Requests\Pdf\SplitPdfRequest;
use App\Services\PdfService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function merge(MergePdfRequest $request)
    {
        Log::info('PDF merge request initiated', [
            'files_count' => count($request->file('pdfs')),
            'request_id' => uniqid('merge_', true)
        ]);

        try {
            $files = $request->file('pdfs');

            Log::debug('Files received for merging', [
                'count' => count($files),
                'file_details' => array_map(function ($file) {
                    return [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType()
                    ];
                }, $files)
            ]);

            $pdfContent = $this->pdfService->mergePdfs($files);

            Log::info('PDF merge completed successfully', [
                'output_size' => strlen($pdfContent)
            ]);

            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="merged.pdf"');
        } catch (\Exception $e) {
            Log::error('PDF merge failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function split(SplitPdfRequest $request)
    {
        try {
            $pdfContent = $this->pdfService->splitPdf($request->file('pdf'), $request->input('pages'));

            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="split.pdf"');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
