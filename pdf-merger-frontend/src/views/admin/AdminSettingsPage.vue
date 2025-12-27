<template>
    <AdminLayout>
        <div class="space-y-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Settings</h2>

            <!-- App Info -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-indigo-500"></i>Application Info
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">App Name</span>
                        <span class="font-medium text-gray-900 dark:text-white">PDF Merger</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Version</span>
                        <span class="font-medium text-gray-900 dark:text-white">1.0.0</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Environment</span>
                        <span class="font-medium text-green-600">Development</span>
                    </div>
                    <div class="flex justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                        <span class="text-gray-500 dark:text-gray-400">Database</span>
                        <span class="font-medium text-gray-900 dark:text-white">MySQL</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-bolt mr-2 text-yellow-500"></i>Quick Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button @click="clearCache"
                        class="flex items-center justify-center gap-2 p-4 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-xl hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                        <i class="fas fa-broom"></i>
                        <span>Clear Cache</span>
                    </button>
                    <button @click="refreshData"
                        class="flex items-center justify-center gap-2 p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <i class="fas fa-sync-alt"></i>
                        <span>Refresh Data</span>
                    </button>
                    <button @click="exportData"
                        class="flex items-center justify-center gap-2 p-4 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                        <i class="fas fa-download"></i>
                        <span>Export Data</span>
                    </button>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-red-200 dark:border-red-900">
                <h3 class="text-lg font-medium text-red-600 mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
                </h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">These actions are irreversible. Please proceed
                    with caution.</p>
                <button @click="resetDatabase"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors">
                    <i class="fas fa-skull-crossbones mr-2"></i>Reset All Data
                </button>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../components/AdminLayout.vue'
import Swal from 'sweetalert2'

function clearCache() {
    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Cache cleared successfully', showConfirmButton: false, timer: 2000 })
}

function refreshData() {
    window.location.reload()
}

function exportData() {
    Swal.fire({ toast: true, position: 'top-end', icon: 'info', title: 'Export feature coming soon', showConfirmButton: false, timer: 2000 })
}

async function resetDatabase() {
    const result = await Swal.fire({
        title: 'Reset All Data?',
        text: 'This will permanently delete all data. This action cannot be undone!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, reset everything',
        input: 'text',
        inputPlaceholder: 'Type "RESET" to confirm',
        inputValidator: (value) => {
            if (value !== 'RESET') return 'You need to type "RESET" to confirm'
        }
    })

    if (result.isConfirmed) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Data reset (demo only)', showConfirmButton: false, timer: 2000 })
    }
}
</script>
