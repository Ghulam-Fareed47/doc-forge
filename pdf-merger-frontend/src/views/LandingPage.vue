<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
          <div class="text-2xl font-bold text-indigo-600">
            📄 PDF Merger
          </div>
          <div class="space-x-4">
            <a href="#features" class="text-gray-600 hover:text-indigo-600">Features</a>
            <a href="#how-it-works" class="text-gray-600 hover:text-indigo-600">How It Works</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="container mx-auto px-4 py-16">
      <div class="text-center max-w-4xl mx-auto">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
          Merge Your PDFs in Seconds
        </h1>
        <p class="text-xl text-gray-600 mb-12">
          Combine multiple PDF files into one document quickly and easily. 
          No registration required, completely free.
        </p>
        
        <!-- File Upload Area -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
          <div class="border-4 border-dashed border-indigo-200 rounded-xl p-12 hover:border-indigo-400 transition">
            <label 
              for="file-upload" 
              class="cursor-pointer block"
            >
              <div class="text-6xl mb-4">📁</div>
              <div class="text-2xl font-semibold text-gray-700 mb-2">
                {{ uploadButtonText }}
              </div>
              <div class="text-gray-500">
                or drag and drop PDF files here
              </div>
            </label>
            <input 
              id="file-upload"
              type="file" 
              multiple 
              accept=".pdf"
              @change="handleFileSelect"
              class="hidden"
            >
          </div>

          <!-- Selected Files List -->
          <div v-if="selectedFiles.length > 0" class="mt-8">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-700">
                Selected Files: {{ selectedFiles.length }}
              </h3>
              <button 
                @click="clearAllFiles"
                class="text-sm text-red-500 hover:text-red-700"
              >
                Clear All
              </button>
            </div>
            
            <div class="space-y-3">
              <div 
                v-for="(file, index) in selectedFiles" 
                :key="index"
                class="bg-gray-50 p-4 rounded-lg flex items-center justify-between hover:bg-gray-100 transition"
              >
                <div class="flex items-center space-x-3">
                  <span class="text-2xl">📄</span>
                  <div class="text-left">
                    <div class="font-medium text-gray-800">{{ file.name }}</div>
                    <div class="text-sm text-gray-500">{{ formatFileSize(file.size) }}</div>
                  </div>
                </div>
                <button 
                  @click="removeFile(index)"
                  class="text-red-500 hover:text-red-700 font-semibold px-4 py-2 rounded hover:bg-red-50"
                >
                  ✕
                </button>
              </div>
            </div>

            <!-- Merge Button -->
            <button 
              @click="mergePdfs"
              :disabled="isLoading || selectedFiles.length < 2"
              class="mt-6 w-full bg-indigo-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl"
            >
              <span v-if="isLoading">
                ⏳ Merging... {{ progressText }}
              </span>
              <span v-else>
                ⚡ Merge {{ selectedFiles.length }} PDFs
              </span>
            </button>

            <p v-if="selectedFiles.length < 2" class="mt-2 text-sm text-gray-500">
              Please select at least 2 PDF files to merge
            </p>
          </div>
        </div>

        <!-- Success Message -->
        <div 
          v-if="successMessage" 
          class="bg-green-50 border-2 border-green-400 text-green-700 px-6 py-4 rounded-lg mb-4 animate-pulse"
        >
          ✅ {{ successMessage }}
        </div>

        <!-- Error Message -->
        <div 
          v-if="errorMessage" 
          class="bg-red-50 border-2 border-red-400 text-red-700 px-6 py-4 rounded-lg mb-4"
        >
          ❌ {{ errorMessage }}
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="bg-white py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">How It Works</h2>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          <div class="text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
              1️⃣
            </div>
            <h3 class="text-xl font-semibold mb-2">Upload PDFs</h3>
            <p class="text-gray-600">Select multiple PDF files from your device</p>
          </div>
          
          <div class="text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
              2️⃣
            </div>
            <h3 class="text-xl font-semibold mb-2">Click Merge</h3>
            <p class="text-gray-600">Our system combines them instantly</p>
          </div>
          
          <div class="text-center">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
              3️⃣
            </div>
            <h3 class="text-xl font-semibold mb-2">Download</h3>
            <p class="text-gray-600">Get your merged PDF file immediately</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="container mx-auto px-4 py-16">
      <h2 class="text-4xl font-bold text-center mb-12">Why Choose Our PDF Merger?</h2>
      
      <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <div 
          v-for="feature in features" 
          :key="feature.title"
          class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1"
        >
          <div class="text-5xl mb-4">{{ feature.icon }}</div>
          <h3 class="text-2xl font-semibold mb-3">{{ feature.title }}</h3>
          <p class="text-gray-600 leading-relaxed">{{ feature.description }}</p>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-indigo-600 py-16">
      <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8 text-white text-center max-w-5xl mx-auto">
          <div v-for="stat in stats" :key="stat.label">
            <div class="text-5xl font-bold mb-2">{{ stat.value }}</div>
            <div class="text-xl text-indigo-200">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
      <div class="container mx-auto px-4 text-center">
        <p class="text-gray-400">
          © 2024 PDF Merger. Built with Vue 3 + Laravel
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Reactive State
const selectedFiles = ref([])
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')

