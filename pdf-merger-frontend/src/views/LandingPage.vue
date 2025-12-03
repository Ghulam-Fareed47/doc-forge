<template>
  <div
    class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />

    <!-- Hero Section -->
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

        <!-- Call to Action -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
          <button @click="scrollToUpload"
            class="group inline-flex items-center justify-center whitespace-nowrap rounded-xl px-5 py-3 text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
            <span class="relative z-10 flex items-center gap-1">
              <i class="fas fa-bolt"></i>
              Start Free
            </span>
            <div
              class="absolute inset-0 bg-gradient-to-r from-primary-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
          </button>

          <button @click="scrollToFeatures"
            class="group inline-flex items-center justify-center whitespace-nowrap rounded-xl px-5 py-3 text-base font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 shadow hover:shadow-lg transition-all duration-300 relative overflow-hidden">
            <span class="relative z-10 flex items-center gap-1">
              <i class="fas fa-play-circle"></i>
              How It Works
            </span>
          </button>
        </div>

        <!-- Stats Banner -->
        <div
          class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl py-3 shadow-lg border border-gray-200 dark:border-gray-700 max-w-5xl mx-auto">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div v-for="stat in stats" :key="stat.label" class="text-center">
              <div class="text-2xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ stat.value }}</div>
              <div class="text-xs text-gray-600 dark:text-gray-400">{{ stat.label }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- File Upload Section -->
    <section ref="uploadSection" class="container mx-auto px-4 py-20">
      <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Merge Your Files in 3 Easy Steps</h2>
          <p class="text-lg text-gray-600 dark:text-gray-400">Upload, arrange, and download - it's that simple!</p>
        </div>

        <!-- File Upload Card -->
        <CardComponent class="shadow-2xl border-2 border-gray-100 dark:border-gray-800 overflow-hidden">
          <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 p-8">
            <div
              class="border-3 border-dashed border-primary-300 dark:border-primary-700 rounded-2xl p-12 transition-all duration-300 hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-inner"
              @dragover.prevent @drop.prevent="handleDrop">
              <label for="file-upload" class="cursor-pointer block">
                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-primary-600 dark:text-primary-400"></i>
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
              <input id="file-upload" type="file" multiple accept=".pdf" @change="handleFileSelect" class="hidden">
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
                      <button @click="moveFileDown(index)" :disabled="index === selectedFiles.length - 1"
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
                class="group w-full mt-8 inline-flex justify-center whitespace-nowrap rounded-xl px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed">
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

              <p v-if="selectedFiles.length < 2" class="mt-4 text-center text-gray-500 dark:text-gray-400">
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
    </section>

    <!-- Features Section -->
    <section ref="featuresSection" id="features" class="bg-white dark:bg-gray-900 py-20">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Why Choose PDF Merger?</h2>
          <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            We're redefining how you work with PDF documents
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
          <CardComponent v-for="feature in features" :key="feature.title"
            class="group hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-2 border-gray-100 dark:border-gray-800">
            <div class="p-2">
              <div
                class=" py-2 mb-6 rounded-2xl bg-gradient-to-br from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i :class="feature.icon + ' text-2xl text-primary-600 dark:text-primary-400'"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ feature.title }}</h3>
              <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ feature.description }}</p>
            </div>
          </CardComponent>
        </div>
      </div>
    </section>

    <!-- Blog Section -->
    <section class="bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 py-20">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Latest Insights</h2>
          <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            Tips, guides, and news about PDF management
          </p>
        </div>

        <!-- Card Slider -->
        <div class="max-w-6xl mx-auto px-4 md:px-12">
          <div class="relative h-[400px]">
            <!-- Blog Card 1 -->
            <div
              class="absolute inset-0 w-full max-w-lg mx-auto transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]"
              :class="activeBlog === 0 ? 'translate-x-0 scale-100 z-50' : 'translate-x-40 scale-[0.675] z-30'">
              <label class="absolute inset-0 cursor-pointer" @click="setActiveBlog(0)">
                <span class="sr-only">Read Blog Post</span>
              </label>
              <article class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl h-full">
                <header class="mb-6">
                  <div class="inline-flex items-center gap-2 mb-4">
                    <span
                      class="px-3 py-1 rounded-full bg-gradient-to-r from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 text-primary-700 dark:text-primary-300 text-sm font-medium">
                      Tutorial
                    </span>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Advanced PDF Management Tips for Professionals
                  </h3>
                </header>
                <div class="text-gray-600 dark:text-gray-400 space-y-4 mb-6">
                  <p>
                    Discover how to optimize your PDF workflow with these advanced techniques that can save you hours
                    every week.
                  </p>
                </div>
                <footer class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-indigo-500 flex items-center justify-center text-white font-bold">
                      JD
                    </div>
                    <div>
                      <div class="font-medium text-gray-900 dark:text-white">John Doe</div>
                      <div class="text-sm text-gray-500 dark:text-gray-400">PDF Expert</div>
                    </div>
                  </div>
                  <button
                    class="inline-flex justify-center whitespace-nowrap rounded-lg px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">
                    Read more →
                  </button>
                </footer>
              </article>
            </div>

            <!-- Blog Card 2 -->
            <div
              class="absolute inset-0 w-full max-w-lg mx-auto transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]"
              :class="activeBlog === 1 ? 'translate-x-0 scale-100 z-50' : activeBlog === 0 ? '-translate-x-20 scale-[0.8375] z-40' : 'translate-x-40 scale-[0.675] z-30'">
              <label class="absolute inset-0 cursor-pointer" @click="setActiveBlog(1)">
                <span class="sr-only">Read Blog Post</span>
              </label>
              <article class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl h-full">
                <header class="mb-6">
                  <div class="inline-flex items-center gap-2 mb-4">
                    <span
                      class="px-3 py-1 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-700 dark:text-green-300 text-sm font-medium">
                      Security
                    </span>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    How We Keep Your Documents Safe and Secure
                  </h3>
                </header>
                <div class="text-gray-600 dark:text-gray-400 space-y-4 mb-6">
                  <p>
                    Learn about our encryption protocols and privacy measures that ensure your documents are always
                    protected.
                  </p>
                </div>
                <footer class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold">
                      AS
                    </div>
                    <div>
                      <div class="font-medium text-gray-900 dark:text-white">Alex Smith</div>
                      <div class="text-sm text-gray-500 dark:text-gray-400">Security Lead</div>
                    </div>
                  </div>
                  <button
                    class="inline-flex justify-center whitespace-nowrap rounded-lg px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">
                    Read more →
                  </button>
                </footer>
              </article>
            </div>

            <!-- Blog Card 3 -->
            <div
              class="absolute inset-0 w-full max-w-lg mx-auto transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]"
              :class="activeBlog === 2 ? 'translate-x-0 scale-100 z-50' : activeBlog === 1 ? '-translate-x-20 scale-[0.8375] z-40' : 'translate-x-40 scale-[0.675] z-30 opacity-70'">
              <label class="absolute inset-0 cursor-pointer" @click="setActiveBlog(2)">
                <span class="sr-only">Read Blog Post</span>
              </label>
              <article class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl h-full">
                <header class="mb-6">
                  <div class="inline-flex items-center gap-2 mb-4">
                    <span
                      class="px-3 py-1 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-700 dark:text-blue-300 text-sm font-medium">
                      Productivity
                    </span>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Streamline Your Document Workflow in 2024
                  </h3>
                </header>
                <div class="text-gray-600 dark:text-gray-400 space-y-4 mb-6">
                  <p>
                    Latest trends and tools to make your document management more efficient than ever before.
                  </p>
                </div>
                <footer class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold">
                      MJ
                    </div>
                    <div>
                      <div class="font-medium text-gray-900 dark:text-white">Maria Johnson</div>
                      <div class="text-sm text-gray-500 dark:text-gray-400">Product Manager</div>
                    </div>
                  </div>
                  <button
                    class="inline-flex justify-center whitespace-nowrap rounded-lg px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">
                    Read more →
                  </button>
                </footer>
              </article>
            </div>
          </div>

          <!-- Slider Controls -->
          <div class="flex justify-center gap-3 mt-12">
            <button v-for="i in 3" :key="i" @click="setActiveBlog(i - 1)"
              class="w-3 h-3 rounded-full transition-all duration-300"
              :class="activeBlog === i - 1 ? 'bg-primary-600 w-8' : 'bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600'">
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->

    <div class="container max-w-5xl mx-auto px-4 py-12">
      <div
        class="relative w-full rounded-[1.5rem] overflow-hidden bg-gradient-to-br from-primary-900 via-primary-800 to-indigo-900 text-white   isolate">


        <!-- CTA Section - Simplified -->
        <div class="container max-w-5xl mx-auto z-10">
          <div
            class="relative w-full rounded-2xl overflow-hidden bg-gradient-to-br from-primary-600 to-indigo-600 dark:from-primary-900 dark:to-indigo-900 text-white px-8 py-12 md:px-16 md:py-14 shadow-2xl">

            <div class="relative z-10">
              <h2 class="text-2xl md:text-3xl font-bold tracking-tight mb-6 leading-[1.1]">
                Level Up Your PDF Game
              </h2>
              <p class="text-white/90 dark:text-primary-100 mb-8 max-w-xl text-sm">
                Get exclusive tips, updates on new features, and PDF productivity hacks delivered to your inbox.
              </p>
              <div class="flex flex-col sm:flex-row gap-4 w-full max-w-lg">
                <input type="email" placeholder="Enter your email"
                  class="w-full bg-white/10 border-2 border-white/20 rounded-xl px-4 py-3 text-white placeholder:text-white/50 focus:outline-none focus:border-white/40 focus:bg-white/15 transition-all duration-300 backdrop-blur-sm focus:scale-[1.02] text-base" />
                <button
                  class="group relative overflow-hidden bg-white text-primary-800 px-5 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 hover:shadow-xl whitespace-nowrap text-lg">
                  <span class="relative z-10">Get Updates</span>
                  <div
                    class="absolute inset-0 rounded-[inherit] bg-[linear-gradient(45deg,transparent_25%,theme(colors.white/.4)_50%,transparent_75%,transparent_100%)] bg-[length:250%_250%,100%_100%] bg-[position:200%_0,0_0] bg-no-repeat group-hover:bg-[position:-100%_0,0_0] group-hover:duration-[1500ms]">
                  </div>
                </button>
              </div>
              <p class="text-white/80 dark:text-primary-200/80 text-sm mt-4">
                No spam. Unsubscribe anytime. Join 10,000+ professionals already subscribed.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <FooterSection />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import CardComponent from '../components/CardComponent.vue'

