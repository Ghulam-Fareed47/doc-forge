<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <NavigationBar />

        <div class="pt-32 pb-24 px-4">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-12 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Contact Us</h1>
                    <p class="text-gray-600 dark:text-gray-400">Have questions or feedback? We'd love to hear from you.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact Info -->
                    <div
                        class="bg-gray-50 dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700">
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Email</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">support@docforge.com</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Location</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Digital Nomads
                                        Lane<br>Remote-First Office</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simple Form Placeholder -->
                    <div class="space-y-4 text-center">
                        <div class="p-8 bg-indigo-600 rounded-3xl text-white">
                            <h3 class="text-lg font-bold mb-2">Message Us Directly</h3>
                            <p class="text-indigo-100 text-sm mb-6">Our team typically responds within 24 hours.</p>
                            <button
                                class="w-full py-3 px-6 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                                Open Inquiry Form
                            </button>
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
</script>
