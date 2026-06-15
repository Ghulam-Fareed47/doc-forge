<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 px-4 py-12">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-primary-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
      <!-- Card container -->
      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
        <!-- Header section with gradient -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 pt-12 pb-8">
          <div class="flex justify-center mb-4">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
              <i class="fas fa-lock-open text-2xl text-white"></i>
            </div>
          </div>
          <h1 class="text-3xl font-bold text-center text-white mb-2">Welcome Back</h1>
          <p class="text-center text-primary-100 text-sm">Sign in to your account to continue</p>
        </div>

        <!-- Form section -->
        <div class="px-8 py-10">
          <form class="space-y-5" @submit.prevent="handleLogin">
            <!-- Email input -->
            <div>
              <label for="email-address" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                Email Address
              </label>
              <div class="relative">
                <div class="absolute left-3 top-3.5 text-gray-400 dark:text-slate-500">
                  <i class="fas fa-envelope text-lg"></i>
                </div>
                <input 
                  id="email-address" 
                  name="email" 
                  type="email" 
                  autocomplete="email" 
                  required 
                  v-model="form.email"
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white dark:placeholder-slate-400 transition-all"
                  placeholder="you@example.com" 
                />
              </div>
            </div>

            <!-- Password input -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                Password
              </label>
              <div class="relative">
                <div class="absolute left-3 top-3.5 text-gray-400 dark:text-slate-500">
                  <i class="fas fa-lock text-lg"></i>
                </div>
                <input 
                  :id="'password'" 
                  name="password" 
                  :type="showPassword ? 'text' : 'password'" 
                  autocomplete="current-password" 
                  required
                  v-model="form.password"
                  class="w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white dark:placeholder-slate-400 transition-all"
                  placeholder="Enter your password" 
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute right-3 top-3.5 text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 transition-colors"
                >
                  <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
              </div>
            </div>

            <!-- Error message -->
            <div v-if="authStore.error"
              class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-300 p-4 rounded-lg text-sm flex items-start gap-3">
              <i class="fas fa-circle-exclamation text-lg mt-0.5 flex-shrink-0"></i>
              <span>{{ authStore.error }}</span>
            </div>

            <!-- Remember me checkbox -->
            <div class="flex items-center justify-between">
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-primary-600 focus:ring-primary-500 dark:bg-slate-700" />
                <span class="text-sm text-gray-600 dark:text-slate-400">Remember me</span>
              </label>
              <a href="#" class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium transition-colors">
                Forgot password?
              </a>
            </div>

            <!-- Sign in button -->
            <button 
              type="submit" 
              :disabled="authStore.loading"
              class="w-full py-3 px-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-lg flex items-center justify-center gap-2">
              <span v-if="authStore.loading">
                <i class="fas fa-spinner fa-spin"></i> Signing in...
              </span>
              <span v-else>Sign in</span>
            </button>
          </form>

          <!-- Divider -->
          <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300 dark:border-slate-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400">or continue as</span>
            </div>
          </div>

          <!-- Footer -->
          <div class="text-center">
            <p class="text-gray-600 dark:text-slate-400 text-sm">
              Don't have an account?
              <router-link to="/register" class="font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                Create one now
              </router-link>
            </p>
          </div>
        </div>
      </div>

      <!-- Security info -->
      <div class="mt-6 text-center text-sm text-slate-400">
        <i class="fas fa-shield-alt mr-2"></i>
        <span>Your data is secure and encrypted</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const authStore = useAuthStore()
const showPassword = ref(false)

const form = reactive({
  email: '',
  password: ''
})

async function handleLogin() {
  try {
    await authStore.login(form)
    router.push('/')
  } catch (e) {
    // Error handled by store
  }
}
</script>