const selectedFiles = ref([])
const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')
const progressText = ref('')
const activeBlog = ref(1)
const uploadSection = ref(null)
const featuresSection = ref(null)

const stats = [
  { value: '10M+', label: 'PDFs Merged' },
  { value: '500K+', label: 'Happy Users' },
  { value: '99.9%', label: 'Success Rate' },
  { value: '24/7', label: 'Uptime' }
]

const features = [
  { icon: 'fas fa-bolt', title: 'Lightning Fast', description: 'Merge your PDFs in seconds with our optimized processing engine. No waiting, no delays.' },
  { icon: 'fas fa-shield-alt', title: 'Bank-Level Security', description: 'Your files are encrypted end-to-end and automatically deleted after processing.' },
  { icon: 'fas fa-mobile-alt', title: 'Device Friendly', description: 'Works seamlessly on desktop, tablet, or mobile with no software installation.' },
  { icon: 'fas fa-infinity', title: 'Unlimited & Free', description: 'No hidden costs, no subscriptions, no limits. Merge as many PDFs as you need.' },
  { icon: 'fas fa-star', title: 'Premium Quality', description: 'Maintains original PDF quality, formatting, and resolution without compression.' },
  { icon: 'fas fa-headset', title: '24/7 Support', description: 'Get help whenever you need it with our responsive customer support team.' }
]

const uploadButtonText = computed(() => {
  return selectedFiles.value.length === 0
    ? 'Upload Your PDF Files'
    : `${selectedFiles.value.length} File${selectedFiles.value.length > 1 ? 's' : ''} Selected`
})

function setActiveBlog(index) {
  activeBlog.value = index
}

function scrollToUpload() {
  uploadSection.value?.scrollIntoView({ behavior: 'smooth' })
}

function scrollToFeatures() {
  featuresSection.value?.scrollIntoView({ behavior: 'smooth' })
}

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

onMounted(() => {
  // Initialize blog slider
  setActiveBlog(1)
})
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