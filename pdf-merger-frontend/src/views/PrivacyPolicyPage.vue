<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <NavigationBar />

        <div class="pt-32 pb-24 px-4">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">Privacy Policy</h1>

                <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 space-y-6">
                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">1. Data Privacy</h2>
                        <p>At DocForge, your privacy is our top priority. Our tools are designed to process files
                            locally in your browser. Your documents are never uploaded to our servers, ensuring absolute
                            confidentiality.</p>
                    </section>

                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">2. Information Collection
                        </h2>
                        <p>We do not collect personal information or document data. We may use anonymized analytics to
                            improve our service performance and user experience.</p>
                    </section>

                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">3. Cookies</h2>
                        <p>We use essential cookies to remember your preferences (like theme settings). No tracking or
                            third-party advertising cookies are used.</p>
                    </section>
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
