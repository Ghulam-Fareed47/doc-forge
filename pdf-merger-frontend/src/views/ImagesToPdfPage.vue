<template>
  <div
    class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />

    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
            Images to PDF
          </h1>
          <p class="text-base text-gray-600 dark:text-gray-400">
            Convert image files to PDF.
          </p>
        </div>

        <!-- Mobile Sidebar Toggle -->
        <button @click="isSidebarOpen = true"
          class="md:hidden mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-200 font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
          <i class="fas fa-th-list text-pink-600"></i>
          <span>Browse All Tools</span>
        </button>

        <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
          <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" class="md:w-72 flex-shrink-0" />

          <div class="flex-1 w-full max-w-4xl">
            <CardComponent class="h-full shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
              <div class="bg-gradient-to-br from-white to-pink-50 dark:from-gray-900 dark:to-gray-800 p-8">
                <div
                  class="border-3 border-dashed border-pink-300 dark:border-pink-700 rounded-2xl p-12 transition-all duration-300 hover:border-pink-500"
                  @dragover.prevent @drop.prevent="handleDrop">
                  <label for="file-upload" class="cursor-pointer block">
                    <div class="flex flex-col items-center justify-center">
                      <div
                        class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-pink-100 to-rose-100 dark:from-pink-900/30 dark:to-rose-900/30 flex items-center justify-center">
                        <i class="fas fa-file-pdf text-4xl text-pink-600 dark:text-pink-400"></i>
                      </div>
                      <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                        {{ selectedFiles.length > 0 ? `${selectedFiles.length} Image${selectedFiles.length > 1 ? 's' :
                          ''}
                        Selected` : 'Upload Image Files' }}
                      </div>
                      <div class="text-gray-500 dark:text-gray-400 mb-4">
                        or drag and drop image files here (JPG, PNG, GIF, BMP)
                      </div>
                      <input id="file-upload" type="file" accept="image/*" multiple @change="handleFileSelect"
                        class="hidden" />
                    </div>
                  </label>
                </div>

                <div v-if="selectedFiles.length > 0" class="mt-8">
                  <div class="mb-6 max-h-60 overflow-y-auto">
                    <div v-for="(file, index) in selectedFiles" :key="index"
                      class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-800 rounded-lg mb-2">
                      <span class="text-sm text-gray-700 dark:text-gray-300">{{ file.name }}</span>
                      <button @click="removeFile(index)" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>

                  <div class="flex gap-4">
                    <button @click="convertToPdf" :disabled="isLoading || selectedFiles.length === 0"
                      class="flex-1 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                      <span v-if="!isLoading">Convert to PDF</span>
                      <span v-else>{{ progressText }}</span>
                    </button>
                    <button @click="clearFiles"
                      class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300">
                      Clear All
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
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">How to Convert Images to PDF
          </h2>
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Turn your photos into documents in three
            simple steps
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">1</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Select Images</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Upload your JPG, PNG, or GIF files. You can select
              multiple
              images at once.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">2</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Review Gallery</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">See your selected images in the list. Remove any
              unwanted
              photos before converting.</p>
          </div>
          <div class="text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-xl font-bold">3</span>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Merge to PDF</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Click "Convert to PDF" and your images will be compiled
              into
              a single document locally.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Tool Features -->
    <section class="py-16 bg-gray-50 dark:bg-slate-900">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">High-Quality Image Conversion
            </h2>
            <div class="space-y-4">
              <div v-for="(feature, index) in toolFeatures" :key="index" class="flex gap-4">
                <div
                  class="flex-shrink-0 w-8 h-8 rounded-lg bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center">
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
              <img src="https://images.unsplash.com/photo-1542744173-8e41262d4e39?auto=format&fit=crop&q=80&w=800"
                alt="Image to PDF Conversion" class="w-full h-full object-cover">
            </div>
            <div
              class="absolute -bottom-4 -right-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden sm:block">
              <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-image text-pink-500 text-xs"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Universal Format</span>
              </div>
              <div class="text-xs font-bold text-gray-900 dark:text-white">Supports JPG, PNG & more</div>
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
          <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Common questions about image to PDF
            conversion
          </p>
        </div>
        <div class="space-y-4">
          <div v-for="(faq, index) in faqs" :key="index"
            class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden hover:border-pink-200 dark:hover:border-pink-900 transition-colors">
            <button @click="toggleFaq(index)"
              class="w-full px-6 py-4 flex items-center justify-between text-left group">
              <span
                class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">{{
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

