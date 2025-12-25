import { PDFDocument, rgb, StandardFonts } from 'pdf-lib'
import * as pdfjsLib from 'pdfjs-dist'
import JSZip from 'jszip'

// Import worker for Vite compatibility
pdfjsLib.GlobalWorkerOptions.workerSrc = new URL(
    'pdfjs-dist/build/pdf.worker.mjs',
    import.meta.url
).href

/**
 * Service to handle PDF operations in the browser using pdf-lib.
 * This provides a 100% free, unlimited solution for modern PDFs (1.5+).
 */
export const pdfService = {
    /**
     * Merges multiple PDF files into a single PDF.
     * @param {File[]} files - Array of PDF File objects
     * @returns {Promise<Uint8Array>} - The merged PDF data
     */
    async mergePdfs(files) {
        const mergedPdf = await PDFDocument.create()

        for (const file of files) {
            const arrayBuffer = await file.arrayBuffer()
            const pdf = await PDFDocument.load(arrayBuffer)
            const copiedPages = await mergedPdf.copyPages(pdf, pdf.getPageIndices())
            copiedPages.forEach((page) => mergedPdf.addPage(page))
        }

        return await mergedPdf.save()
    },

    /**
     * Simple "compression" using pdf-lib.
     */
    async compressPdf(file) {
        const arrayBuffer = await file.arrayBuffer()
        const pdf = await PDFDocument.load(arrayBuffer)
        return await pdf.save({
            useObjectStreams: true,
            addDefaultPage: false
        })
    },

    async drawWatermark(file, text, position, opacity) {
        const arrayBuffer = await file.arrayBuffer()
        const pdf = await PDFDocument.load(arrayBuffer)
        const font = await pdf.embedFont(StandardFonts.HelveticaBold)
        const pages = pdf.getPages()

        for (const page of pages) {
            const { width, height } = page.getSize()
            const fontSize = 50
            const textWidth = font.widthOfTextAtSize(text, fontSize)
            const textHeight = font.heightAtSize(fontSize)

            let x = 0; let y = 0
            switch (position) {
                case 'center': x = (width - textWidth) / 2; y = (height - textHeight) / 2; break
                case 'top-left': x = 20; y = height - textHeight - 20; break
                case 'top-right': x = width - textWidth - 20; y = height - textHeight - 20; break
                case 'bottom-left': x = 20; y = 20; break
                case 'bottom-right': x = width - textWidth - 20; y = 20; break
            }

            page.drawText(text, { x, y, size: fontSize, font, color: rgb(0, 0, 0), opacity })
        }
        return await pdf.save()
    },

    async imagesToPdf(files) {
        const pdfDoc = await PDFDocument.create()

        for (const file of files) {
            let image
            const arrayBuffer = await file.arrayBuffer()

            if (file.type === 'image/jpeg' || file.type === 'image/jpg') {
                image = await pdfDoc.embedJpg(arrayBuffer)
            } else if (file.type === 'image/png') {
                image = await pdfDoc.embedPng(arrayBuffer)
            } else {
                // For other types (GIF, BMP), convert to PNG using canvas
                const pngBuffer = await this.convertImageToPng(file)
                image = await pdfDoc.embedPng(pngBuffer)
            }

            const page = pdfDoc.addPage([image.width, image.height])
            page.drawImage(image, {
                x: 0,
                y: 0,
                width: image.width,
                height: image.height,
            })
        }

        return await pdfDoc.save()
    },

    async convertImageToPng(file) {
        return new Promise((resolve) => {
            const reader = new FileReader()
            reader.onload = (e) => {
                const img = new Image()
                img.onload = () => {
                    const canvas = document.createElement('canvas')
                    canvas.width = img.width
                    canvas.height = img.height
                    const ctx = canvas.getContext('2d')
                    ctx.drawImage(img, 0, 0)
                    canvas.toBlob((blob) => {
                        blob.arrayBuffer().then(resolve)
                    }, 'image/png')
                }
                img.src = e.target.result
            }
            reader.readAsDataURL(file)
        })
    },

    async extractText(file) {
        const arrayBuffer = await file.arrayBuffer()
        const loadingTask = pdfjsLib.getDocument({ data: arrayBuffer })
        const pdf = await loadingTask.promise
        let fullText = ''

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i)
            const textContent = await page.getTextContent()
            const pageText = textContent.items.map(item => item.str).join(' ')
            fullText += `--- Page ${i} ---\n${pageText}\n\n`
        }

        return {
            text: fullText,
            pageCount: pdf.numPages
        }
    },

    /**
     * Splits a PDF file into a new PDF containing specific pages.
       * @param {File} file - The source PDF File object
       * @param {string} pagesInput - Page ranges (e.g., "1-5, 8, 11-13")
       * @returns {Promise<Uint8Array>} - The split PDF data
       */
    async splitPdf(file, pagesInput) {
        const arrayBuffer = await file.arrayBuffer()
        const pdf = await PDFDocument.load(arrayBuffer)
        const newPdf = await PDFDocument.create()

        const pageIndices = this.parsePageRanges(pagesInput, pdf.getPageCount())

        const copiedPages = await newPdf.copyPages(pdf, pageIndices)
        copiedPages.forEach((page) => newPdf.addPage(page))

        return await newPdf.save()
    },

    /**
     * Parses page range strings like "1-5, 8, 11-13" into zero-based indices.
     */
    parsePageRanges(input, maxPages) {
        const indices = new Set()
        const parts = input.split(',')

        parts.forEach(part => {
            const trimmed = part.trim()
            if (trimmed.includes('-')) {
                const [start, end] = trimmed.split('-').map(n => parseInt(n.trim()))
                for (let i = start; i <= end; i++) {
                    if (i >= 1 && i <= maxPages) indices.add(i - 1)
                }
            } else {
                const page = parseInt(trimmed)
                if (page >= 1 && page <= maxPages) indices.add(page - 1)
            }
        })

        return Array.from(indices).sort((a, b) => a - b)
    },

    /**
     * Downloads a Uint8Array as a file.
     */
    download(data, filename) {
        const blob = new Blob([data], { type: 'application/pdf' })
        const url = URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.href = url
        a.download = filename
        document.body.appendChild(a)
        a.click()
        document.body.removeChild(a)
        URL.revokeObjectURL(url)
    }
}
