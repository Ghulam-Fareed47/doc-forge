<template>
  <div
    class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-violet-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />
    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
            Watermark PDF
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-400">
            Add watermark to your PDF documents.
          </p>
        </div>

        <!-- Mobile Sidebar Toggle -->
        <button @click="isSidebarOpen = true"
          class="md:hidden mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-200 font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
          <i class="fas fa-th-list text-indigo-600"></i>
          <span>Browse All Tools</span>
        </button>

        <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
          <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" class="md:w-72 flex-shrink-0" />

          <div class="flex-1 w-full max-w-4xl">
            <CardComponent class="h-full shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
              <div class="bg-gradient-to-br from-white to-indigo-50 dark:from-gray-900 dark:to-gray-800 p-8">
                <div
                  class="border-3 border-dashed border-indigo-300 dark:border-indigo-700 rounded-2xl p-12 transition-all duration-300 hover:border-indigo-500"
                  @dragover.prevent @drop.prevent="handleDrop">
                  <label for="file-upload" class="cursor-pointer block">
                    <div class="flex flex-col items-center justify-center">
                      <div
                        class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-indigo-100 to-violet-100 dark:from-indigo-900/30 dark:to-violet-900/30 flex items-center justify-center">
                        <i class="fas fa-tint text-4xl text-indigo-600 dark:text-indigo-400"></i>
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

                <div v-if="selectedFile" class="mt-8 space-y-6">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                      Watermark Text
                    </label>
                    <input v-model="watermarkText" type="text" placeholder="Enter watermark text" maxlength="100"
                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:border-indigo-500" />
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                      Position
                    </label>
                    <select v-model="position"
                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:border-indigo-500">
                      <option value="center">Center</option>
                      <option value="top-left">Top Left</option>
                      <option value="top-right">Top Right</option>
                      <option value="bottom-left">Bottom Left</option>
                      <option value="bottom-right">Bottom Right</option>
                    </select>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                      Opacity ({{ opacity }})
                    </label>
                    <input v-model.number="opacity" type="range" min="0" max="1" step="0.1" value="0.5"
                      class="w-full" />
                    <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-1">
                      <span>Transparent</span>
                      <span>Opaque</span>
                    </div>
                  </div>

                  <div class="flex gap-4">
                    <button @click="addWatermark" :disabled="isLoading || !watermarkText"
                      class="flex-1 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                      <span v-if="!isLoading">Add Watermark</span>
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


    <FooterSection />
    <LimitModal :isOpen="showLimitModal" @close="showLimitModal = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import CardComponent from '../components/CardComponent.vue'
import Sidebar from '@/components/Sidebar.vue'

const selectedFile = ref(null)
const watermarkText = ref('')
const position = ref('center')
const opacity = ref(0.5)
const isSidebarOpen = ref(false)
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')

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
  watermarkText.value = ''
  position.value = 'center'
  opacity.value = 0.5
  clearMessages()
}

import { pdfService } from '@/services/pdfService'
import { usageService } from '@/services/usageService'
import LimitModal from '@/components/LimitModal.vue'

const showLimitModal = ref(false)

async function addWatermark() {
  clearMessages()

  if (!selectedFile.value || !watermarkText.value) {
    showError('Please select a PDF file and enter watermark text')
    return
  }

  // Check usage limits
  const canUse = await usageService.canUseTool()
  if (!canUse) {
    showLimitModal.value = true
    return
  }

  isLoading.value = true
  progressText.value = 'Drawing watermark...'

  try {
    progressText.value = 'Processing in browser...'
    
    // Using frontend logic for 100% free processing
    const watermarkedData = await pdfService.drawWatermark(
      selectedFile.value, 
      watermarkText.value, 
      position.value, 
      opacity.value
    )

    progressText.value = 'Saving...'
    pdfService.download(watermarkedData, `watermarked-document-${Date.now()}.pdf`)
    
    // Log usage
    await usageService.logUsage('watermark', watermarkedData.byteLength)

    showSuccess('Watermark added successfully locally! Download started.')
    setTimeout(() => {
      clearFile()
    }, 2000)

  } catch (error) {
    console.error('Error:', error)
    showError(`Failed to add watermark: ${error.message}`)
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

