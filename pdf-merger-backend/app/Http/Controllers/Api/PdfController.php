<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pdf\MergePdfRequest;
use App\Http\Requests\Pdf\SplitPdfRequest;
use App\Services\PdfService;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function merge(MergePdfRequest $request)
    {
        try {
            $pdfContent = $this->pdfService->mergePdfs($request->file('files'));

            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="merged.pdf"');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function split(SplitPdfRequest $request)
    {
        try {
            $pdfContent = $this->pdfService->splitPdf($request->file('file'), $request->input('pages'));

            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="split.pdf"');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
