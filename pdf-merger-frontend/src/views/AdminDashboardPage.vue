<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <NavigationBar />

        <div class="container mx-auto px-4 pt-32 pb-12">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <!-- Header -->
                <div
                    class="p-8 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Admin Dashboard</h1>
                            <p class="text-gray-500 dark:text-gray-400">System Usage & Activity Logs</p>
                        </div>
                        <button @click="fetchLogs" :disabled="isLoading"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-sync-alt" :class="{ 'animate-spin': isLoading }"></i>
                            Refresh
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-8 bg-gray-50/50 dark:bg-gray-900/50">
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Operations</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ logs.length }}</div>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Users Active</div>
                        <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ uniqueUsers.size }}
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data Processed</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ formatSize(totalSize) }}
                        </div>
                    </div>
                </div>

                <!-- Logs Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">
                                <th class="px-8 py-4 font-semibold border-b dark:border-gray-700">User</th>
                                <th class="px-8 py-4 font-semibold border-b dark:border-gray-700">Tool</th>
                                <th class="px-8 py-4 font-semibold border-b dark:border-gray-700">File Size</th>
                                <th class="px-8 py-4 font-semibold border-b dark:border-gray-700">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="log in logs" :key="log.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                            {{ getInitials(log.user?.name || 'Guest') }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ log.user?.name ||
                                                'Guest User' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ log.user?.email ||
                                                'unregistered' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="getToolColor(log.tool_name)">
                                        {{ log.tool_name }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-gray-600 dark:text-gray-300 font-mono text-sm">
                                    {{ formatSize(log.file_size) }}
                                </td>
                                <td class="px-8 py-4 text-gray-500 dark:text-gray-400 text-sm">
                                    {{ formatDate(log.created_at) }}
                                </td>
                            </tr>
                            <tr v-if="logs.length === 0 && !isLoading">
                                <td colspan="4" class="px-8 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300 dark:text-gray-600 block"></i>
                                    No usage logs found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import NavigationBar from '../components/NavigationBar.vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const logs = ref([])
const isLoading = ref(false)
const router = useRouter()
const authStore = useAuthStore()

const uniqueUsers = computed(() => {
    const users = new Set()
    logs.value.forEach(log => {
        if (log.user_id) users.add(log.user_id)
    })
    return users
})

const totalSize = computed(() => {
    return logs.value.reduce((acc, log) => acc + (log.file_size || 0), 0)
})

onMounted(async () => {
    if (!authStore.isLoggedIn) {
        router.push('/login')
        return
    }
    await fetchLogs()
})

async function fetchLogs() {
    isLoading.value = true
    try {
        const response = await axios.get('/api/usage/logs')
        logs.value = response.data
    } catch (error) {
        console.error('Failed to fetch logs', error)
        if (error.response?.status === 401) {
            router.push('/login')
        }
    } finally {
        isLoading.value = false
    }
}

function formatSize(bytes) {
    if (!bytes) return 'N/A'
    const units = ['B', 'KB', 'MB', 'GB']
    let size = bytes
    let unitIndex = 0
    while (size >= 1024 && unitIndex < units.length - 1) {
        size /= 1024
        unitIndex++
    }
    return `${size.toFixed(1)} ${units[unitIndex]}`
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString()
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
}

function getToolColor(toolName) {
    const colors = {
        'merge-pdf': 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
        'split-pdf': 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
        'compress-pdf': 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
        'watermark': 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
        'default': 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300'
    }
    return colors[toolName] || colors['default']
}
</script>
