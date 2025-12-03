import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import './assets/main.css'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

app.mount('#app')

// Initialize theme after app mounts
import { useThemeStore } from './stores/theme'
import '@fortawesome/fontawesome-free/css/all.min.css'
const themeStore = useThemeStore()
themeStore.initTheme()