<template>
  <div
    class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />
    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
            Compress PDF
          </h1>
          <p class="text-base text-gray-600 dark:text-gray-400">
            Reduce file size while maintaining quality.
          </p>
        </div>

        <!-- Mobile Sidebar Toggle -->
        <button @click="isSidebarOpen = true"
          class="md:hidden mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-200 font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
          <i class="fas fa-th-list text-green-600"></i>
          <span>Browse All Tools</span>
        </button>

        <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
          <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" class="md:w-72 flex-shrink-0" />

          <div class="flex-1 w-full max-w-4xl">
            <CardComponent class="h-full shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
              <div class="bg-gradient-to-br from-white to-green-50 dark:from-gray-900 dark:to-gray-800 p-8">
                <div
                  class="border-3 border-dashed border-green-300 dark:border-green-700 rounded-2xl p-12 transition-all duration-300 hover:border-green-500"
                  @dragover.prevent @drop.prevent="handleDrop">
                  <label for="file-upload" class="cursor-pointer block">
                    <div class="flex flex-col items-center justify-center">
                      <div
                        class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 flex items-center justify-center">
                        <i class="fas fa-compress text-4xl text-green-600 dark:text-green-400"></i>
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
                      Compression Quality (1-100)
                    </label>
                    <input v-model.number="quality" type="range" min="1" max="100" value="75" class="w-full" />
                    <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-1">
                      <span>Lower Size</span>
                      <span class="font-semibold">{{ quality }}</span>
                      <span>Higher Quality</span>
                    </div>
                  </div>

                  <div class="flex gap-4">
                    <button @click="compressPdf" :disabled="isLoading"
                      class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                      <span v-if="!isLoading">Compress PDF</span>
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
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">How to Compress PDFs</h2>
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Reduce file size in three simple steps</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">1</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Upload PDF</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Select the PDF file you want to compress from your
              device or
              drag it here.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">2</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Adjust Quality</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Use the slider to balance between file size reduction
              and
              visual quality.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">3</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Compress & Save</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Process your file instantly in your browser and download
              the
              optimized PDF.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Tool Features -->
    <section class="py-16 bg-gray-50 dark:bg-slate-900">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">Smart PDF Optimization</h2>
            <div class="space-y-4">
              <div v-for="(feature, index) in toolFeatures" :key="index" class="flex gap-4">
                <div
                  class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
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
              <img src="https://images.unsplash.com/photo-1554224155-169641357599?auto=format&fit=crop&q=80&w=800"
                alt="Optimize PDFs" class="w-full h-full object-cover">
            </div>
            <div
              class="absolute -bottom-4 -right-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden sm:block">
              <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-shield-alt text-green-500 text-xs"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Privacy First</span>
              </div>
              <div class="text-xs font-bold text-gray-900 dark:text-white">Local-Only Compression</div>
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
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Common questions about PDF compression</p>
        </div>
        <div class="space-y-4">
          <div v-for="(faq, index) in faqs" :key="index"
            class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden hover:border-green-200 dark:hover:border-green-900 transition-colors">
            <button @click="toggleFaq(index)"
              class="w-full px-6 py-4 flex items-center justify-between text-left group">
              <span
                class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{
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
const quality = ref(75)
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')
const faqs = ref([
  { question: 'Does compressing a PDF reduce its quality?', answer: 'It depends on the quality level you select. Our tool uses smart optimization to significantly reduce file size while targeting minimal impact on visual clarity. For text-heavy documents, the change is usually unnoticeable.', isOpen: false },
  { question: 'Is my data safe during compression?', answer: 'Yes. Unlike other online tools, our compression happens entirely in your browser. Your document is never uploaded to any server, ensuring complete privacy.', isOpen: false },
  { question: 'What is the best quality setting?', answer: 'We recommend 75 or 80 for a great balance between size and quality. If you need a very small file for email, you can try 50 or 60.', isOpen: false },
  { question: 'Can I compress scanned PDFs?', answer: 'Absolutely. Our optimizer is particularly effective at reducing the size of high-resolution scanned documents.', isOpen: false }
])

const toolFeatures = [
  { title: 'Local Compression', description: 'Your PDF stays on your device throughout the process. No uploads, no risks.' },
  { title: 'Perfect Balance', description: 'Advanced algorithms to shrink your files without sacrificing readable quality.' },
  { title: 'Fast & Free', description: 'Real-time processing with no hidden costs or subscription requirements.' },
  { title: 'Large Files Support', description: 'Easily handle large documents that are too big for standard email attachments.' }
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
  clearMessages()
}

import { pdfService } from '@/services/pdfService'
import { usageService } from '@/services/usageService'
import LimitModal from '@/components/LimitModal.vue'

const showLimitModal = ref(false)

async function compressPdf() {
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
  progressText.value = 'Compressing...'

  try {
    progressText.value = 'Processing in browser...'

    // Using frontend logic for 100% free processing
    const compressedData = await pdfService.compressPdf(selectedFile.value)

    progressText.value = 'Saving...'
    pdfService.download(compressedData, `compressed-document-${Date.now()}.pdf`)

    // Log usage
    await usageService.logUsage('compress', compressedData.byteLength)

    showSuccess('PDF processed successfully! Download started.')
    setTimeout(() => {
      clearFile()
    }, 2000)

  } catch (error) {
    console.error('Error:', error)
    showError(`Failed to process PDF: ${error.message}`)
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
