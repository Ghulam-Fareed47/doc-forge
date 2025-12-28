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
import LoginPage from '../views/auth/LoginPage.vue'
import RegisterPage from '../views/auth/RegisterPage.vue'
import AdminDashboardPage from '../views/AdminDashboardPage.vue'
import AdminUsersPage from '../views/admin/AdminUsersPage.vue'
import AdminBlogsPage from '../views/admin/AdminBlogsPage.vue'
import AdminLogsPage from '../views/admin/AdminLogsPage.vue'
import AdminSettingsPage from '../views/admin/AdminSettingsPage.vue'

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
      path: '/privacy',
      name: 'PrivacyPolicy',
      component: () => import('../views/PrivacyPolicyPage.vue')
    },
    {
      path: '/terms',
      name: 'TermsOfService',
      component: () => import('../views/TermsOfServicePage.vue')
    },
    {
      path: '/faq',
      name: 'FAQ',
      component: () => import('../views/FaqPage.vue')
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
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterPage
    },
    // Admin Routes
    {
      path: '/admin',
      name: 'admin',
      component: AdminDashboardPage
    },
    {
      path: '/admin/dashboard',
      name: 'admin-dashboard',
      component: AdminDashboardPage
    },
    {
      path: '/admin/users',
      name: 'admin-users',
      component: AdminUsersPage
    },
    {
      path: '/admin/blogs',
      name: 'admin-blogs',
      component: AdminBlogsPage
    },
    {
      path: '/admin/logs',
      name: 'admin-logs',
      component: AdminLogsPage
    },
    {
      path: '/admin/settings',
      name: 'admin-settings',
      component: AdminSettingsPage
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