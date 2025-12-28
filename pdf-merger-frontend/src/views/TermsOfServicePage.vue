<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <NavigationBar />

        <div class="pt-32 pb-24 px-4">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">Terms of Service</h1>

                <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 space-y-6">
                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">1. Use of Service</h2>
                        <p>DocForge provides free PDF tools for personal and professional use. By using our services,
                            you agree to use them responsibly and in compliance with all applicable laws.</p>
                    </section>

                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">2. Disclaimer</h2>
                        <p>Our tools are provided "as is" without warranty of any kind. While we strive for 100%
                            accuracy and security, we are not liable for any data loss or errors during processing.</p>
                    </section>

                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">3. Changes to Terms</h2>
                        <p>We reserve the right to modify these terms at any time. Your continued use of the site
                            signifies your acceptance of any updates.</p>
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
