import { createRouter, createWebHistory } from 'vue-router'
import LandingPage from '../views/LandingPage.vue'
import AboutPage from '../views/AboutPage.vue'
import ContactPage from '../views/ContactPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: LandingPage
    },
    {
      path: '/about',
      name: 'about',
      component: AboutPage
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactPage
    }
  ]
})

export default router