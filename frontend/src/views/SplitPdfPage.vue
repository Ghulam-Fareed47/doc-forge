<template>
  <div
    class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-amber-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />
    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
            Split PDF File
          </h1>
          <p class="text-base text-gray-600 dark:text-gray-400">
            Split a PDF file into multiple documents by page ranges.
          </p>
        </div>

        <!-- Mobile Sidebar Toggle -->
        <button @click="isSidebarOpen = true"
          class="md:hidden mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-200 font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
          <i class="fas fa-th-list text-orange-600"></i>
          <span>Browse All Tools</span>
        </button>

        <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
          <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" class="md:w-72 flex-shrink-0" />

          <div class="flex-1 w-full max-w-4xl">
            <CardComponent class="h-full shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
              <div class="bg-gradient-to-br from-white to-orange-50 dark:from-gray-900 dark:to-gray-800 p-8">
                <div
                  class="border-3 border-dashed border-orange-300 dark:border-orange-700 rounded-2xl p-12 transition-all duration-300 hover:border-orange-500"
                  @dragover.prevent @drop.prevent="handleDrop">
                  <label for="file-upload" class="cursor-pointer block">
                    <div class="flex flex-col items-center justify-center">
                      <div
                        class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-orange-100 to-amber-100 dark:from-orange-900/30 dark:to-amber-900/30 flex items-center justify-center">
                        <i class="fas fa-file-pdf text-4xl text-orange-600 dark:text-orange-400"></i>
                      </div>
                      <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                        {{ selectedFile ? selectedFile.name : 'Upload PDF File' }}
                      </div>
                      <div class="text-gray-500 dark:text-gray-400 mb-4">
                        or drag and drop PDF file here
                      </div>
                      <input id="file-upload" type="file" accept=".pdf" @change="handleFileSelect" class="hidden" />
                    </div>
                  </label>
                </div>

                <div v-if="selectedFile" class="mt-8">
                  <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                      Page Range (e.g., 1-5,10,15-20)
                    </label>
                    <input v-model="pageRange" type="text" placeholder="1-5,10,15-20"
                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:border-orange-500" />
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                      Enter page ranges separated by commas. Use hyphens for ranges (e.g., 1-5) or single pages (e.g.,
                      10)
                    </p>
                  </div>

                  <div class="flex gap-4">
                    <button @click="splitPdf" :disabled="isLoading || !pageRange"
                      class="flex-1 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                      <span v-if="!isLoading">Split PDF</span>
                      <span v-else>{{ progressText }}</span>
                    </button>
                    <button @click="clearFile"
                      class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300">
                      Clear
                    </button>
                  </div>
                </div>

                <div v-if="successMessage"
                  class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-xl">
                  {{ successMessage }}
                </div>
                <div v-if="errorMessage"
                  class="mt-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-xl">
                  {{ errorMessage }}
                </div>
              </div>
            </CardComponent>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="text-center mb-12">
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">How to Split PDFs</h2>
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Extract pages in three simple steps</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">1</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Upload File</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Choose the PDF file you want to split from your computer
              or
              mobile device.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">2</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Set Page Ranges</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Enter the page numbers or ranges (e.g., 1-5) you wish to
              extract as a new PDF.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">3</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Extract & Save</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Click "Split PDF" to process locally and download your
              new
              document instantly.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Tool Features -->
    <section class="py-16 bg-gray-50 dark:bg-slate-900">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">Powerful PDF Splitting</h2>
            <div class="space-y-4">
              <div v-for="(feature, index) in toolFeatures" :key="index" class="flex gap-4">
                <div
                  class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center">
                  <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                  <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ feature.title }}</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">{{ feature.description }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="relative">
            <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl">
              <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&q=80&w=800"
                alt="Split PDFs Securely" class="w-full h-full object-cover">
            </div>
            <div
              class="absolute -bottom-4 -right-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden sm:block">
              <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-bolt text-orange-500 text-xs"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Zero Latency</span>
              </div>
              <div class="text-xs font-bold text-gray-900 dark:text-white">Instant Browser Processing</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white dark:bg-gray-900">
      <div class="container mx-auto px-4 max-w-3xl">
        <div class="text-center mb-12">
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">Frequently Asked Questions</h2>
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Everything you need to know about splitting
            PDFs</p>
        </div>
        <div class="space-y-4">
          <div v-for="(faq, index) in faqs" :key="index"
            class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden hover:border-orange-200 dark:hover:border-orange-900 transition-colors">
            <button @click="toggleFaq(index)"
              class="w-full px-6 py-4 flex items-center justify-between text-left group">
              <span
                class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">{{
                  faq.question }}</span>
              <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform"
                :class="{ 'rotate-180': faq.isOpen }"></i>
            </button>
            <transition enter-active-class="transition-all duration-300" enter-from-class="max-h-0 opacity-0"
              enter-to-class="max-h-60 opacity-100" leave-active-class="transition-all duration-200"
              leave-from-class="max-h-60 opacity-100" leave-to-class="max-h-0 opacity-0">
              <div v-if="faq.isOpen" class="px-6 pb-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ faq.answer }}</p>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </section>

    <NewsletterSection />
    <FooterSection />
    <LimitModal :isOpen="showLimitModal" @close="showLimitModal = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import NewsletterSection from '../components/NewsletterSection.vue'
