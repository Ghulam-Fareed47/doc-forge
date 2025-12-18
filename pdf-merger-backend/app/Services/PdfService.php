<?php

namespace App\Services;

use App\Repositories\PdfRepository;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class PdfService
{
    protected $pdfRepository;

    public function __construct(PdfRepository $pdfRepository)
    {
        $this->pdfRepository = $pdfRepository;
    }

    /**
     * Merge multiple PDF files into one.
     *
     * @param array<UploadedFile> $files
     * @return string Valid PDF content
     */
    public function mergePdfs(array $files)
    {
        $pdf = new Fpdi();

        foreach ($files as $file) {
            $path = $file->getRealPath();
            $pageCount = $pdf->setSourceFile($path);

            for ($i = 1; $i <= $pageCount; $i++) {
                $tplId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($tplId);
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($tplId);
            }
        }

        $this->pdfRepository->saveOperationMetadata('merge', ['count' => count($files)]);

        return $pdf->Output('S'); // Return as string
    }

    /**
     * Split a PDF file into specific pages.
     *
     * @param UploadedFile $file
     * @param string $pages e.g. "1,3,5-7"
     * @return string Valid PDF content
     */
    public function splitPdf(UploadedFile $file, string $pages)
    {
        $pdf = new Fpdi();
        $path = $file->getRealPath();
        $pageCount = $pdf->setSourceFile($path);

        $pagesToKeep = $this->parsePageRange($pages, $pageCount);

        foreach ($pagesToKeep as $pageNo) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }

        $this->pdfRepository->saveOperationMetadata('split', ['original_pages' => $pageCount, 'kept_pages' => count($pagesToKeep)]);

        return $pdf->Output('S');
    }

    private function parsePageRange($rangeStr, $maxPage)
    {
        $pages = [];
        $parts = explode(',', $rangeStr);

        foreach ($parts as $part) {
            if (strpos($part, '-') !== false) {
                [$start, $end] = explode('-', $part);
                $start = (int)$start;
                $end = (int)$end;
                for ($i = $start; $i <= $end; $i++) {
                    if ($i >= 1 && $i <= $maxPage) {
                        $pages[] = $i;
                    }
                }
            } else {
                $p = (int)$part;
                if ($p >= 1 && $p <= $maxPage) {
                    $pages[] = $p;
                }
            }
        }

        return array_unique($pages);
    }
}
