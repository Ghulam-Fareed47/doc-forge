<template>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside :class="[
            'fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white transform transition-transform duration-300 ease-in-out',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gray-800/50 border-b border-gray-700">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-pdf text-white"></i>
                    </div>
                    <span class="text-lg font-bold">PDF Admin</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4">
                <div class="space-y-1">
                    <router-link v-for="item in menuItems" :key="item.path" :to="item.path" :class="[
                        'flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                        isActive(item.path)
                            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30'
                            : 'text-gray-300 hover:bg-gray-700/50 hover:text-white'
                    ]">
                        <i :class="[item.icon, 'w-5 text-center']"></i>
                        <span>{{ item.name }}</span>
                    </router-link>
                </div>

                <!-- Divider -->
                <div class="my-6 border-t border-gray-700"></div>

                <!-- Quick Actions -->
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-4">Quick Actions</div>
                <a href="/" target="_blank"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:bg-gray-700/50 hover:text-white transition-all">
                    <i class="fas fa-external-link-alt w-5 text-center"></i>
                    <span>View Website</span>
                </a>
            </nav>

            <!-- User Info (Bottom) -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700 bg-gray-800/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                        {{ userInitials }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white truncate">{{ authStore.user?.name }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ authStore.user?.email }}</div>
                    </div>
                    <button @click="handleLogout" class="p-2 text-gray-400 hover:text-red-400 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white dark:bg-gray-800 shadow-sm">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">{{ currentPageTitle }}</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <button @click="toggleDark"
                            class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <i :class="isDark ? 'fas fa-sun' : 'fas fa-moon'"></i>
                        </button>
                        <button @click="refreshData"
                            class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

onMounted(() => {
    if (!authStore.isLoggedIn) {
        router.push('/login')
        return
    }
    if (!authStore.user?.is_admin) {
        router.push('/')
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Access Denied',
            text: 'Admin only area',
            showConfirmButton: false,
            timer: 3000
        })
    }
})
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import Swal from 'sweetalert2'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const sidebarOpen = ref(false)
const isDark = ref(document.documentElement.classList.contains('dark'))

const menuItems = [
    { name: 'Dashboard', path: '/admin', icon: 'fas fa-chart-pie' },
    { name: 'Users', path: '/admin/users', icon: 'fas fa-users' },
    { name: 'Blogs', path: '/admin/blogs', icon: 'fas fa-newspaper' },
    { name: 'Usage Logs', path: '/admin/logs', icon: 'fas fa-history' },
    { name: 'Settings', path: '/admin/settings', icon: 'fas fa-cog' },
]

const currentPageTitle = computed(() => {
    const item = menuItems.find(m => m.path === route.path)
    return item?.name || 'Dashboard'
})

const userInitials = computed(() => {
    const name = authStore.user?.name || 'Admin'
    return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
})

function isActive(path) {
    return route.path === path
}

function toggleDark() {
    isDark.value = !isDark.value
    document.documentElement.classList.toggle('dark')
    localStorage.setItem('darkMode', isDark.value)
}

async function handleLogout() {
    const result = await Swal.fire({
        title: 'Logout?',
        text: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6366f1',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, logout'
    })

    if (result.isConfirmed) {
        await authStore.logout()
        router.push('/')
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Logged out successfully',
            showConfirmButton: false,
            timer: 2000
        })
    }
}

function refreshData() {
    window.location.reload()
}
</script>

<style>
/* SweetAlert2 Global Overrides */
.swal2-popup {
    border-radius: 1.5rem !important;
    padding: 2rem !important;
}

.swal2-title {
    font-weight: 700 !important;
    color: #111827 !important;
}

.swal2-html-container {
    color: #4b5563 !important;
}

.swal2-confirm.swal2-styled, 
.swal2-cancel.swal2-styled {
    border-radius: 0.75rem !important;
    padding: 0.75rem 2rem !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    /* Force white text visibility */
    color: #ffffff !important;
    box-shadow: none !important;
    transition: all 0.2s ease !important;
}

.swal2-confirm.swal2-styled:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
}

.swal2-cancel.swal2-styled:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
}

/* Dark mode overrides for SweetAlert2 */
.dark .swal2-popup {
    background-color: #1f2937 !important;
    border: 1px solid #374151 !important;
}

.dark .swal2-title {
    color: #f9fafb !important;
}

.dark .swal2-html-container {
    color: #9ca3af !important;
}
</style>
