<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use Smalot\PdfParser\Parser;

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

    public function split(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'pages' => 'required|string' // Format: "1-5,10,15-20"
        ]);

        try {
            $file = $request->file('pdf');
            $pagesInput = $request->input('pages');
            
            // Parse page ranges (e.g., "1-5,10,15-20")
            $pageRanges = $this->parsePageRanges($pagesInput);
            
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($file->getPathname());
            
            // Validate page numbers
            foreach ($pageRanges as $range) {
                if ($range['start'] < 1 || $range['end'] > $pageCount) {
                    return response()->json([
                        'error' => "Invalid page range. PDF has {$pageCount} pages."
                    ], 400);
                }
            }
            
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $outputPath = $tempDir . '/split_' . time() . '.pdf';
            $outputPdf = new Fpdi();
            $outputPdf->setSourceFile($file->getPathname());
            
            foreach ($pageRanges as $range) {
                for ($pageNo = $range['start']; $pageNo <= $range['end']; $pageNo++) {
                    $templateId = $outputPdf->importPage($pageNo);
                    $size = $outputPdf->getTemplateSize($templateId);
                    
                    $outputPdf->AddPage(
                        $size['orientation'] ?? 'P',
                        [$size['width'], $size['height']]
                    );
                    $outputPdf->useTemplate($templateId);
                }
            }
            
            $outputPdf->Output($outputPath, 'F');
            
            return response()->download($outputPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function compress(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'quality' => 'sometimes|integer|min:1|max:100' // 1-100, default 75
        ]);

        try {
            $file = $request->file('pdf');
            $quality = $request->input('quality', 75);
            
            // For compression, we'll recreate the PDF with lower quality
            // Note: True compression requires Ghostscript or similar tools
            // This is a basic implementation
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($file->getPathname());
            
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $outputPath = $tempDir . '/compressed_' . time() . '.pdf';
            $outputPdf = new Fpdi();
            
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $outputPdf->setSourceFile($file->getPathname());
                $templateId = $outputPdf->importPage($pageNo);
                $size = $outputPdf->getTemplateSize($templateId);
                
                $outputPdf->AddPage(
                    $size['orientation'] ?? 'P',
                    [$size['width'], $size['height']]
                );
                $outputPdf->useTemplate($templateId);
            }
            
            $outputPdf->Output($outputPath, 'F');
            
            return response()->download($outputPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pdfToImages(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'format' => 'sometimes|string|in:png,jpg,jpeg' // Image format
        ]);

        try {
            // Note: This requires Imagick PHP extension
            // For now, return error if not available
            if (!extension_loaded('imagick')) {
                return response()->json([
                    'error' => 'Imagick extension is required for PDF to Images conversion. Please install php-imagick.'
                ], 500);
            }
            
            $file = $request->file('pdf');
            $format = $request->input('format', 'png');
            
            $imagick = new \Imagick();
            $imagick->setResolution(150, 150); // DPI
            $imagick->readImage($file->getPathname());
            $imagick->setImageFormat($format);
            
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            // Create ZIP file for multiple images
            $zipPath = $tempDir . '/images_' . time() . '.zip';
            $zip = new \ZipArchive();
            $zip->open($zipPath, \ZipArchive::CREATE);
            
            foreach ($imagick as $index => $page) {
                $imagePath = $tempDir . '/page_' . ($index + 1) . '.' . $format;
                $page->writeImage($imagePath);
                $zip->addFile($imagePath, 'page_' . ($index + 1) . '.' . $format);
            }
            
            $zip->close();
            $imagick->clear();
            $imagick->destroy();
            
            // Clean up individual image files
            foreach (glob($tempDir . '/page_*.' . $format) as $imageFile) {
                unlink($imageFile);
            }
            
            return response()->download($zipPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function imagesToPdf(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|file|mimes:jpeg,jpg,png,gif,bmp|max:10240'
        ]);

        try {
            $files = $request->file('images');
            
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $outputPath = $tempDir . '/images_to_pdf_' . time() . '.pdf';
            $pdf = new Fpdf();
            
            foreach ($files as $imageFile) {
                $imagePath = $imageFile->getPathname();
                $imageInfo = getimagesize($imagePath);
                
                if (!$imageInfo) {
                    continue;
                }
                
                $width = $imageInfo[0];
                $height = $imageInfo[1];
                $orientation = $width > $height ? 'L' : 'P';
                
                $pdf->AddPage($orientation, [$width, $height]);
                
                // Determine image type and add to PDF
                $imageType = $imageInfo[2];
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        $pdf->Image($imagePath, 0, 0, $width, $height);
                        break;
                    case IMAGETYPE_PNG:
                        $pdf->Image($imagePath, 0, 0, $width, $height);
                        break;
                    case IMAGETYPE_GIF:
                        // Convert GIF to temporary PNG
                        $img = imagecreatefromgif($imagePath);
                        $tempPng = $tempDir . '/temp_' . time() . '.png';
                        imagepng($img, $tempPng);
                        $pdf->Image($tempPng, 0, 0, $width, $height);
                        unlink($tempPng);
                        imagedestroy($img);
                        break;
                    default:
                        // Try to convert to JPEG
                        $img = imagecreatefromstring(file_get_contents($imagePath));
                        $tempJpg = $tempDir . '/temp_' . time() . '.jpg';
                        imagejpeg($img, $tempJpg, 90);
                        $pdf->Image($tempJpg, 0, 0, $width, $height);
                        unlink($tempJpg);
                        imagedestroy($img);
                        break;
                }
            }
            
            $pdf->Output($outputPath, 'F');
            
            return response()->download($outputPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function extractText(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240'
        ]);

        try {
            $file = $request->file('pdf');
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            
            $text = '';
            $pages = $pdf->getPages();
            
            foreach ($pages as $page) {
                $text .= $page->getText() . "\n\n";
            }
            
            return response()->json([
                'text' => $text,
                'page_count' => count($pages)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function watermark(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'text' => 'required|string|max:100',
            'position' => 'sometimes|string|in:center,top-left,top-right,bottom-left,bottom-right',
            'opacity' => 'sometimes|numeric|min:0|max:1'
        ]);

        try {
            $file = $request->file('pdf');
            $watermarkText = $request->input('text');
            $position = $request->input('position', 'center');
            $opacity = $request->input('opacity', 0.5);
            
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($file->getPathname());
            
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $outputPath = $tempDir . '/watermarked_' . time() . '.pdf';
            $outputPdf = new Fpdi();
            
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $outputPdf->setSourceFile($file->getPathname());
                $templateId = $outputPdf->importPage($pageNo);
                $size = $outputPdf->getTemplateSize($templateId);
                
                $outputPdf->AddPage(
                    $size['orientation'] ?? 'P',
                    [$size['width'], $size['height']]
                );
                $outputPdf->useTemplate($templateId);
                
                // Add watermark
                // Adjust color based on opacity (simulate transparency)
                $colorValue = (int)(255 * (1 - $opacity));
                $outputPdf->SetFont('Arial', 'B', 50);
                $outputPdf->SetTextColor($colorValue, $colorValue, $colorValue);
                
                $textWidth = $outputPdf->GetStringWidth($watermarkText);
                
                // Calculate position
                $x = 0;
                $y = 0;
                switch ($position) {
                    case 'center':
                        $x = ($size['width'] - $textWidth) / 2;
                        $y = $size['height'] / 2;
                        break;
                    case 'top-left':
                        $x = 20;
                        $y = 30;
                        break;
                    case 'top-right':
                        $x = $size['width'] - $textWidth - 20;
                        $y = 30;
                        break;
                    case 'bottom-left':
                        $x = 20;
                        $y = $size['height'] - 30;
                        break;
                    case 'bottom-right':
                        $x = $size['width'] - $textWidth - 20;
                        $y = $size['height'] - 30;
                        break;
                }
                
                // Simple watermark text (rotation requires advanced PDF manipulation)
                $outputPdf->Text($x, $y, $watermarkText);
            }
            
            $outputPdf->Output($outputPath, 'F');
            
            return response()->download($outputPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function parsePageRanges($input)
    {
        $ranges = [];
        $parts = explode(',', $input);
        
        foreach ($parts as $part) {
            $part = trim($part);
            if (strpos($part, '-') !== false) {
                list($start, $end) = explode('-', $part);
                $ranges[] = [
                    'start' => (int)trim($start),
                    'end' => (int)trim($end)
                ];
            } else {
                $page = (int)$part;
                $ranges[] = [
                    'start' => $page,
                    'end' => $page
                ];
            }
        }
        
        return $ranges;
    }
}