// Static Data
const features = ref([
  {
    icon: '⚡',
    title: 'Lightning Fast',
    description: 'Merge your PDFs in seconds with our optimized processing engine. No waiting, no delays.'
  },
  {
    icon: '🔒',
    title: 'Secure & Private',
    description: 'Your files are processed securely and deleted immediately after merging. We never store your data.'
  },
  {
    icon: '📱',
    title: 'Works Everywhere',
    description: 'Access from any device - desktop, tablet, or mobile. No installation required.'
  },
  {
    icon: '🆓',
    title: '100% Free',
    description: 'No hidden costs, no subscriptions, no limits. Merge unlimited PDFs completely free.'
  },
  {
    icon: '🎯',
    title: 'Easy to Use',
    description: 'Simple drag-and-drop interface. No technical knowledge needed, just select and merge.'
  },
  {
    icon: '⚙️',
    title: 'High Quality',
    description: 'Maintains original PDF quality and formatting. Your documents look exactly as intended.'
  }
])

const stats = ref([
  { value: '10M+', label: 'PDFs Merged' },
  { value: '500K+', label: 'Happy Users' },
  { value: '99.9%', label: 'Success Rate' }
])

// Computed Properties
const uploadButtonText = computed(() => {
  if (selectedFiles.value.length === 0) {
    return 'Click to Choose PDF Files'
  }
  return `${selectedFiles.value.length} File${selectedFiles.value.length > 1 ? 's' : ''} Selected`
})

// Methods
function handleFileSelect(event) {
  const files = Array.from(event.target.files)
  
  // Filter only PDF files
  const pdfFiles = files.filter(file => file.type === 'application/pdf')
  
  if (pdfFiles.length !== files.length) {
    showError('Please select only PDF files')
  }
  
  // Add new files to existing selection
  selectedFiles.value = [...selectedFiles.value, ...pdfFiles]
  
  // Reset input so same file can be selected again
  event.target.value = ''
}

function removeFile(index) {
  selectedFiles.value.splice(index, 1)
}

function clearAllFiles() {
  selectedFiles.value = []
  clearMessages()
}

function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
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

async function mergePdfs() {
  clearMessages()
  
  if (selectedFiles.value.length < 2) {
    showError('Please select at least 2 PDF files to merge')
    return
  }
  
  isLoading.value = true
  progressText.value = 'Uploading files...'
  
  try {
    // Create FormData
    const formData = new FormData()
    selectedFiles.value.forEach((file, index) => {
      formData.append(`pdfs[${index}]`, file)
    })
    
    progressText.value = 'Processing PDFs...'
    
    // Make API call to Laravel backend
    const response = await fetch('http://localhost:8000/api/merge-pdfs', {
      method: 'POST',
      body: formData,
      headers: {
        'Accept': 'application/json',
      }
    })
    
    if (!response.ok) {
      const errorData = await response.json().catch(() => ({}))
      throw new Error(errorData.message || 'Failed to merge PDFs')
    }
    
    progressText.value = 'Downloading...'
    
    // Get the merged PDF as blob
    const blob = await response.blob()
    
    // Create download link
    const url = window.URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = `merged-document-${Date.now()}.pdf`
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
    window.URL.revokeObjectURL(url)
    
    // Show success message
    showSuccess(`Successfully merged ${selectedFiles.value.length} PDFs! Download started.`)
    
    // Clear files after successful merge
    setTimeout(() => {
      selectedFiles.value = []
    }, 1000)
    
  } catch (error) {
    console.error('Error:', error)
    showError(`Failed to merge PDFs: ${error.message}`)
  } finally {
    isLoading.value = false
    progressText.value = ''
  }
}
</script>

<style scoped>
/* Smooth scroll behavior */
html {
  scroll-behavior: smooth;
}

/* Custom animations */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>