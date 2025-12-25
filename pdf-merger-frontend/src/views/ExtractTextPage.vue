<template>
  <div
    class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />
    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
            Extract Text
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-400">
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


    <FooterSection />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
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

async function extractText() {
  clearMessages()

  if (!selectedFile.value) {
    showError('Please select a PDF file')
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

