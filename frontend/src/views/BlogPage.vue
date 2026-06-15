<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
        <NavigationBar />

        <div class="pt-32 pb-24 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Hero Section -->
                <div class="text-center mb-16">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        Latest <span
                            class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">Insights</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                        Tips, guides, and news about PDF management and productivity.
                    </p>
                </div>

                <!-- Blog Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article v-for="post in posts" :key="post.id"
                        class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
                        <div class="p-8 flex-1 flex flex-col">
                            <header class="mb-6">
                                <div class="inline-flex items-center gap-2 mb-4">
                                    <span
                                        :class="`px-3 py-1 rounded-full bg-gradient-to-r ${post.categoryClass} text-sm font-medium opacity-90`">
                                        {{ post.category }}
                                    </span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                                    {{ post.title }}
                                </h3>
                            </header>
                            <div class="text-gray-600 dark:text-gray-400 space-y-4 mb-6 flex-1">
                                <p>{{ post.excerpt }}</p>
                            </div>
                            <footer
                                class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-auto">
                                <div class="flex items-center gap-3">
                                    <div
                                        :class="`w-10 h-10 rounded-full bg-gradient-to-r ${post.avatarClass} flex items-center justify-center text-white font-bold`">
                                        {{ post.authorInitials }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">{{ post.author }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ post.authorRole }}
                                        </div>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </article>
                </div>

                <!-- Newsletter CTA -->
                <div class="mt-24">
                    <div
                        class="relative w-full rounded-2xl overflow-hidden bg-gradient-to-br from-primary-600 to-indigo-600 dark:from-primary-900 dark:to-indigo-900 text-white px-8 py-12 md:px-16 md:py-14 shadow-2xl text-center">
                        <h2 class="text-2xl md:text-3xl font-bold mb-4">Never Miss an Update</h2>
                        <p class="text-white/90 mb-8 max-w-xl mx-auto">Get the latest tutorials and PDF tips delivered
                            straight to your inbox.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-lg mx-auto">
                            <input type="email" placeholder="Enter your email"
                                class="w-full bg-white/10 border-2 border-white/20 rounded-xl px-4 py-3 text-white placeholder:text-white/50 focus:outline-none focus:border-white/40 focus:bg-white/15 transition-all duration-300 backdrop-blur-sm" />
                            <button
                                class="bg-white text-primary-800 px-6 py-3 rounded-xl font-bold hover:bg-gray-100 transition-colors shadow-lg">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <FooterSection />
    </div>
</template>

<script setup>
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'

const posts = [
    {
        id: 1,
        category: 'Tutorial',
        categoryClass: 'from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 text-primary-700 dark:text-primary-300',
        title: 'Advanced PDF Management Tips for Professionals',
        excerpt: 'Discover how to optimize your PDF workflow with these advanced techniques that can save you hours every week.',
        author: 'John Doe',
        authorRole: 'PDF Expert',
        authorInitials: 'JD',
        avatarClass: 'from-primary-500 to-indigo-500'
    },
    {
        id: 2,
        category: 'Security',
        categoryClass: 'from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-700 dark:text-green-300',
        title: 'How We Keep Your Documents Safe and Secure',
        excerpt: 'Learn about our encryption protocols and privacy measures that ensure your documents are always protected.',
        author: 'Alex Smith',
        authorRole: 'Security Lead',
        authorInitials: 'AS',
        avatarClass: 'from-green-500 to-emerald-500'
    },
    {
        id: 3,
        category: 'Productivity',
        categoryClass: 'from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-700 dark:text-blue-300',
        title: 'Streamline Your Document Workflow in 2024',
        excerpt: 'Latest trends and tools to make your document management more efficient than ever before.',
        author: 'Maria Johnson',
        authorRole: 'Product Manager',
        authorInitials: 'MJ',
        avatarClass: 'from-blue-500 to-cyan-500'
    },
    {
        id: 4,
        category: 'Guide',
        categoryClass: 'from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 text-purple-700 dark:text-purple-300',
        title: 'The Ultimate Guide to Merging Large Documents',
        excerpt: 'Struggling with massive PDF files? Here are the best practices for handling large merges without losing quality.',
        author: 'David Lee',
        authorRole: 'Tech Lead',
        authorInitials: 'DL',
        avatarClass: 'from-purple-500 to-pink-500'
    },
    {
        id: 5,
        category: 'News',
        categoryClass: 'from-orange-100 to-amber-100 dark:from-orange-900/30 dark:to-amber-900/30 text-orange-700 dark:text-orange-300',
        title: 'New Feature: Drag-and-Drop Reordering',
        excerpt: 'We have updated our merge tool! You can now easily reorder your files with a simple drag and drop interface.',
        author: 'Sarah Product',
        authorRole: 'Product Manager',
        authorInitials: 'SP',
        avatarClass: 'from-orange-500 to-amber-500'
    },
    {
        id: 6,
        category: 'Tutorial',
        categoryClass: 'from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 text-primary-700 dark:text-primary-300',
        title: 'How to Compress PDFs Without Losing Quality',
        excerpt: 'File size too big for email? Learn the secrets to compressing your documents while keeping them crisp and clear.',
        author: 'Sam Code',
        authorRole: 'Full Stack Dev',
        authorInitials: 'SC',
        avatarClass: 'from-primary-500 to-indigo-500'
    }
]
</script>
