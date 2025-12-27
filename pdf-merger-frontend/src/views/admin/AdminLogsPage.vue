<template>
    <AdminLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Usage Logs</h2>
                <button @click="fetchLogs"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tool</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    File Size</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="log in logs" :key="log.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ getInitials(log.user?.name || 'G') }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{
                                                log.user?.name || 'Guest' }}</p>
                                            <p class="text-xs text-gray-500">{{ log.user?.email || 'Unregistered' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full"
                                        :class="getToolColor(log.tool_name)">
                                        {{ log.tool_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 font-mono">
                                    {{ formatSize(log.file_size) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ formatDate(log.created_at) }}
                                </td>
                            </tr>
                            <tr v-if="!logs.length">
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p>No usage logs yet</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AdminLayout from '../../components/AdminLayout.vue'
import Swal from 'sweetalert2'

const logs = ref([])

onMounted(fetchLogs)

async function fetchLogs() {
    try {
        const response = await axios.get('/api/admin/usage-logs')
        logs.value = response.data.data || response.data
    } catch (error) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to load logs', showConfirmButton: false, timer: 3000 })
    }
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
}

function formatSize(bytes) {
    if (!bytes) return 'N/A'
    const units = ['B', 'KB', 'MB', 'GB']
    let size = bytes, unitIndex = 0
    while (size >= 1024 && unitIndex < units.length - 1) { size /= 1024; unitIndex++ }
    return `${size.toFixed(1)} ${units[unitIndex]}`
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString()
}

function getToolColor(toolName) {
    const colors = {
        'merge-pdf': 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        'split-pdf': 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
        'compress-pdf': 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'watermark': 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    }
    return colors[toolName] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
}
</script>
