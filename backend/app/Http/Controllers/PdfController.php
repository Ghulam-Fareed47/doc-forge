<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use Smalot\PdfParser\Parser;

class PdfController extends Controller
{
    /**
     * Note: Most PDF processing has been moved to the frontend (pdfService.js)
     * for better compatibility with PDF 1.5+ and to avoid external binaries.
     * These endpoints remain as basic fallbacks.
     */

    public function merge(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array|min:2',
            'pdfs.*' => 'required|file|mimes:pdf|max:10240'
        ]);

        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);
            $outputPath = $tempDir . '/merged_' . time() . '.pdf';

            $pdf = new Fpdi();
            foreach ($request->file('pdfs') as $file) {
                $pageCount = $pdf->setSourceFile($file->getPathname());
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);
                    $pdf->AddPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            }
            $pdf->Output($outputPath, 'F');

            return response()->download($outputPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return $this->handlePdfException($e);
        }
    }

    public function split(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'pages' => 'required|string'
        ]);

        try {
            $file = $request->file('pdf');
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);
            $outputPath = $tempDir . '/split_' . time() . '.pdf';

            $pageRanges = $this->parsePageRanges($request->input('pages'));
            $outputPdf = new Fpdi();
            $pageCount = $outputPdf->setSourceFile($file->getPathname());

            foreach ($pageRanges as $range) {
                for ($pageNo = $range['start']; $pageNo <= $range['end']; $pageNo++) {
                    if ($pageNo > $pageCount) continue;
                    $templateId = $outputPdf->importPage($pageNo);
                    $size = $outputPdf->getTemplateSize($templateId);
                    $outputPdf->AddPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
                    $outputPdf->useTemplate($templateId);
                }
            }
            $outputPdf->Output($outputPath, 'F');

            return response()->download($outputPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return $this->handlePdfException($e);
        }
    }

    public function compress(Request $request)
    {
        // Actual compression is now handled by pdfService.js in the frontend
        return $this->merge($request);
    }

    public function extractText(Request $request)
    {
        $request->validate(['pdf' => 'required|file|mimes:pdf|max:10240']);
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($request->file('pdf')->getPathname());
            $text = '';
            foreach ($pdf->getPages() as $page) {
                $text .= $page->getText() . "\n\n";
            }
            return response()->json(['text' => $text, 'page_count' => count($pdf->getPages())]);
        } catch (\Exception $e) {
            return $this->handlePdfException($e);
        }
    }

    public function watermark(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'text' => 'required|string|max:100'
        ]);

        try {
            $file = $request->file('pdf');
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);
            $outputPath = $tempDir . '/watermarked_' . time() . '.pdf';

            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($file->getPathname());
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
                $pdf->AddPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                $pdf->SetFont('Arial', 'B', 50);
                $pdf->SetTextColor(200, 200, 200);
                $pdf->Text(20, 50, $request->input('text'));
            }
            $pdf->Output($outputPath, 'F');

            return response()->download($outputPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return $this->handlePdfException($e);
        }
    }

    public function imagesToPdf(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|file|mimes:jpeg,jpg,png|max:10240'
        ]);

        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);
            $outputPath = $tempDir . '/images_to_pdf_' . time() . '.pdf';

            $pdf = new Fpdf();
            foreach ($request->file('images') as $imageFile) {
                $imageInfo = getimagesize($imageFile->getPathname());
                if (!$imageInfo) continue;
                $pdf->AddPage($imageInfo[0] > $imageInfo[1] ? 'L' : 'P', [$imageInfo[0], $imageInfo[1]]);
                $pdf->Image($imageFile->getPathname(), 0, 0, $imageInfo[0], $imageInfo[1]);
            }
            $pdf->Output($outputPath, 'F');

            return response()->download($outputPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return $this->handlePdfException($e);
        }
    }

    private function handlePdfException(\Exception $e)
    {
        $message = $e->getMessage();
        if (str_contains($message, 'compression technique which is not supported')) {
            $message = "This PDF version is not supported by our backend fallback. " .
                "Please ensure you are using the latest version of our frontend app, which handles this locally.";
        }
        return response()->json(['error' => $message], 500);
    }

    private function parsePageRanges($input)
    {
        $ranges = [];
        foreach (explode(',', $input) as $part) {
            $part = trim($part);
            if (str_contains($part, '-')) {
                list($start, $end) = explode('-', $part);
                $ranges[] = ['start' => (int)$start, 'end' => (int)$end];
            } else {
                $ranges[] = ['start' => (int)$part, 'end' => (int)$part];
            }
        }
        return $ranges;
    }
}