const selectedFiles = ref([])
const isSidebarOpen = ref(false)
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')
const faqs = ref([
  { question: 'What image formats are supported?', answer: 'We support all major image formats including JPG, PNG, GIF, BMP, and WEBP. All formats can be mixed and converted into a single PDF.', isOpen: false },
  { question: 'Is there a limit to the number of images?', answer: 'You can upload multiple images at once. Very large batches may be restricted based on your account usage limits.', isOpen: false },
  { question: 'Will my images be private?', answer: 'Absolutely. The conversion process happens 100% in your browser. Your images are never sent to our servers.', isOpen: false },
  { question: 'Can I reorder the images?', answer: 'Images are converted in the order they were uploaded. You can remove individual images and re-upload if you need a specific sequence.', isOpen: false }
])

const toolFeatures = [
  { title: 'Local Processing', description: 'Your photos stay private. Conversion happens on your device, not on a server.' },
  { title: 'High Resolution', description: 'We preserve the original quality and DPI of your images in the final PDF file.' },
  { title: 'Multiple Formats', description: 'Convert JPG, PNG, and more seamlessly into a professional PDF document.' },
  { title: 'Fast Generation', description: 'Experience instant PDF creation without any upload wait times or server delays.' }
]

function toggleFaq(index) {
  faqs.value[index].isOpen = !faqs.value[index].isOpen
}

function handleDrop(event) {
  event.preventDefault()
  const files = Array.from(event.dataTransfer.files)
  const imageFiles = files.filter(file => file.type.startsWith('image/'))
  if (imageFiles.length > 0) {
    selectedFiles.value = [...selectedFiles.value, ...imageFiles]
    clearMessages()
  } else {
    showError('Please select image files')
  }
}

function handleFileSelect(event) {
  const files = Array.from(event.target.files)
  const imageFiles = files.filter(file => file.type.startsWith('image/'))
  if (imageFiles.length > 0) {
    selectedFiles.value = [...selectedFiles.value, ...imageFiles]
    clearMessages()
  } else {
    showError('Please select image files')
  }
  event.target.value = ''
}

function removeFile(index) {
  selectedFiles.value.splice(index, 1)
}

function clearFiles() {
  selectedFiles.value = []
  clearMessages()
}

import { pdfService } from '@/services/pdfService'
import { usageService } from '@/services/usageService'
import LimitModal from '@/components/LimitModal.vue'

const showLimitModal = ref(false)

async function convertToPdf() {
  clearMessages()

  if (selectedFiles.value.length === 0) {
    showError('Please select at least one image file')
    return
  }

  // Check usage limits
  const canUse = await usageService.canUseTool()
  if (!canUse) {
    showLimitModal.value = true
    return
  }

  isLoading.value = true
  progressText.value = 'Converting...'

  try {
    progressText.value = 'Processing in browser...'

    // Using frontend logic for 100% free processing
    const pdfData = await pdfService.imagesToPdf(selectedFiles.value)

    progressText.value = 'Saving...'
    pdfService.download(pdfData, `images-to-pdf-${Date.now()}.pdf`)

    // Log usage
    await usageService.logUsage('images-to-pdf', pdfData.byteLength)

    showSuccess('Images converted to PDF successfully locally! Download started.')
    setTimeout(() => {
      clearFiles()
    }, 2000)

  } catch (error) {
    console.error('Error:', error)
    showError(`Failed to convert images: ${error.message}`)
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
