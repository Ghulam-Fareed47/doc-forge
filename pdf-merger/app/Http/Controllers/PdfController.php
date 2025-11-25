<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PdfController extends Controller
{
    public function merge(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array|min:2',
            'pdfs.*' => 'required|file|mimes:pdf|max:10240'
        ]);

        try {
            $pdf = new Fpdi();
            
            foreach ($request->file('pdfs') as $file) {
                $pageCount = $pdf->setSourceFile($file->getPathname());
                
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);
                    
                    $pdf->AddPage(
                        $size['orientation'] ?? 'P',
                        [$size['width'], $size['height']]
                    );
                    $pdf->useTemplate($templateId);
                }
            }
            
            // Create temp directory if doesn't exist
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $outputPath = $tempDir . '/merged_' . time() . '.pdf';
            $pdf->Output($outputPath, 'F');
            
            return response()->download($outputPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}