import CardComponent from '../components/CardComponent.vue'
import Sidebar from '@/components/Sidebar.vue'

const selectedFile = ref(null)
const pageRange = ref('')
const isSidebarOpen = ref(false)
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')
const faqs = ref([
  { question: 'Is it safe to split my PDF files here?', answer: 'Yes, 100%. Our splitting tool works entirely in your browser using JavaScript. Your files are never uploaded to our servers, keeping your sensitive data private and secure.', isOpen: false },
  { question: 'What is the page range format?', answer: 'You can use commas to separate different parts and hyphens for ranges. For example, "1-3, 5, 8-10" will extract pages 1, 2, 3, 5, 8, 9, and 10.', isOpen: false },
  { question: 'Will my split PDF have the same quality?', answer: 'Yes. The quality of the split document will be identical to the original file. We extract the pages without any re-compression.', isOpen: false },
  { question: 'Can I split password-protected PDFs?', answer: 'Currently, you need to remove the password from your PDF before you can split it on our platform.', isOpen: false }
])

const toolFeatures = [
  { title: 'Secure Extraction', description: 'Your documents never leave your device. Processing happens locally for maximum security.' },
  { title: 'Flexible Ranges', description: 'Extract single pages, specific ranges, or multiple non-consecutive parts at once.' },
  { title: 'Zero Latency', description: 'No waiting for uploads or downloads. The tool works at the speed of your processor.' },
  { title: 'No Installation', description: 'Works directly in your web browser across all platforms and devices.' }
]

function toggleFaq(index) {
  faqs.value[index].isOpen = !faqs.value[index].isOpen
}

function handleDrop(event) {
  event.preventDefault()
  const files = Array.from(event.dataTransfer.files)
  if (files.length > 0 && files[0].type === 'application/pdf') {
    selectedFile.value = files[0]
    clearMessages()
  } else {
    showError('Please select a PDF file')
  }
}

function handleFileSelect(event) {
  const file = event.target.files[0]
  if (file && file.type === 'application/pdf') {
    selectedFile.value = file
    clearMessages()
  } else {
    showError('Please select a PDF file')
  }
  event.target.value = ''
}

function clearFile() {
  selectedFile.value = null
  pageRange.value = ''
  clearMessages()
}

import { pdfService } from '@/services/pdfService'
import { usageService } from '@/services/usageService'
import LimitModal from '@/components/LimitModal.vue'

const showLimitModal = ref(false)

async function splitPdf() {
  clearMessages()

  if (!selectedFile.value || !pageRange.value) {
    showError('Please select a PDF file and enter page range')
    return
  }

  // Check usage limits
  const canUse = await usageService.canUseTool()
  if (!canUse) {
    showLimitModal.value = true
    return
  }

  isLoading.value = true
  progressText.value = 'Preparing...'

  try {
    progressText.value = 'Splitting in browser...'

    // Using frontend logic for 100% free processing
    const splitPdfData = await pdfService.splitPdf(selectedFile.value, pageRange.value)

    progressText.value = 'Saving...'
    pdfService.download(splitPdfData, `split-document-${Date.now()}.pdf`)

    // Log usage
    await usageService.logUsage('split', splitPdfData.byteLength)

    showSuccess('PDF split successfully locally! Download started.')
    setTimeout(() => {
      clearFile()
    }, 2000)

  } catch (error) {
    console.error('Error:', error)
    showError(`Failed to split PDF: ${error.message}`)
  } finally {
    isLoading.value = false
    progressText.value = ''
  }
}

function showSuccess(message) {
  successMessage.value = message
  setTimeout(() => successMessage.value = '', 5000)
}

function showError(message) {
  errorMessage.value = message
  setTimeout(() => errorMessage.value = '', 5000)
}

function clearMessages() {
  successMessage.value = ''
  errorMessage.value = ''
}
</script>
