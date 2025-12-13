<template>
  <aside
    :class="[
      'sticky left-0 top-0 h-52 z-40 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-all duration-300 ease-in-out',
      isOpen ? 'translate-x-0' : '-translate-x-full',
      'md:translate-x-0 md:top-24 md:left-4 md:bottom-4 md:h-auto md:rounded-2xl md:border md:shadow-xl md:bg-white/90 md:dark:bg-gray-900/90 md:backdrop-blur-md',
      isCollapsed ? 'md:w-16' : 'md:w-64'
    ]"
    class="overflow-y-auto transition-all duration-500 ease-in-out"
    :style="{ 'transition-timing-function': 'cubic-bezier(0.4, 0, 0.2, 1)' }"
  >
    <div class="p-4">
      <!-- Sidebar Header -->
      <div class="flex items-center justify-between mb-6" :class="{ 'flex-col gap-2': isCollapsed }">
        <h2 
          class="text-lg font-bold text-gray-900 dark:text-white transition-all duration-500 ease-in-out"
          :class="{
            'opacity-0 max-w-0': isCollapsed, 
            'opacity-100 max-w-full': !isCollapsed,
            'overflow-hidden': true
          }"
          style="transition-property: opacity, max-width; white-space: nowrap;"
        >
          PDF Tools
        </h2>
        <div class="flex items-center gap-2">
          <!-- Collapse Button with smooth rotation -->
          <button
            @click="toggleCollapse"
            class="hidden md:flex items-center justify-center p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-all duration-500 ease-in-out hover:scale-110 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full"
            :title="isCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
            :style="{ transform: isCollapsed ? 'rotate(0deg)' : 'rotate(180deg)' }"
          >
            <i class="fas fa-chevron-left transition-transform duration-500"></i>
          </button>
          
          <!-- Close Button for mobile -->
          <button
            @click="$emit('close')"
            class="md:hidden p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-all duration-300 hover:scale-110 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full"
          >
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>

      <!-- Tools List -->
      <nav class="space-y-2">
        <router-link
          v-for="tool in tools"
          :key="tool.id"
          :to="tool.path"
          @click="$emit('close')"
          class="flex items-center gap-3 px-4 py-3 rounded-lg text-left transition-all duration-500 ease-in-out overflow-hidden"
          :class="[
            isActive(tool.path)
              ? 'bg-gradient-to-r from-primary-600 to-indigo-600 text-white shadow-lg'
              : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800',
            isCollapsed ? 'justify-center px-3' : 'justify-start'
          ]"
          :title="isCollapsed ? tool.name : ''"
        >
          <i 
            :class="[tool.icon, 'text-center transition-transform duration-500']"
            :style="{ 'min-width': '20px' }"
          ></i>
          <span 
            class="font-medium transition-all duration-500 ease-in-out overflow-hidden"
            :class="{
              'opacity-0 max-w-0': isCollapsed, 
              'opacity-100 max-w-full': !isCollapsed,
            }"
            style="transition-property: opacity, max-width; white-space: nowrap;"
          >
            {{ tool.name }}
          </span>
        </router-link>
      </nav>
    </div>
  </aside>

  <!-- Overlay for mobile with fade animation -->
  <div
    v-if="isOpen"
    @click="$emit('close')"
    class="fixed inset-0 bg-black/50 z-30 md:hidden transition-opacity duration-300 ease-in-out"
    :class="isOpen ? 'opacity-100' : 'opacity-0'"
  ></div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref } from 'vue'

const route = useRoute()
const isCollapsed = ref(false)

defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['close'])

const tools = [
  { id: 'merge', name: 'Merge PDF', icon: 'fas fa-file-pdf', path: '/' },
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