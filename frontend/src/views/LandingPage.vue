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

          <h1
            class="text-3xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-6 leading-tight tracking-tight">
            The Ultimate PDF Workspace
            <span class="relative inline-block min-w-[120px] md:min-w-[150px]">
              <span ref="typedTarget"
                class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent"></span>
              <div
                class="absolute -bottom-1.5 left-0 right-0 h-1 md:h-1.5 bg-gradient-to-r from-primary-500 to-indigo-500 rounded-full">
              </div>
            </span>
          </h1>

          <p class="text-sm md:text-base text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
            Simple. Secure. PDF Processing. Merge, split, compress, and convert your documents with our professional
            suite of free tools.
          </p>

          <!-- Call to Action -->
          <div class="flex flex-row gap-3 justify-center items-center mb-16 px-4">
            <button @click="scrollToTools"
              class="group flex-1 sm:flex-none inline-flex items-center justify-center whitespace-nowrap rounded-xl px-4 py-3 text-sm md:text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
              <span class="relative z-10 flex items-center gap-1.5">
                <i class="fas fa-bolt"></i>
                Start Free
              </span>
            </button>

            <button @click="scrollToFeatures"
              class="group flex-1 sm:flex-none inline-flex items-center justify-center whitespace-nowrap rounded-xl px-4 py-3 text-sm md:text-base font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-500 shadow hover:shadow-lg transition-all duration-300 relative overflow-hidden">
              <span class="relative z-10 flex items-center gap-1.5">
                <i class="fas fa-play-circle"></i>
                How It Works
              </span>
            </button>
          </div>

          <!-- Stats Banner -->
          <div
            class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-3xl py-6 px-4 shadow-xl border border-white/20 dark:border-gray-700 max-w-5xl mx-auto reveal">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
              <div v-for="stat in stats" :key="stat.label" class="text-center group">
                <div class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white mb-1">
                  <NumberCounter :value="stat.value" />
                </div>
                <div
                  class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider group-hover:text-primary-500 transition-colors">
                  {{ stat.label }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <InfiniteLogoSlider />





      <!-- Tools Grid Section -->
      <!-- Tools Grid Section -->
      <!-- Tools Grid Section -->
      <section ref="toolsSection" id="tools"
        class="py-24 bg-gray-50 dark:bg-slate-900 overflow-hidden transition-colors duration-300">
        <div class="container mx-auto px-4">
          <div class="text-center mb-16">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2">Popular Tools</h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-slate-400 max-w-2xl mx-auto">
              Everything you need to manage your PDF files
            </p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
            <router-link v-for="tool in tools" :key="tool.id" :to="tool.path" class="group relative rounded-2xl transition-all duration-500 hover:shadow-2xl hover:-translate-y-1
                     bg-white border shadow-sm
                     dark:bg-transparent dark:border-transparent dark:shadow-none
                     dark:[background-origin:padding-box,border-box]
                     dark:[background-clip:padding-box,border-box]
                     dark:hover:shadow-indigo-500/20" :class="[
                      `border-${tool.id === 'merge' ? 'blue' : tool.id === 'split' ? 'orange' : tool.id === 'compress' ? 'green' : 'indigo'}-100`,
                      `dark:before:bg-gradient-to-br dark:before:${tool.from} dark:before:${tool.to}`
                    ]" :style="{
                      '--tool-from': `var(--color-${tool.from.replace('from-', '')})`,
                      '--tool-to': `var(--color-${tool.to.replace('to-', '')})`
                    }">

              <!-- Dark Mode Gradient Border Trick -->
              <div
                class="absolute inset-0 rounded-2xl z-0 hidden dark:block p-[1px] bg-gradient-to-br from-slate-800 to-slate-800 group-hover:from-[color:var(--tw-gradient-from)] group-hover:to-[color:var(--tw-gradient-to)]"
                :class="[tool.from, tool.to]">
                <div class="h-full w-full bg-slate-900 rounded-2xl"></div>
              </div>

              <div class="relative h-full flex flex-col z-10">
                <div class="px-6 py-8 flex-1">
                  <div class="w-14 h-14 mb-6 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300
                              border" :class="[tool.bg, tool.text, tool.border]">
                    <i :class="tool.icon + ' text-2xl'"></i>
                  </div>

                  <!-- 'Use Tool' link moved here -->
                  <div
                    class="flex items-center font-medium mb-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0"
                    :class="tool.text">
                    <span class="text-sm font-semibold tracking-wide">Use Tool</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                  </div>

                  <div
                    class="text-xl font-bold text-gray-900 dark:text-slate-200 mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r"
                    :class="[tool.from, tool.to]">
                    {{ tool.name }}
                  </div>
                  <p class="text-sm text-gray-600 dark:text-slate-500 leading-relaxed">{{ tool.description }}</p>
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </section>

      <!-- Why Us Section -->
      <section class="py-24 bg-white dark:bg-gray-900 overflow-hidden reveal">
        <div class="container mx-auto px-4">
          <div class="flex flex-col lg:flex-row items-center gap-16 max-w-7xl mx-auto">
            <div class="lg:w-1/2 reveal-left">
              <div
                class="inline-block px-4 py-1.5 mb-6 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 text-indigo-700 dark:text-indigo-300 text-sm font-bold uppercase tracking-widest">
                Professional Grade
              </div>
              <h2 class="text-xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                Built for <span
                  class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">Companies</span>
                who value Efficiency.
              </h2>
              <div class="space-y-6">
                <div v-for="(pro, index) in proFeatures" :key="index" class="flex gap-4 group">
                  <div
                    class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                    <i :class="pro.icon + ' text-sm'"></i>
                  </div>
                  <div>
                    <h3
                      class="text-base font-bold text-gray-900 dark:text-white mb-1 underline decoration-indigo-500/30 decoration-4 underline-offset-4 group-hover:decoration-indigo-500">
                      {{ pro.title }}</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">{{ pro.description }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="lg:w-1/2 relative reveal-right">
              <div
                class="relative z-10 rounded-[2.5rem] overflow-hidden shadow-2xl border-8 border-white dark:border-gray-800 transform rotate-2 hover:rotate-0 transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1586769852836-bc069f19e1b6?auto=format&fit=crop&q=80&w=800"
                  alt="PDF Analytics" class="w-full h-full object-cover" />
              </div>
              <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl animate-pulse">
              </div>
              <div
                class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary-500/20 rounded-full blur-3xl animate-pulse delay-700">
              </div>

              <!-- Floating Card -->
              <div
                class="absolute -bottom-6 right-6 z-20 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md p-6 rounded-2xl shadow-2xl border border-white/20 max-w-[240px] hidden md:block animate-bounce-slow">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white">
                    <i class="fas fa-check"></i>
                  </div>
                  <div class="text-sm font-bold text-gray-900 dark:text-white">Processing Complete</div>
                </div>
                <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                  <div class="w-full h-full bg-green-500 animate-progress"></div>
                </div>
                <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                  <div class="w-full h-full bg-green-500 animate-progress"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">12 files merged in 0.8s</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section ref="featuresSection" id="features" class="bg-white dark:bg-gray-900 py-20">
        <div class="container mx-auto px-4">
          <div class="text-center mb-16">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3">Why Choose Our PDF Tools?</h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
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
      <section class="bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 py-20 overflow-hidden">
        <div class="container mx-auto px-4">
          <div class="text-center mb-16">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3">Latest Insights</h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
              Tips, guides, and news about PDF management
            </p>
          </div>

          <!-- Card Slider -->
          <div class="max-w-6xl mx-auto px-4 md:px-12">
            <div class="relative h-[400px]">
              <!-- Blog Card 1 -->
              <div
                class="absolute inset-0 w-full max-w-lg mx-auto transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]"
                :class="activeBlog === 0 ? 'translate-x-0 scale-100 z-40' : 'translate-x-40 scale-[0.675] z-10'">
                <div class="absolute inset-0 cursor-pointer z-50" @click="$router.push('/blog')">
                  <span class="sr-only">Read Blog Post</span>
                </div>
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
                :class="activeBlog === 1 ? 'translate-x-0 scale-100 z-40' : activeBlog === 0 ? '-translate-x-20 scale-[0.8375] z-20' : 'translate-x-40 scale-[0.675] z-10'">
                <div class="absolute inset-0 cursor-pointer z-50"
                  @click="activeBlog === 1 ? $router.push('/blog') : setActiveBlog(1)">
                  <span class="sr-only">Read Blog Post</span>
                </div>
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
                    <button @click="$router.push('/blog')"
                      class="inline-flex justify-center whitespace-nowrap rounded-lg px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">
                      Read more →
                    </button>
                  </footer>
                </article>
              </div>

              <!-- Blog Card 3 -->
              <div
                class="absolute inset-0 w-full max-w-lg mx-auto transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]"
                :class="activeBlog === 2 ? 'translate-x-0 scale-100 z-40' : activeBlog === 1 ? '-translate-x-20 scale-[0.8375] z-20' : 'translate-x-40 scale-[0.675] z-10 opacity-70'">
                <div class="absolute inset-0 cursor-pointer z-50"
                  @click="activeBlog === 2 ? $router.push('/blog') : setActiveBlog(2)">
                  <span class="sr-only">Read Blog Post</span>
                </div>
                <article
                  class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl h-full border border-gray-100 dark:border-gray-700">
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
                    <button @click="$router.push('/blog')"
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

      <NewsletterSection />

      <FooterSection />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Typed from 'typed.js'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import NewsletterSection from '../components/NewsletterSection.vue'
import CardComponent from '../components/CardComponent.vue'
import NumberCounter from '../components/NumberCounter.vue'
import InfiniteLogoSlider from '../components/InfiniteLogoSlider.vue'

const activeBlog = ref(1)
const featuresSection = ref(null)
const toolsSection = ref(null)
const typedTarget = ref(null)

const proFeatures = [
  { icon: 'fas fa-shield-halved', title: 'Data Privacy First', description: 'Your documents never leave your browser context with our client-side processing core.' },
  { icon: 'fas fa-layer-group', title: 'Bulk Mode', description: 'Process hundreds of files simultaneously with our multi-threaded JavaScript engine.' },
  { icon: 'fas fa-rocket', title: 'Zero Latency', description: 'Experience the speed of edge processing. No server uploads, no waiting lines.' }
]

const features = [
  { icon: 'fas fa-bolt', title: 'Lightning Fast', description: 'Merge your PDFs in seconds with our optimized processing engine. No waiting, no delays.' },
  { icon: 'fas fa-shield-alt', title: 'Bank-Level Security', description: 'Your files are encrypted end-to-end and automatically deleted after processing.' },
  { icon: 'fas fa-mobile-alt', title: 'Device Friendly', description: 'Works seamlessly on desktop, tablet, or mobile with no software installation.' },
  { icon: 'fas fa-infinity', title: 'Unlimited & Free', description: 'No hidden costs, no subscriptions, no limits. Merge as many PDFs as you need.' },
  { icon: 'fas fa-star', title: 'Premium Quality', description: 'Maintains original PDF quality, formatting, and resolution without compression.' },
  { icon: 'fas fa-headset', title: '24/7 Support', description: 'Get help whenever you need it with our responsive customer support team.' }
]

const tools = [
  {
    id: 'merge',
    name: 'Merge PDF',
    icon: 'fas fa-file-pdf',
    path: '/merge-pdf',
    description: 'Combine multiple PDFs into one unified document.',
    from: 'from-blue-500',
    to: 'to-cyan-500',
    text: 'text-blue-600 dark:text-blue-400',
    bg: 'bg-blue-50 dark:bg-blue-900/20',
    border: 'border-blue-100 dark:border-blue-800'
  },
  {
    id: 'split',
    name: 'Split PDF',
    icon: 'fas fa-cut',
    path: '/split-pdf',
    description: 'Separate a PDF file into individual pages or ranges.',
    from: 'from-orange-500',
    to: 'to-amber-500',
    text: 'text-orange-600 dark:text-orange-400',
    bg: 'bg-orange-50 dark:bg-orange-900/20',
    border: 'border-orange-100 dark:border-orange-800'
  },
  {
    id: 'compress',
    name: 'Compress PDF',
    icon: 'fas fa-compress',
    path: '/compress-pdf',
    description: 'Reduce file size while maintaining high quality.',
    from: 'from-green-500',
    to: 'to-emerald-500',
    text: 'text-green-600 dark:text-green-400',
    bg: 'bg-green-50 dark:bg-green-900/20',
    border: 'border-green-100 dark:border-green-800'
  },
  {
    id: 'images-to-pdf',
    name: 'Images to PDF',
    icon: 'fas fa-file-pdf',
    path: '/images-to-pdf',
    description: 'Create a PDF document from your image files.',
    from: 'from-pink-500',
    to: 'to-rose-500',
    text: 'text-pink-600 dark:text-pink-400',
    bg: 'bg-pink-50 dark:bg-pink-900/20',
    border: 'border-pink-100 dark:border-pink-800'
  },
  {
    id: 'extract-text',
    name: 'Extract Text',
    icon: 'fas fa-file-alt',
    path: '/extract-text',
    description: 'Extract text content from your PDF documents.',
    from: 'from-teal-500',
    to: 'to-cyan-500',
    text: 'text-teal-600 dark:text-teal-400',
    bg: 'bg-teal-50 dark:bg-teal-900/20',
    border: 'border-teal-100 dark:border-teal-800'
  },
  {
    id: 'watermark',
    name: 'Watermark PDF',
    icon: 'fas fa-tint',
    path: '/watermark-pdf',
    description: 'Add text or image watermarks to your PDFs.',
    from: 'from-indigo-500',
    to: 'to-violet-500',
    text: 'text-indigo-600 dark:text-indigo-400',
    bg: 'bg-indigo-50 dark:bg-indigo-900/20',
    border: 'border-indigo-100 dark:border-indigo-800'
  }
]

function scrollToFeatures() {
  featuresSection.value?.scrollIntoView({ behavior: 'smooth' })
}

function scrollToTools() {
  toolsSection.value?.scrollIntoView({ behavior: 'smooth' })
}

function setActiveBlog(index) {
  activeBlog.value = index
}

onMounted(() => {
  // Initialize Typed.js
  if (typedTarget.value) {
    new Typed(typedTarget.value, {
      strings: ['Effortlessly', 'Securely', 'In Seconds', 'Like a Pro'],
      typeSpeed: 60,
      backSpeed: 40,
      backDelay: 2000,
      loop: true
    })
  }

  // Scroll Reveal Logic
  const observerOptions = {
    threshold: 0.1
  }

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed')
        revealObserver.unobserve(entry.target)
      }
    })
  }, observerOptions)

  document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
    revealObserver.observe(el)
  })

  // Initialize blog slider
  setActiveBlog(1)
})

const stats = [
  { value: '10M+', label: 'Files Processed' },
  { value: '500K+', label: 'Happy Users' },
  { value: '99.9%', label: 'Success Rate' },
  { value: '24/7', label: 'Uptime' }
]
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

/* Scroll Reveal Animations */
.reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
}

.reveal-left {
  opacity: 0;
  transform: translateX(-50px);
  transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
}

.reveal-right {
  opacity: 0;
  transform: translateX(50px);
  transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
}

.reveal.revealed,
.reveal-left.revealed,
.reveal-right.revealed {
  opacity: 1;
  transform: translate(0);
}

@keyframes progress {
  from {
    width: 0;
  }

  to {
    width: 100%;
  }
}

.animate-progress {
  animation: progress 1.5s ease-out forwards;
}

.animate-bounce-slow {
  animation: bounce 3s infinite;
}

@keyframes bounce {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-10px);
  }
}

/* Typed.js cursor styling */
.typed-cursor {
  color: #6366f1;
  font-size: 1.2em;
}
</style>