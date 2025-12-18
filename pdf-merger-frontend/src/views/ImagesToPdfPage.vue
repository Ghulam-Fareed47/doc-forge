<template>
  <div
    class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />

    <section class="relative min-h-screen pt-32 pb-24 px-4">
      <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-12">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
            Images to PDF
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-400">
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



    <FooterSection />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import CardComponent from '../components/CardComponent.vue'
import Sidebar from '@/components/Sidebar.vue'

const selectedFiles = ref([])
const isSidebarOpen = ref(false)
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')

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

async function convertToPdf() {
  clearMessages()

  if (selectedFiles.value.length === 0) {
    showError('Please select at least one image file')
    return
  }

  isLoading.value = true
  progressText.value = 'Converting...'

  try {
    const formData = new FormData()
    selectedFiles.value.forEach((file, index) => {
      formData.append(`images[${index}]`, file)
    })

    const response = await fetch('http://localhost:8000/api/images-to-pdf', {
      method: 'POST',
      body: formData,
      headers: { 'Accept': 'application/json' }
    })

    if (!response.ok) {
      const errorData = await response.json()
      throw new Error(errorData.error || 'Failed to convert images to PDF')
    }

    progressText.value = 'Downloading...'
    const blob = await response.blob()
    const url = window.URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = `images-to-pdf-${Date.now()}.pdf`
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
    window.URL.revokeObjectURL(url)

    showSuccess('Images converted to PDF successfully! Download started.')
    setTimeout(() => {
      clearFiles()
    }, 2000)

  } catch (error) {
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

