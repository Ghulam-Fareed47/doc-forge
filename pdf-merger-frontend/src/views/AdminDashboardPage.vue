<template>
    <AdminLayout>
        <!-- Dashboard Content -->
        <div>
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.total_users }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Users</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ stats.admin_users }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-shield text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Operations</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ stats.total_operations }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-cogs text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data Processed</p>
                            <p class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-1">{{ formatSize(stats.total_data_processed) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-database text-orange-600 dark:text-orange-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Usage Over Time</h3>
                    <div class="h-72">
                        <Line v-if="usageChartData.labels.length" :data="usageChartData" :options="chartOptions" />
                        <div v-else class="flex items-center justify-center h-full text-gray-400">
                            <div class="text-center">
                                <i class="fas fa-chart-line text-4xl mb-2"></i>
                                <p>No usage data yet</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Usage by Tool</h3>
                    <div class="h-72">
                        <Doughnut v-if="toolChartData.labels.length" :data="toolChartData" :options="doughnutOptions" />
                        <div v-else class="flex items-center justify-center h-full text-gray-400">
                            <div class="text-center">
                                <i class="fas fa-chart-pie text-4xl mb-2"></i>
                                <p>No tool usage yet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tool</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="activity in recentActivity" :key="activity.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ getInitials(activity.user?.name || 'G') }}
                                        </div>
                                        <span class="ml-3 text-sm text-gray-900 dark:text-white">{{ activity.user?.name || 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full" :class="getToolColor(activity.tool_name)">
                                        {{ activity.tool_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ formatSize(activity.file_size) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ formatDate(activity.created_at) }}
                                </td>
                            </tr>
                            <tr v-if="!recentActivity.length">
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p>No recent activity</p>
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
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import AdminLayout from '../components/AdminLayout.vue'
import { Line, Doughnut } from 'vue-chartjs'
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    ArcElement,
    Title,
    Tooltip,
    Legend,
    Filler
} from 'chart.js'
import Swal from 'sweetalert2'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, ArcElement, Title, Tooltip, Legend, Filler)

const stats = ref({ total_users: 0, admin_users: 0, total_operations: 0, total_data_processed: 0 })
const analytics = ref({ usage_by_day: [], usage_by_tool: [], users_by_day: [] })
const recentActivity = ref([])

// Chart data
const usageChartData = computed(() => ({
    labels: analytics.value.usage_by_day.map(d => d.date),
    datasets: [{
        label: 'Operations',
        data: analytics.value.usage_by_day.map(d => d.count),
        borderColor: 'rgb(99, 102, 241)',
        backgroundColor: 'rgba(99, 102, 241, 0.1)',
        fill: true,
        tension: 0.4
    }]
}))

const toolChartData = computed(() => ({
    labels: analytics.value.usage_by_tool.map(d => d.tool_name),
    datasets: [{
        data: analytics.value.usage_by_tool.map(d => d.count),
        backgroundColor: ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4']
    }]
}))

const chartOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
const doughnutOptions = { responsive: true, maintainAspectRatio: false }

onMounted(async () => {
    // Admin check is now handled globally in AdminLayout.vue
    await fetchData()
})

async function fetchData() {
    try {
        const [dashboardRes, analyticsRes] = await Promise.all([
            axios.get('/api/admin/dashboard'),
            axios.get('/api/admin/analytics')
        ])
        stats.value = dashboardRes.data
        recentActivity.value = dashboardRes.data.recent_activity || []
        analytics.value = analyticsRes.data
    } catch (error) {
        console.error('Failed to fetch data', error)
        if (error.response?.status !== 403) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to load dashboard', showConfirmButton: false, timer: 3000 })
        }
    }
}

function formatSize(bytes) {
    if (!bytes) return 'N/A'
    const units = ['B', 'KB', 'MB', 'GB']
    let size = bytes, unitIndex = 0
    while (size >= 1024 && unitIndex < units.length - 1) { size /= 1024; unitIndex++ }
    return `${size.toFixed(1)} ${units[unitIndex]}`
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString()
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
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
