<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-300">
        <NavigationBar />

        <div class="pt-32 pb-24 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Hero Section -->
                <div class="text-center mb-16">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        About <span
                            class="bg-gradient-to-r from-primary-600 to-indigo-600 bg-clip-text text-transparent">PDF
                            Merger</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                        We're on a mission to make document management simple, secure, and accessible for everyone.
                    </p>
                </div>

                <!-- content sections -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-24">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-gray-700">
                        <div
                            class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-rocket text-3xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Started in 2024, PDF Merger was built with a single goal: to provide free, high-quality PDF
                            tools without the hassle of software installation or expensive subscriptions. We believe
                            that basic document manipulation should be easy and accessible to everyone, from students to
                            professionals.
                        </p>
                    </div>
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-primary-500/20 to-indigo-500/20 rounded-3xl blur-3xl">
                        </div>
                        <div
                            class="relative bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-gray-700">
                            <div
                                class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-shield-alt text-3xl text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Privacy First</h2>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                We take your privacy seriously. That's why we engineered our platform to process files
                                securely. We don't read your documents, and all files are automatically deleted from our
                                servers after processing. Your data stays yours, always.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Team Section -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">The Team</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Built by passionate developers</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="member in team" :key="member.name"
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 text-center hover:-translate-y-2 transition-transform duration-300">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full mb-4 flex items-center justify-center text-3xl">
                            {{ member.avatar }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ member.name }}</h3>
                        <p class="text-primary-600 dark:text-primary-400 font-medium mb-3">{{ member.role }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ member.bio }}</p>
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

const team = [
    { name: 'Alex Design', role: 'Lead Designer', bio: 'Obsessed with pixel-perfect interfaces and user experience.', avatar: '🎨' },
    { name: 'Sam Code', role: 'Full Stack Dev', bio: 'Building robust processing engines for lightning-fast merges.', avatar: '💻' },
    { name: 'Sarah Product', role: 'Product Manager', bio: 'Ensuring we build exactly what our users need.', avatar: '🚀' }
]
</script>
