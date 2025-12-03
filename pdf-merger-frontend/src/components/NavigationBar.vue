<template>
  <header
    class="fixed inset-x-0 top-0 z-50 mx-auto w-full max-w-screen-md border border-gray-100 bg-white/80 py-3 shadow backdrop-blur-lg md:top-6 md:rounded-3xl lg:max-w-screen-lg dark:bg-gray-900/80 dark:border-gray-800 transition-all duration-300">
    <div class="px-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <div class="flex shrink-0">
          <router-link to="/" class="flex items-center" aria-current="page">
            <img class="h-7 w-auto" src="/logo1.png" alt="PDF Merger Logo">
            <p class="sr-only">PDF Merger</p>
          </router-link>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex md:items-center md:justify-center md:gap-5">
          <router-link
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            class="inline-block rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white"
            :class="isActive(link.path) ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-700 dark:text-gray-300'"
          >
            <i :class="link.icon + ' mr-2'"></i>
            {{ link.name }}
          </router-link>
        </div>

        <!-- Right side buttons -->
        <div class="flex items-center justify-end gap-3">
          <!-- Theme Toggle -->
          <button
            @click="themeStore.toggleTheme()"
            class="inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:ring-gray-700 dark:hover:bg-gray-700"
            :title="themeStore.isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
          >
            <i v-if="themeStore.isDark" class="fas fa-sun mr-2 text-yellow-500"></i>
            <i v-else class="fas fa-moon mr-2 text-indigo-500"></i>
            {{ themeStore.isDark ? 'Light' : 'Dark' }}
          </button>

          <!-- Mobile Menu Button -->
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-150 hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:ring-gray-700 dark:hover:bg-gray-700"
          >
            <i v-if="!mobileMenuOpen" class="fas fa-bars"></i>
            <i v-else class="fas fa-times"></i>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="mobileMenuOpen" class="md:hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
        <div class="flex flex-col gap-2">
          <router-link
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            @click="mobileMenuOpen = false"
            class="inline-flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white"
            :class="isActive(link.path) ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-700 dark:text-gray-300'"
          >
            <i :class="link.icon + ' mr-3 w-5 text-center'"></i>
            {{ link.name }}
          </router-link>
          
          <!-- Mobile Theme Toggle -->
          <button
            @click="themeStore.toggleTheme()"
            class="inline-flex items-center rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white text-gray-700 dark:text-gray-300"
          >
            <i v-if="themeStore.isDark" class="fas fa-sun mr-3 w-5 text-center text-yellow-500"></i>
            <i v-else class="fas fa-moon mr-3 w-5 text-center text-indigo-500"></i>
            {{ themeStore.isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode' }}
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useThemeStore } from '../stores/theme'

const route = useRoute()
const themeStore = useThemeStore()
const mobileMenuOpen = ref(false)

const navLinks = [
  { name: 'Home', path: '/', icon: 'fas fa-home' },
  { name: 'Blogs', path: '/contact', icon: 'fas fa-envelope' }
]

const isActive = (path) => route.path === path
</script>

<style scoped>
.router-link-active {
  background-color: rgba(243, 244, 246, 0.8);
}

.dark .router-link-active {
  background-color: rgba(31, 41, 55, 0.8);
}
</style>