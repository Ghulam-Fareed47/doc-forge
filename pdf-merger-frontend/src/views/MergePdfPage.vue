<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
        <NavigationBar />


        <section class="relative min-h-screen pt-32 pb-24 px-4">
            <div class="container mx-auto max-w-7xl">
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        Merge PDF Files
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        Combine multiple PDF files into a single document.
                    </p>

                    <!-- Mobile Sidebar Toggle -->
                    <button @click="isSidebarOpen = true"
                        class="md:hidden mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-200 font-medium shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-th-list text-primary-600"></i>
                        <span>Browse All Tools</span>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row gap-8 items-stretch justify-center">
                    <Sidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" class="md:w-72 flex-shrink-0" />

                    <div class="flex-1 w-full max-w-4xl">
                        <CardComponent
                            class="h-full shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
                            <div
                                class="bg-gradient-to-br from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 p-8">
                                <div class="border-3 border-dashed border-blue-300 dark:border-blue-700 rounded-2xl p-12 transition-all duration-300 hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-inner"
                                    @dragover.prevent @drop.prevent="handleDrop">
                                    <label for="file-upload" class="cursor-pointer block">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                                <i
                                                    class="fas fa-cloud-upload-alt text-4xl text-blue-600 dark:text-blue-400"></i>
                                            </div>
                                            <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                                                {{ uploadButtonText }}
                                            </div>
                                            <div class="text-gray-500 dark:text-gray-400 mb-4">
                                                or drag and drop PDF files here
                                            </div>
                                            <div
                                                class="inline-flex justify-center whitespace-nowrap rounded-lg px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-slate-800 to-slate-700 dark:from-slate-200 dark:to-slate-100 dark:text-slate-800 shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 relative overflow-hidden">
                                                <span class="relative z-10">Choose PDF Files</span>
                                                <div
                                                    class="absolute inset-0 rounded-[inherit] bg-[linear-gradient(45deg,transparent_25%,theme(colors.white/.2)_50%,transparent_75%,transparent_100%)] bg-[length:250%_250%,100%_100%] bg-[position:200%_0,0_0] bg-no-repeat hover:bg-[position:-100%_0,0_0] hover:duration-[1500ms]">
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <input id="file-upload" type="file" multiple accept=".pdf"
                                        @change="handleFileSelect" class="hidden">
                                </div>

                                <!-- Selected Files -->
                                <div v-if="selectedFiles.length > 0" class="mt-8">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                            Selected Files: {{ selectedFiles.length }}
                                        </h3>
                                        <button @click="clearAllFiles"
                                            class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors">
                                            Clear All
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <div v-for="(file, index) in selectedFiles" :key="index"
                                            class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex items-center justify-between hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300">
                                            <div class="flex items-center space-x-4">
                                                <div
                                                    class="w-12 h-12 rounded-lg bg-gradient-to-br from-primary-50 to-indigo-50 dark:from-primary-900/20 dark:to-indigo-900/20 flex items-center justify-center">
                                                    <i class="fas fa-file-pdf text-xl text-red-500"></i>
                                                </div>
                                                <div>
                                                    <div
                                                        class="font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                                        {{ file.name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ formatFileSize(file.size) }} • Uploaded
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="moveFileUp(index)" :disabled="index === 0"
                                                        class="p-2 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 disabled:opacity-30">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </button>
                                                    <button @click="moveFileDown(index)"
                                                        :disabled="index === selectedFiles.length - 1"
                                                        class="p-2 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 disabled:opacity-30">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </button>
                                                </div>
                                                <button @click="removeFile(index)"
                                                    class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Merge Button -->
                                    <button @click="mergePdfs" :disabled="isLoading || selectedFiles.length < 2"
                                        class="group w-full mt-8 inline-flex justify-center whitespace-nowrap rounded-xl px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span v-if="isLoading" class="relative z-10 flex items-center gap-3">
                                            <i class="fas fa-spinner fa-spin"></i>
                                            Processing {{ progressText }}
                                        </span>
                                        <span v-else class="relative z-10 flex items-center gap-3">
                                            <i class="fas fa-magic"></i>
                                            Merge {{ selectedFiles.length }} PDFs Now
                                        </span>
                                        <div
                                            class="absolute inset-0 rounded-[inherit] bg-[linear-gradient(45deg,transparent_25%,theme(colors.white/.3)_50%,transparent_75%,transparent_100%)] bg-[length:250%_250%,100%_100%] bg-[position:200%_0,0_0] bg-no-repeat group-hover:bg-[position:-100%_0,0_0] group-hover:duration-[1500ms]">
                                        </div>
                                    </button>

                                    <p v-if="selectedFiles.length < 2"
                                        class="mt-4 text-center text-gray-500 dark:text-gray-400">
                                        Please select at least 2 PDF files to merge
                                    </p>
                                </div>
                            </div>
                        </CardComponent>

                        <!-- Messages -->
                        <div v-if="successMessage"
                            class="mt-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-6 py-4 rounded-xl shadow-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-xl"></i>
                                <div>{{ successMessage }}</div>
                            </div>
                        </div>

                        <div v-if="errorMessage"
                            class="mt-6 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-2 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-6 py-4 rounded-xl shadow-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <div>{{ errorMessage }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <FooterSection />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import CardComponent from '../components/CardComponent.vue'
