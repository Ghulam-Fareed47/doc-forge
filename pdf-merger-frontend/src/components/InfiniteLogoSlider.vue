<template>
  <div class="logo-slider w-full overflow-hidden bg-white/50 dark:bg-slate-800/50 py-10 backdrop-blur-sm border-y border-gray-100 dark:border-gray-800">
    <div class="container mx-auto px-4 mb-6">
      <p class="text-center text-sm font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
        Trusted by 10,000+ Teams Worldwide
      </p>
    </div>
    
    <div class="relative flex overflow-hidden group">
      <div class="flex animate-marquee whitespace-nowrap group-hover:pause-animation">
        <div v-for="(logo, index) in logos" :key="index" class="mx-8 flex items-center justify-center grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100">
          <i :class="[logo.icon, 'text-4xl text-gray-600 dark:text-gray-400']"></i>
          <span class="ml-2 text-xl font-bold text-gray-700 dark:text-gray-300">{{ logo.name }}</span>
        </div>
      </div>
      
      <!-- Duplicate for infinite effect -->
      <div class="flex absolute top-0 animate-marquee2 whitespace-nowrap group-hover:pause-animation">
        <div v-for="(logo, index) in logos" :key="'dup-' + index" class="mx-8 flex items-center justify-center grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100">
          <i :class="[logo.icon, 'text-4xl text-gray-600 dark:text-gray-400']"></i>
          <span class="ml-2 text-xl font-bold text-gray-700 dark:text-gray-300">{{ logo.name }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const logos = [
  { name: 'Paperless', icon: 'fas fa-leaf' },
  { name: 'CloudDrive', icon: 'fas fa-cloud' },
  { name: 'SecureDocs', icon: 'fas fa-shield-alt' },
  { name: 'FastSign', icon: 'fas fa-pen-nib' },
  { name: 'WorkFlow', icon: 'fas fa-project-diagram' },
  { name: 'ArchiveIt', icon: 'fas fa-archive' },
  { name: 'TeamSync', icon: 'fas fa-users' },
  { name: 'DataNest', icon: 'fas fa-database' }
]
</script>

<style scoped>
.animate-marquee {
  animation: marquee 30s linear infinite;
}

.animate-marquee2 {
  animation: marquee2 30s linear infinite;
}

@keyframes marquee {
  0% { transform: translateX(0%); }
  100% { transform: translateX(-100%); }
}

@keyframes marquee2 {
  0% { transform: translateX(100%); }
  100% { transform: translateX(0%); }
}

.pause-animation {
  animation-play-state: paused;
}
</style>
