<template>
  <GlobalLoader v-if="isLoading" />
  <RouterView />
</template>

<script setup>
import { RouterView } from 'vue-router'
import GlobalLoader from './components/GlobalLoader.vue'
import { useLoader } from './composables/useLoader'

const { isLoading } = useLoader()
</script>

<style scoped>
/* Global styles if needed */
</style>