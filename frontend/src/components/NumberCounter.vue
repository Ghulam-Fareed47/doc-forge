<template>
  <span ref="counterRef">{{ displayedValue }}</span>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  value: {
    type: [Number, String],
    required: true
  },
  duration: {
    type: Number,
    default: 2000
  },
  delay: {
    type: Number,
    default: 0
  }
})

const counterRef = ref(null)
const currentNumber = ref(0)
let observer = null

// Parse value like "10M+" or "99.9%"
const targetValue = computed(() => {
  if (typeof props.value === 'number') return props.value
  const match = props.value.toString().match(/(\d+\.?\d*)/)
  return match ? parseFloat(match[1]) : 0
})

const suffix = computed(() => {
  if (typeof props.value === 'number') return ''
  const match = props.value.toString().match(/[^\d\.]+/)
  return match ? match[0] : ''
})

const prefix = computed(() => {
  if (typeof props.value === 'number') return ''
  const match = props.value.toString().match(/^[^\d\.]+/)
  return match ? match[0] : ''
})

const displayedValue = computed(() => {
  const formatted = currentNumber.value.toLocaleString(undefined, {
    maximumFractionDigits: targetValue.value % 1 === 0 ? 0 : 1
  })
  return `${prefix.value}${formatted}${suffix.value}`
})

function animate() {
  const start = 0
  const end = targetValue.value
  const duration = props.duration
  let startTime = null

  function step(timestamp) {
    if (!startTime) startTime = timestamp
    const progress = Math.min((timestamp - startTime) / duration, 1)
    
    // Ease out expo
    const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress)
    
    currentNumber.value = start + (end - start) * easeProgress

    if (progress < 1) {
      window.requestAnimationFrame(step)
    } else {
      currentNumber.value = end
    }
  }

  setTimeout(() => {
    window.requestAnimationFrame(step)
  }, props.delay)
}

onMounted(() => {
  observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      animate()
      observer.disconnect()
    }
  }, { threshold: 0.1 })

  if (counterRef.value) {
    observer.observe(counterRef.value)
  }
})

onUnmounted(() => {
  if (observer) observer.disconnect()
})
</script>
