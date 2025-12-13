<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-all duration-300">
        <div class="flex flex-col items-center gap-8">
            <!-- Waveform Animation -->
            <div class="flex items-center gap-1 h-12">
                <div class="w-1.5 bg-white rounded-full animate-wave" style="animation-delay: 0s"></div>
                <div class="w-1.5 bg-white rounded-full animate-wave" style="animation-delay: 0.1s"></div>
                <div class="w-1.5 bg-white rounded-full animate-wave" style="animation-delay: 0.2s"></div>
                <div class="w-1.5 bg-white rounded-full animate-wave" style="animation-delay: 0.3s"></div>
                <div class="w-1.5 bg-white rounded-full animate-wave" style="animation-delay: 0.4s"></div>
            </div>

            <!-- Text -->
            <div class="flex flex-col items-center gap-2">
                <h3 class="text-xl font-bold text-white tracking-wider uppercase">Loading</h3>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes wave {

    0%,
    100% {
        height: 12px;
        opacity: 0.5;
    }

    50% {
        height: 48px;
        opacity: 1;
    }
}

.animate-wave {
    animation: wave 1s ease-in-out infinite;
}
</style>

<script setup>
</script>
