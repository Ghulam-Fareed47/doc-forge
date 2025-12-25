import { createRouter, createWebHistory } from 'vue-router'
import LandingPage from '../views/LandingPage.vue'
import MergePdfPage from '../views/MergePdfPage.vue'
import AboutPage from '../views/AboutPage.vue'
import BlogPage from '../views/BlogPage.vue'
import SplitPdfPage from '../views/SplitPdfPage.vue'
import CompressPdfPage from '../views/CompressPdfPage.vue'
import ImagesToPdfPage from '../views/ImagesToPdfPage.vue'
import ExtractTextPage from '../views/ExtractTextPage.vue'
import WatermarkPdfPage from '../views/WatermarkPdfPage.vue'

import { useLoader } from '../composables/useLoader'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: LandingPage
    },
    {
      path: '/merge-pdf',
      name: 'merge-pdf',
      component: MergePdfPage
    },
    {
      path: '/about',
      name: 'about',
      component: AboutPage
    },
    {
      path: '/blog',
      name: 'blog',
      component: BlogPage
    },
    {
      path: '/split-pdf',
      name: 'split-pdf',
      component: SplitPdfPage
    },
    {
      path: '/compress-pdf',
      name: 'compress-pdf',
      component: CompressPdfPage
    },
    {
      path: '/images-to-pdf',
      name: 'images-to-pdf',
      component: ImagesToPdfPage
    },
    {
      path: '/extract-text',
      name: 'extract-text',
      component: ExtractTextPage
    },
    {
      path: '/watermark-pdf',
      name: 'watermark-pdf',
      component: WatermarkPdfPage
    }
  ],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

router.beforeEach((to, from, next) => {
  const { showLoader } = useLoader()
  showLoader()
  next()
})

router.afterEach(() => {
  const { hideLoader } = useLoader()
  setTimeout(() => {
    hideLoader()
  }, 1000)
})

export default router