import { createRouter, createWebHistory } from 'vue-router'
import LandingPage from '../views/LandingPage.vue'
import AboutPage from '../views/AboutPage.vue'
import BlogPage from '../views/BlogPage.vue'
import SplitPdfPage from '../views/SplitPdfPage.vue'
import CompressPdfPage from '../views/CompressPdfPage.vue'
import PdfToImagesPage from '../views/PdfToImagesPage.vue'
import ImagesToPdfPage from '../views/ImagesToPdfPage.vue'
import ExtractTextPage from '../views/ExtractTextPage.vue'
import WatermarkPdfPage from '../views/WatermarkPdfPage.vue'

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
      path: '/pdf-to-images',
      name: 'pdf-to-images',
      component: PdfToImagesPage
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
  ]
})

export default router