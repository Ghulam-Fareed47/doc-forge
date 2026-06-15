<template>
    <AdminLayout>
        <!-- Dashboard Content -->
        <div>
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.total_users }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Users</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ stats.admin_users
                            }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-shield text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Operations</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{
                                stats.total_operations }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-cogs text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data Processed</p>
                            <p class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-1">{{
                                formatSize(stats.total_data_processed) }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-database text-orange-600 dark:text-orange-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
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
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
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
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tool</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Size</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="activity in recentActivity" :key="activity.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ getInitials(activity.user?.name || 'G') }}
                                        </div>
                                        <span class="ml-3 text-sm text-gray-900 dark:text-white">{{ activity.user?.name
                                            || 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full"
                                        :class="getToolColor(activity.tool_name)">
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

            <!-- Dashboard Filler: Support Messages (Dummy Data) -->
            <div
                class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Latest Support Messages</h3>
                    <span
                        class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-xs font-bold rounded-full uppercase">Demo
                        Data</span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div v-for="msg in dummyMessages" :key="msg.id"
                        class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center text-white font-bold"
                                :class="msg.color">
                                {{ msg.author[0] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ msg.author
                                    }}</h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ msg.time }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 truncate">{{ msg.subject }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 line-clamp-1 italic">"{{ msg.preview
                                }}"</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span
                                    :class="['px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider', msg.status === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700']">
                                    {{ msg.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="p-4 bg-gray-50 dark:bg-gray-900/50 text-center border-t border-gray-100 dark:border-gray-700">
                    <button class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800">View
                        All Messages</button>
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

const stats = ref({ total_users: 157, admin_users: 4, total_operations: 2843, total_data_processed: 15461882265 })
const analytics = ref({
    usage_by_day: [
        { date: '2025-12-22', count: 45 },
        { date: '2025-12-23', count: 52 },
        { date: '2025-12-24', count: 38 },
        { date: '2025-12-25', count: 65 },
        { date: '2025-12-26', count: 48 },
        { date: '2025-12-27', count: 72 },
        { date: '2025-12-28', count: 58 },
    ],
    usage_by_tool: [
        { tool_name: 'merge-pdf', count: 450 },
        { tool_name: 'split-pdf', count: 320 },
        { tool_name: 'compress-pdf', count: 280 },
        { tool_name: 'images-to-pdf', count: 150 },
        { tool_name: 'extract-text', count: 120 },
        { tool_name: 'watermark', count: 138 },
    ],
    users_by_day: []
})
const recentActivity = ref([
    { id: 1, user: { name: 'John Doe' }, tool_name: 'merge-pdf', file_size: 2500000, created_at: '2025-12-28T14:30:00Z' },
    { id: 2, user: { name: 'Jane Smith' }, tool_name: 'compress-pdf', file_size: 8500000, created_at: '2025-12-28T15:45:00Z' },
    { id: 3, user: { name: 'Mike Ross' }, tool_name: 'split-pdf', file_size: 1200000, created_at: '2025-12-28T16:20:00Z' },
    { id: 4, user: { name: 'Sarah Connor' }, tool_name: 'watermark', file_size: 4500000, created_at: '2025-12-28T17:10:00Z' },
    { id: 5, user: { name: 'Tommy Shelby' }, tool_name: 'extract-text', file_size: 500000, created_at: '2025-12-28T18:05:00Z' },
])
const dummyMessages = [
    { id: 1, author: 'Alex Rivera', subject: 'Inquiry about API access', preview: 'I am interested in using your PDF merging API for my company project...', time: '2h ago', status: 'new', color: 'bg-blue-500' },
    { id: 2, author: 'Sarah Chen', subject: 'Compress PDF issue', preview: 'The tool says file too large even though its only 10MB. Please check...', time: '5h ago', status: 'urgent', color: 'bg-red-500' },
    { id: 3, author: 'Marcus Wright', subject: 'Bulk features request', preview: 'Do you offer any enterprise plans for high volume processing?', time: '1d ago', status: 'new', color: 'bg-purple-500' },
]

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

        // Merge with dummy data: only use API data if it's meaningful (non-zero)
        if (dashboardRes.data.total_users) stats.value.total_users = dashboardRes.data.total_users
        if (dashboardRes.data.admin_users) stats.value.admin_users = dashboardRes.data.admin_users
        if (dashboardRes.data.total_operations) stats.value.total_operations = dashboardRes.data.total_operations
        if (dashboardRes.data.total_data_processed) stats.value.total_data_processed = dashboardRes.data.total_data_processed

        if (dashboardRes.data.recent_activity?.length) {
            recentActivity.value = dashboardRes.data.recent_activity
        }
        if (analyticsRes.data.usage_by_day?.length) {
            analytics.value.usage_by_day = analyticsRes.data.usage_by_day
        }
        if (analyticsRes.data.usage_by_tool?.length) {
            analytics.value.usage_by_tool = analyticsRes.data.usage_by_tool
        }
    } catch (error) {
        console.error('Failed to fetch data', error)
        // Keep dummy data on error
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