import Sidebar from '@/components/Sidebar.vue'

const selectedFiles = ref([])
const isLoading = ref(false)
const isSidebarOpen = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')

const uploadButtonText = computed(() => {
    return selectedFiles.value.length === 0
        ? 'Upload Your PDF Files'
        : `${selectedFiles.value.length} File${selectedFiles.value.length > 1 ? 's' : ''} Selected`
})

function handleDrop(event) {
    event.preventDefault()
    const files = Array.from(event.dataTransfer.files)
    handleFiles(files)
}

function handleFileSelect(event) {
    const files = Array.from(event.target.files)
    handleFiles(files)
    event.target.value = ''
}

function handleFiles(files) {
    const pdfFiles = files.filter(file => file.type === 'application/pdf')

    if (pdfFiles.length !== files.length) {
        showError('Please select only PDF files')
    }

    selectedFiles.value = [...selectedFiles.value, ...pdfFiles]
    showSuccess(`${pdfFiles.length} PDF${pdfFiles.length > 1 ? 's' : ''} added successfully!`)
}

function removeFile(index) {
    selectedFiles.value.splice(index, 1)
}

function moveFileUp(index) {
    if (index > 0) {
        const file = selectedFiles.value[index]
        selectedFiles.value.splice(index, 1)
        selectedFiles.value.splice(index - 1, 0, file)
    }
}

function moveFileDown(index) {
    if (index < selectedFiles.value.length - 1) {
        const file = selectedFiles.value[index]
        selectedFiles.value.splice(index, 1)
        selectedFiles.value.splice(index + 1, 0, file)
    }
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
        const formData = new FormData()
        selectedFiles.value.forEach((file, index) => {
            formData.append(`pdfs[${index}]`, file)
        })

        progressText.value = 'Processing PDFs...'

        const response = await fetch('http://localhost:8000/api/merge-pdfs', {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}))
            throw new Error(errorData.message || 'Failed to merge PDFs')
        }

        progressText.value = 'Downloading...'

        const blob = await response.blob()
        const url = window.URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.href = url
        a.download = `merged-document-${Date.now()}.pdf`
        document.body.appendChild(a)
        a.click()
        document.body.removeChild(a)
        window.URL.revokeObjectURL(url)

        showSuccess(`Successfully merged ${selectedFiles.value.length} PDFs! Download started.`)

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
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.dark ::-webkit-scrollbar-track {
    background: #2d3748;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.dark ::-webkit-scrollbar-thumb {
    background: #4a5568;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: #718096;
}
</style>
