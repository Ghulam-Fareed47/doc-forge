<template>
  <div
    class="min-h-screen relative bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
    <NavigationBar />
    <div class=" transition-all duration-300">
      <!-- Hero Section -->
      <section class="relative overflow-hidden mx-auto pt-48 pb-24">
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
            Combine multiple PDF files into a single document with our lightning-fast, secure, and completely free
            online
            tool.
          </p>

          <!-- Call to Action -->
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
            <button @click="$router.push('/merge-pdf')"
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
                    <button @click="$router.push('/blog')"
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
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import CardComponent from '../components/CardComponent.vue'
const activeBlog = ref(1)
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

function scrollToFeatures() {
  featuresSection.value?.scrollIntoView({ behavior: 'smooth' })
}

function setActiveBlog(index) {
  activeBlog.value = index
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