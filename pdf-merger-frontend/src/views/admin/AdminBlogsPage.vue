<template>
    <AdminLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Blog Management</h2>
                <button @click="openModal()"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-colors">
                    <i class="fas fa-plus mr-2"></i>New Blog
                </button>
            </div>

            <div v-if="blogs.length === 0"
                class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-gray-100 dark:border-gray-700">
                <i class="fas fa-newspaper text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Blog Posts Yet</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Create your first blog post to get started.</p>
                <button @click="openModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                    Create First Post
                </button>
            </div>

            <div v-else class="grid gap-4">
                <div v-for="blog in blogs" :key="blog.id"
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ blog.title }}</h3>
                            <span
                                :class="['px-2 py-0.5 rounded-full text-xs font-medium', blog.is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700']">
                                {{ blog.is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">{{ blog.excerpt || 'No excerpt' }}</p>
                        <p class="text-xs text-gray-400">By {{ blog.author?.name }} · {{ formatDate(blog.created_at) }}
                        </p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <button @click="openModal(blog)"
                            class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button @click="deleteBlog(blog)"
                            class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ editingBlog ? 'Edit Blog' : 'New Blog Post' }}
                    </h2>
                    <button @click="closeModal" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form @submit.prevent="saveBlog" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input v-model="form.title" type="text" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excerpt</label>
                        <input v-model="form.excerpt" type="text" placeholder="Brief description..."
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                        <textarea v-model="form.content" rows="10" required
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" v-model="form.is_published" id="published"
                            class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                        <label for="published" class="text-sm text-gray-700 dark:text-gray-300">Publish
                            immediately</label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-colors">
                            {{ editingBlog ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AdminLayout from '../../components/AdminLayout.vue'
import Swal from 'sweetalert2'

const blogs = ref([])
const showModal = ref(false)
const editingBlog = ref(null)
const form = ref({ title: '', excerpt: '', content: '', is_published: false })

onMounted(fetchBlogs)

async function fetchBlogs() {
    try {
        const response = await axios.get('/api/admin/blogs')
        blogs.value = response.data
    } catch (error) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to load blogs', showConfirmButton: false, timer: 3000 })
    }
}

function openModal(blog = null) {
    editingBlog.value = blog
    if (blog) {
        form.value = { title: blog.title, excerpt: blog.excerpt || '', content: blog.content, is_published: blog.is_published }
    } else {
        form.value = { title: '', excerpt: '', content: '', is_published: false }
    }
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    editingBlog.value = null
}

async function saveBlog() {
    try {
        if (editingBlog.value) {
            await axios.put(`/api/admin/blogs/${editingBlog.value.id}`, form.value)
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Blog updated', showConfirmButton: false, timer: 2000 })
        } else {
            await axios.post('/api/admin/blogs', form.value)
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Blog created', showConfirmButton: false, timer: 2000 })
        }
        closeModal()
        await fetchBlogs()
    } catch (error) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to save blog', showConfirmButton: false, timer: 3000 })
    }
}

async function deleteBlog(blog) {
    const result = await Swal.fire({
        title: 'Delete Blog?',
        text: `Are you sure you want to delete "${blog.title}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete'
    })

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/admin/blogs/${blog.id}`)
            blogs.value = blogs.value.filter(b => b.id !== blog.id)
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Blog deleted', showConfirmButton: false, timer: 2000 })
        } catch (error) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Failed to delete blog', showConfirmButton: false, timer: 3000 })
        }
    }
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString()
}
</script>
