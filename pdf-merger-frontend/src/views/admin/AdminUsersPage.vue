<template>
    <AdminLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">User Management</h2>
                <button @click="fetchUsers"
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
                                    Email</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Admin</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="user in users" :key="user.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                            {{ getInitials(user.name) }}
                                        </div>
                                        <span class="ml-3 font-medium text-gray-900 dark:text-white">{{ user.name
                                        }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ user.email }}</td>
                                <td class="px-6 py-4">
                                    <button @click="toggleAdmin(user)" :disabled="user.id === authStore.user?.id" :class="[
                                        'px-3 py-1.5 rounded-full text-xs font-semibold transition-all',
                                        user.id === authStore.user?.id ? 'opacity-50 cursor-not-allowed' : '',
                                        user.is_admin
                                            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200'
                                            : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200'
                                    ]">
                                        <i :class="user.is_admin ? 'fas fa-check mr-1' : 'fas fa-times mr-1'"></i>
                                        {{ user.is_admin ? 'Admin' : 'User' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{
                                    formatDate(user.created_at) }}</td>
                                <td class="px-6 py-4">
                                    <button @click="deleteUser(user)" :disabled="user.id === authStore.user?.id" :class="[
                                        'p-2 rounded-lg transition-colors',
                                        user.id === authStore.user?.id
                                            ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed'
                                            : 'text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20'
                                    ]">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
import { useAuthStore } from '../../stores/auth'
import Swal from 'sweetalert2'

const authStore = useAuthStore()
const users = ref([])

onMounted(fetchUsers)

async function fetchUsers() {
    try {
        const response = await axios.get('/api/admin/users')
        users.value = response.data
    } catch (error) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to load users', showConfirmButton: false, timer: 3000 })
    }
}

async function toggleAdmin(user) {
    try {
        await axios.put(`/api/admin/users/${user.id}`, { is_admin: !user.is_admin })
        user.is_admin = !user.is_admin
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: `User ${user.is_admin ? 'promoted to' : 'removed from'} admin`, showConfirmButton: false, timer: 2000 })
    } catch (error) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to update user', showConfirmButton: false, timer: 3000 })
    }
}

async function deleteUser(user) {
    const result = await Swal.fire({
        title: 'Delete User?',
        text: `Are you sure you want to delete ${user.name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete'
    })

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/admin/users/${user.id}`)
            users.value = users.value.filter(u => u.id !== user.id)
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'User deleted', showConfirmButton: false, timer: 2000 })
        } catch (error) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: error.response?.data?.message || 'Failed to delete user', showConfirmButton: false, timer: 3000 })
        }
    }
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString()
}
</script>
