<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 flex flex-col">
    <NavigationBar />

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-600 to-indigo-600 py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">About PDF Merger</h1>
        <p class="text-xl text-primary-100 max-w-2xl mx-auto">
          Your trusted partner for fast, secure, and free PDF merging
        </p>
      </div>
    </section>

    <!-- Mission Section -->
    <section class="container mx-auto px-4 py-16">
      <div class="max-w-4xl mx-auto">
        <CardComponent>
          <div class="text-center mb-8">
            <div class="text-6xl mb-4">🎯</div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
              We believe that merging PDFs should be simple, fast, and accessible to everyone. 
              That's why we built this tool - to help people combine their documents without 
              complicated software or expensive subscriptions.
            </p>
          </div>
        </CardComponent>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bg-white dark:bg-gray-800 py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
          Why Choose PDF Merger?
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
          <CardComponent v-for="reason in reasons" :key="reason.title" class="text-center">
            <div class="text-4xl mb-3">{{ reason.icon }}</div>
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">{{ reason.title }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ reason.description }}</p>
          </CardComponent>
        </div>
      </div>
    </section>

    <!-- Our Story -->
    <section class="container mx-auto px-4 py-16">
      <div class="max-w-4xl mx-auto">
        <CardComponent>
          <div class="md:flex items-center gap-8">
            <div class="md:w-1/3 text-center mb-6 md:mb-0">
              <div class="text-8xl">📚</div>
            </div>
            <div class="md:w-2/3">
              <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Our Story</h2>
              <div class="space-y-4 text-gray-600 dark:text-gray-300">
                <p>
                  PDF Merger was born out of frustration with complicated PDF tools that required 
                  installations, registrations, and subscriptions just to perform a simple task.
                </p>
                <p>
                  We created this platform to provide a straightforward solution - upload your PDFs, 
                  click merge, and download. No hassle, no hidden costs, no compromises on security.
                </p>
                <p>
                  Today, we're proud to serve over 500,000 users worldwide, processing millions of 
                  PDF merges every month while maintaining our commitment to simplicity and privacy.
                </p>
              </div>
            </div>
          </div>
        </CardComponent>
      </div>
    </section>

    <!-- Values -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
          Our Core Values
        </h2>

        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          <CardComponent v-for="value in values" :key="value.title">
            <div class="text-5xl mb-4">{{ value.icon }}</div>
            <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">{{ value.title }}</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ value.description }}</p>
          </CardComponent>
        </div>
      </div>
    </section>

    <!-- Statistics -->
    <section class="container mx-auto px-4 py-16">
      <CardComponent>
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">By The Numbers</h2>
          <p class="text-gray-600 dark:text-gray-400">Our impact in the PDF merging community</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <div class="text-4xl font-bold text-primary-600 dark:text-primary-400 mb-2">
              {{ stat.value }}
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">{{ stat.label }}</div>
          </div>
        </div>
      </CardComponent>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-primary-600 to-indigo-600 py-16">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Merge Your PDFs?</h2>
        <p class="text-xl text-primary-100 mb-8">Join thousands of satisfied users today</p>
        <router-link
          to="/"
          class="inline-block bg-white text-primary-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg"
        >
          Get Started Free →
        </router-link>
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

const reasons = ref([
  {
    icon: '🆓',
    title: '100% Free',
    description: 'No hidden costs, no subscriptions, unlimited merges'
  },
  {
    icon: '🔒',
    title: 'Secure',
    description: 'Files deleted after processing, SSL encryption'
  },
  {
    icon: '⚡',
    title: 'Fast',
    description: 'Instant merging, no waiting queues'
  },
  {
    icon: '🎯',
    title: 'Simple',
    description: 'No registration, no installation required'
  }
])

const values = ref([
  {
    icon: '🔐',
    title: 'Privacy First',
    description: 'Your files are your business. We process them securely and delete them immediately after merging. We never store or access your documents.'
  },
  {
    icon: '💎',
    title: 'Quality',
    description: 'We maintain the highest standards in PDF processing, ensuring your merged documents look exactly as intended with no quality loss.'
  },
  {
    icon: '🤝',
    title: 'User-Centric',
    description: 'Every feature we build is designed with you in mind. Simple, intuitive, and effective - that\'s our promise to you.'
  }
])

const stats = ref([
  { value: '10M+', label: 'PDFs Merged' },
  { value: '500K+', label: 'Active Users' },
  { value: '99.9%', label: 'Uptime' },
  { value: '4.9/5', label: 'User Rating' }
])
</script>