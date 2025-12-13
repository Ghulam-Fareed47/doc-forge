<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />

    <section class="relative overflow-hidden mx-auto pt-40 pb-24">
      <!-- Background decoration -->
      <div
        class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-br from-primary-500/10 to-indigo-500/10 rounded-full blur-3xl">
      </div>
      <div
        class="absolute -bottom-24 -left-24 w-96 h-96 bg-gradient-to-tr from-primary-500/10 to-indigo-500/10 rounded-full blur-3xl">
      </div>

      <div class="relative z-10 text-center  mx-auto">

        <h1 class="text-4xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
          Merge PDFs
          <span class="relative">
            <span
              class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">Effortlessly</span>
            <div
              class="absolute -bottom-2 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 to-indigo-500 rounded-full">
            </div>
          </span>
        </h1>

        <p class="text-xl md:text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto leading-relaxed">
          Combine multiple PDF files into a single document with our lightning-fast, secure, and completely free online
          tool.
        </p>
         <div class="max-w-4xl mx-auto">
        <CardComponent class="shadow-2xl border-2 border-gray-100 dark:border-gray-800">
          <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 p-8">
            <div class="border-3 border-dashed border-primary-300 dark:border-primary-700 rounded-2xl p-12 transition-all duration-300 hover:border-primary-500"
              @dragover.prevent @drop.prevent="handleDrop">
              <label for="file-upload" class="cursor-pointer block">
                <div class="flex flex-col items-center justify-center">
                  <div class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                    <i class="fas fa-file-pdf text-4xl text-primary-600 dark:text-primary-400"></i>
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
                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:border-primary-500" />
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                  Enter page ranges separated by commas. Use hyphens for ranges (e.g., 1-5) or single pages (e.g., 10)
                </p>
              </div>

              <div class="flex gap-4">
                <button @click="splitPdf" :disabled="isLoading || !pageRange"
                  class="flex-1 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                  <span v-if="!isLoading">Split PDF</span>
                  <span v-else>{{ progressText }}</span>
                </button>
                <button @click="clearFile"
                  class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300">
                  Clear
                </button>
              </div>
            </div>

            <div v-if="successMessage" class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-xl">
              {{ successMessage }}
            </div>
            <div v-if="errorMessage" class="mt-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-xl">
              {{ errorMessage }}
            </div>
          </div>
        </CardComponent>
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

const selectedFile = ref(null)
const pageRange = ref('')
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
  pageRange.value = ''
  clearMessages()
}

async function splitPdf() {
  clearMessages()
  
  if (!selectedFile.value || !pageRange.value) {
    showError('Please select a PDF file and enter page range')
    return
  }

  isLoading.value = true
  progressText.value = 'Processing...'

  try {
    const formData = new FormData()
    formData.append('pdf', selectedFile.value)
    formData.append('pages', pageRange.value)

    const response = await fetch('http://localhost:8000/api/split-pdf', {
      method: 'POST',
      body: formData,
      headers: { 'Accept': 'application/json' }
    })

    if (!response.ok) {
      const errorData = await response.json()
      throw new Error(errorData.error || 'Failed to split PDF')
    }

    progressText.value = 'Downloading...'
    const blob = await response.blob()
    const url = window.URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = `split-document-${Date.now()}.pdf`
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
    window.URL.revokeObjectURL(url)

    showSuccess('PDF split successfully! Download started.')
    setTimeout(() => {
      clearFile()
    }, 2000)

  } catch (error) {
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


