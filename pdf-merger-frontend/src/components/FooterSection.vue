<template>
  <footer class="bg-black dark:bg-gray-900 text-white py-12 mt-auto">

    <div class="container mx-auto px-4">
      <div class="flex flex-col space-y-6">

        <!-- Navigation Links -->
        <nav class="flex justify-center flex-wrap gap-6 text-gray-400 font-medium">
          <router-link v-for="link in navLinks" :key="link.path" :to="link.path"
            class="hover:text-white transition-colors">
            {{ link.name }}
          </router-link>

          <router-link to="/privacy" class="hover:text-white transition-colors">Privacy Policy</router-link>
          <router-link to="/terms" class="hover:text-white transition-colors">Terms of Service</router-link>
          <router-link to="/faq" class="hover:text-white transition-colors">FAQ</router-link>
        </nav>

        <!-- Social Media Icons -->
        <div class="flex justify-center space-x-6">
          <a v-for="social in socialLinks" :key="social.name" :href="social.url" target="_blank"
            rel="noopener noreferrer" class="transition transform hover:scale-110" :title="social.name"
            :style="{ color: social.color }">
            <i :class="social.icon + ' text-3xl'"></i>
          </a>
        </div>

        <!-- Brand & Copyright -->
        <div class="text-center">
          <p class="text-gray-500 text-sm">
            Simple. Secure. PDF Processing. Professional-grade document tools in your browser.
          </p>
          <p class="text-gray-500 font-medium mt-6">
            © {{ currentYear }} DocForge. Built with Precision
          </p>
        </div>

      </div>
    </div>

  </footer>
</template>

<script setup>
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())

const navLinks = [
  { name: 'Home', path: '/' },
  { name: 'About', path: '/about' }
]

// REAL BRAND COLORS FOR ICONS
const socialLinks = [
  { name: 'Facebook', url: 'https://facebook.com', icon: 'fab fa-facebook', color: '#1877F2' },
  { name: 'Twitter', url: 'https://twitter.com', icon: 'fab fa-twitter', color: '#1DA1F2' },
  { name: 'LinkedIn', url: 'https://www.linkedin.com/in/ghulam-fareed-35859a377?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app', icon: 'fab fa-linkedin', color: '#0A66C2' },
  { name: 'Instagram', url: 'https://instagram.com', icon: 'fab fa-instagram', color: '#E1306C' },
  { name: 'GitHub', url: 'https://github.com/Ghulam-Fareed47', icon: 'fab fa-github', color: '#FFFFFF' }
]
</script>

<style scoped>
/* Optional: Instagram gradient if you want later */
/*
.instagram-gradient {
  background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
*/
</style>
