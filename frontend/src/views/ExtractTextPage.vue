<template>
  <div
    class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />
    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
            Extract Text
          </h1>
          <p class="text-base text-gray-600 dark:text-gray-400">
            Extract text content from PDF files.
          </p>
        </div>

        <!-- Mobile Sidebar Toggle -->
        <button @click="isSidebarOpen = true"
          class="md:hidden mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-200 font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
          <i class="fas fa-th-list text-teal-600"></i>
          <span>Browse All Tools</span>
        </button>

        <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
          <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" class="md:w-72 flex-shrink-0" />

          <div class="flex-1 w-full max-w-4xl">
            <CardComponent class="h-full shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
              <div class="bg-gradient-to-br from-white to-teal-50 dark:from-gray-900 dark:to-gray-800 p-8">
                <div
                  class="border-3 border-dashed border-teal-300 dark:border-teal-700 rounded-2xl p-12 transition-all duration-300 hover:border-teal-500"
                  @dragover.prevent @drop.prevent="handleDrop">
                  <label for="file-upload" class="cursor-pointer block">
                    <div class="flex flex-col items-center justify-center">
                      <div
                        class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                        <i class="fas fa-file-alt text-4xl text-teal-600 dark:text-teal-400"></i>
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
                  <div class="flex gap-4 mb-6">
                    <button @click="extractText" :disabled="isLoading"
                      class="flex-1 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                      <span v-if="!isLoading">Extract Text</span>
                      <span v-else>{{ progressText }}</span>
                    </button>
                    <button @click="clearFile"
                      class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300">
                      Clear
                    </button>
                  </div>

                  <div v-if="extractedText" class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Extracted Text ({{ pageCount }} page{{ pageCount > 1 ? 's' : '' }})
                      </label>
                      <button @click="copyText"
                        class="text-sm text-teal-600 dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300">
                        <i class="fas fa-copy mr-1"></i> Copy
                      </button>
                    </div>
                    <textarea v-model="extractedText" readonly
                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:border-teal-500 h-64 font-mono text-sm"></textarea>
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
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">How to Extract Text from PDF
          </h2>
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Get your content in three simple steps</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">1</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Upload PDF</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Select the PDF file you want to extract text from. The
              tool
              works entirely in your browser.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">2</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Extract Content</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Click "Extract Text" and our engine will parse your
              document
              locally to retrieve text.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">3</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Copy or Save</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Review the extracted text in the editor. Copy it to your
              clipboard or save it as needed.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Tool Features -->
    <section class="py-16 bg-gray-50 dark:bg-slate-900">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">Smart Text Extraction</h2>
            <div class="space-y-4">
              <div v-for="(feature, index) in toolFeatures" :key="index" class="flex gap-4">
                <div
                  class="flex-shrink-0 w-8 h-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center">
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
              <img src="https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&q=80&w=800"
                alt="Extract PDF Text" class="w-full h-full object-cover">
            </div>
            <div
              class="absolute -bottom-4 -right-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden sm:block">
              <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-font text-teal-500 text-xs"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Pure Content</span>
              </div>
              <div class="text-xs font-bold text-gray-900 dark:text-white">Clean Text Retrieval</div>
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
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Questions about text extraction from PDFs</p>
        </div>
        <div class="space-y-4">
          <div v-for="(faq, index) in faqs" :key="index"
            class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden hover:border-teal-200 dark:hover:border-teal-900 transition-colors">
            <button @click="toggleFaq(index)"
              class="w-full px-6 py-4 flex items-center justify-between text-left group">
              <span
                class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">{{
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
const extractedText = ref('')
const pageCount = ref(0)
const isSidebarOpen = ref(false)
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')
const faqs = ref([
  { question: 'Is my document private during extraction?', answer: 'Yes. The extraction happens entirely on your local machine using your browser\'s processing power. We never see your content.', isOpen: false },
  { question: 'Does it support OCR (Scanned images)?', answer: 'Currently, this tool extracts native text from PDF documents. It does not support Optical Character Recognition (OCR) for scanned images or non-selectable text.', isOpen: false },
  { question: 'Will it preserve the formatting?', answer: 'The tool extracts raw text content. While it tries to maintain a logical flow, nested elements like tables and complex layouts may be simplified.', isOpen: false },
  { question: 'Is there a page limit?', answer: 'For standard users, there may be limits on very large documents. Large texts are processed efficiently in chunks.', isOpen: false }
])

const toolFeatures = [
  { title: 'Browser-Based', description: 'No server-side processing. Your data stays on your machine for 100% privacy.' },
  { title: 'Clean Extraction', description: 'Retrieves high-fidelity text content from any standard, searchable PDF document.' },
  { title: 'Instant Copy', description: 'One-click copy to clipboard functionality for quick use in other applications.' },
  { title: 'No Account Required', description: 'Fast, free access to basic extraction features without any registration needed.' }
]

function toggleFaq(index) {
  faqs.value[index].isOpen = !faqs.value[index].isOpen
}

function handleDrop(event) {
  event.preventDefault()
  const files = Array.from(event.dataTransfer.files)
  if (files.length > 0 && files[0].type === 'application/pdf') {
    selectedFile.value = files[0]
    extractedText.value = ''
    clearMessages()
  } else {
    showError('Please select a PDF file')
  }
}

function handleFileSelect(event) {
  const file = event.target.files[0]
  if (file && file.type === 'application/pdf') {
    selectedFile.value = file
    extractedText.value = ''
    clearMessages()
  } else {
    showError('Please select a PDF file')
  }
  event.target.value = ''
}

function clearFile() {
  selectedFile.value = null
  extractedText.value = ''
  pageCount.value = 0
  clearMessages()
}

import { pdfService } from '@/services/pdfService'
import { usageService } from '@/services/usageService'
import LimitModal from '@/components/LimitModal.vue'

const showLimitModal = ref(false)

async function extractText() {
  clearMessages()

  if (!selectedFile.value) {
    showError('Please select a PDF file')
    return
  }

  // Check usage limits
  const canUse = await usageService.canUseTool()
  if (!canUse) {
    showLimitModal.value = true
    return
  }

  isLoading.value = true
  progressText.value = 'Extracting text...'

  try {
    progressText.value = 'Processing in browser...'

    // Using frontend logic for 100% free processing
    const data = await pdfService.extractText(selectedFile.value)

    extractedText.value = data.text
    pageCount.value = data.pageCount || 0

    // Log usage
    await usageService.logUsage('extract-text', selectedFile.value.size)

    showSuccess('Text extracted successfully locally!')

  } catch (error) {
    console.error('Error:', error)
    showError(`Failed to extract text: ${error.message}`)
  } finally {
    isLoading.value = false
    progressText.value = ''
  }
}

async function copyText() {
  try {
    await navigator.clipboard.writeText(extractedText.value)
    showSuccess('Text copied to clipboard!')
  } catch (error) {
    showError('Failed to copy text')
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
