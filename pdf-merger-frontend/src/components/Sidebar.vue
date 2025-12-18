<template>

  <aside :class="[
    'fixed inset-y-0 left-0 z-40 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-all duration-300 ease-in-out md:translate-x-0 md:relative md:inset-auto md:bg-transparent md:dark:bg-transparent md:border-0 md:shadow-none',
    isOpen ? 'translate-x-0' : '-translate-x-full',
    isCollapsed ? 'md:w-20' : 'md:w-72'
  ]" class="flex flex-col h-full bg-white dark:bg-gray-900 md:bg-transparent md:dark:bg-transparent"
    :style="{ 'transition-timing-function': 'cubic-bezier(0.4, 0, 0.2, 1)' }">
    <div
      class="h-full flex flex-col p-4 md:p-6 bg-white dark:bg-gray-900 md:rounded-2xl md:shadow-2xl border-r md:border border-gray-200 dark:border-gray-800">
      <!-- Sidebar Header -->
      <div class="flex items-center justify-between mb-8" :class="{ 'flex-col gap-4': isCollapsed }">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white transition-all duration-300" :class="{
          'opacity-0 w-0 hidden': isCollapsed,
          'opacity-100 w-auto': !isCollapsed
        }">
          PDF Tools
        </h2>
        <div class="flex items-center gap-2">
          <!-- Collapse Button -->
          <button @click="toggleCollapse"
            class="hidden md:flex items-center justify-center w-8 h-8 text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 transition-colors bg-gray-100 dark:bg-gray-800 rounded-full hover:bg-primary-50 dark:hover:bg-primary-900/30">
            <i class="fas fa-chevron-left transition-transform duration-300" :class="{ 'rotate-180': isCollapsed }"></i>
          </button>

          <!-- Close Button -->
          <button @click="$emit('close')"
            class="md:hidden p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>

      <!-- Tools List -->
      <nav class="space-y-2 flex-1 overflow-y-auto custom-scrollbar">
        <router-link v-for="tool in tools" :key="tool.id" :to="tool.path" @click="$emit('close')"
          class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300" :class="[
            isActive(tool.path)
              ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30'
              : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400',
            isCollapsed ? 'justify-center px-2' : 'gap-3'
          ]" :title="isCollapsed ? tool.name : ''">
          <i :class="[tool.icon, 'text-lg transition-transform duration-300 group-hover:scale-110']"></i>
          <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300" :class="{
            'w-0 opacity-0': isCollapsed,
            'w-auto opacity-100': !isCollapsed
          }">
            {{ tool.name }}
          </span>
        </router-link>
      </nav>
    </div>
  </aside>

  <!-- Overlay -->
  <div v-if="isOpen" @click="$emit('close')"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 md:hidden transition-opacity duration-300"
    :class="isOpen ? 'opacity-100' : 'opacity-0'"></div>

</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref } from 'vue'

const route = useRoute()
const isCollapsed = ref(true)

defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['close'])

const tools = [
  { id: 'merge', name: 'Merge PDF', icon: 'fas fa-file-pdf', path: '/merge-pdf' },
  { id: 'split', name: 'Split PDF', icon: 'fas fa-cut', path: '/split-pdf' },
  { id: 'compress', name: 'Compress PDF', icon: 'fas fa-compress', path: '/compress-pdf' },
  { id: 'pdf-to-images', name: 'PDF to Images', icon: 'fas fa-image', path: '/pdf-to-images' },
  { id: 'images-to-pdf', name: 'Images to PDF', icon: 'fas fa-file-pdf', path: '/images-to-pdf' },
  { id: 'extract-text', name: 'Extract Text', icon: 'fas fa-file-alt', path: '/extract-text' },
  { id: 'watermark', name: 'Watermark PDF', icon: 'fas fa-tint', path: '/watermark-pdf' }
]

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value
}

const isActive = (path) => {
  if (path === '/' && route.path === '/') return true
  if (path !== '/' && route.path.startsWith(path)) return true
  return false
}
</script>

