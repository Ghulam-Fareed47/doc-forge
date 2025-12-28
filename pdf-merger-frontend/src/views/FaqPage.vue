<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <NavigationBar />

        <div class="pt-32 pb-24 px-4">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">Frequently Asked Questions
                </h1>

                <div class="space-y-4">
                    <div v-for="(faq, index) in faqs" :key="index"
                        class="border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm">
                        <button @click="toggleFaq(index)"
                            class="w-full flex justify-between items-center p-6 text-left hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ faq.question }}</span>
                            <i :class="['fas', faq.isOpen ? 'fa-minus' : 'fa-plus', 'text-indigo-500 text-sm']"></i>
                        </button>
                        <div v-show="faq.isOpen"
                            class="p-6 pt-0 text-gray-600 dark:text-gray-400 border-t border-gray-50 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50 leading-relaxed text-sm">
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <FooterSection />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'

const faqs = ref([
    {
        question: 'Is DocForge really free?',
        answer: 'Yes, all our basic PDF tools are 100% free to use with no hidden costs or subscriptions required. We believe in providing accessible document tools for everyone.',
        isOpen: true
    },
    {
        question: 'Are my files safe?',
        answer: 'Absolutely. We process all files locally in your browser. This means your documents never leave your computer, providing the highest level of security and privacy.',
        isOpen: false
    },
    {
        question: 'Do I need to install anything?',
        answer: 'No installation is needed. DocForge works entirely within your web browser on desktop, tablet, and mobile devices.',
        isOpen: false
    },
    {
        question: 'What file formats do you support?',
        answer: 'We currently specialize in PDF processing (merge, split, compress, watermark) and image-to-PDF conversions. We support common image formats like JPG and PNG.',
        isOpen: false
    }
])

function toggleFaq(index) {
    faqs.value[index].isOpen = !faqs.value[index].isOpen
}
</script>
