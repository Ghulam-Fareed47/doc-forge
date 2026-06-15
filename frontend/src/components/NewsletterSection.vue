<template>
    <section class="py-12 px-4">
        <div class="container mx-auto">
            <div
                class="bg-indigo-600 rounded-3xl p-8 md:p-12 lg:p-16 text-white text-center shadow-xl relative overflow-hidden">
                <!-- Background decorative elements (optional, can add subtle shapes) -->
                <div class="absolute top-0 right-0 -m-12 w-64 h-64 bg-white opacity-5 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -m-12 w-48 h-48 bg-white opacity-5 rounded-full"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Level Up Your PDF Game</h2>
                    <p class="text-indigo-100 text-lg mb-8">
                        Get exclusive tips, updates on new features, and PDF productivity hacks delivered to your inbox.
                    </p>

                    <form @submit.prevent="handleSubmit" class="flex flex-col sm:flex-row gap-4 mb-6">
                        <div class="flex-grow">
                            <input v-model="email" type="email" placeholder="Enter your email" required
                                class="w-full px-6 py-4 rounded-xl bg-indigo-500/50 border border-indigo-400 text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white transition-all" />
                        </div>
                        <button type="submit"
                            class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition-colors shadow-lg whitespace-nowrap">
                            Get Update
                        </button>
                    </form>

                    <p class="text-indigo-200 text-sm">
                        No spam. Unsubscribe anytime. Join 10,000+ professionals already subscribed.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import Swal from 'sweetalert2'

const email = ref('')

const handleSubmit = () => {
    if (!email.value) return

    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(email.value)) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Please enter a valid email',
            showConfirmButton: false,
            timer: 3000
        })
        return
    }

    // Success message (Frontend only)
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Subscribed successfully!',
        showConfirmButton: false,
        timer: 3000
    })

    // Clear input
    email.value = ''
}
</script>

<style scoped>
/* Any additional specific styles */
</style>
