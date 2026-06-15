<script setup>
import { onMounted, onErrorCaptured, ref } from 'vue'
import { RouterView } from 'vue-router'
import GlobalLoader from './components/GlobalLoader.vue'
import { useLoader } from './composables/useLoader'
import { useAuthStore } from './stores/auth'

const { isLoading } = useLoader()
const authStore = useAuthStore()
const appError = ref(null)

onMounted(() => {
  // Auth initialization moved to main.js for better synchronization
})

onErrorCaptured((err) => {
  console.error('Captured Error:', err)
  appError.value = err
  return true
})
</script>

<template>
  <div v-if="appError" class="fixed inset-0 z-[100] bg-red-100 p-10 overflow-auto">
    <h1 class="text-2xl font-bold text-red-600 mb-4">Application Error</h1>
    <pre class="whitespace-pre-wrap text-red-800 font-mono">{{ appError.toString() }}</pre>
  </div>
  <GlobalLoader v-if="isLoading" />
  <RouterView />
</template>

<style scoped>
/* Global styles if needed */
</style>