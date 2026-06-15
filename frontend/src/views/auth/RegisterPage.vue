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
              <i class="fas fa-user-plus text-2xl text-white"></i>
            </div>
          </div>
          <h1 class="text-3xl font-bold text-center text-white mb-2">Create Account</h1>
          <p class="text-center text-primary-100 text-sm">Join us to get started</p>
        </div>

        <!-- Form section -->
        <div class="px-8 py-10">
          <form class="space-y-5" @submit.prevent="handleRegister">
            <!-- Full Name input -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                Full Name
              </label>
              <div class="relative">
                <div class="absolute left-3 top-3.5 text-gray-400 dark:text-slate-500">
                  <i class="fas fa-user text-lg"></i>
                </div>
                <input 
                  id="name" 
                  name="name" 
                  type="text" 
                  required 
                  v-model="form.name"
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white dark:placeholder-slate-400 transition-all"
                  placeholder="John Doe" 
                />
              </div>
            </div>

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
                  id="password" 
                  name="password" 
                  :type="showPassword ? 'text' : 'password'" 
                  autocomplete="new-password" 
                  required
                  v-model="form.password"
                  class="w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white dark:placeholder-slate-400 transition-all"
                  placeholder="Create a strong password" 
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

            <!-- Confirm Password input -->
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                Confirm Password
              </label>
              <div class="relative">
                <div class="absolute left-3 top-3.5 text-gray-400 dark:text-slate-500">
                  <i class="fas fa-lock text-lg"></i>
                </div>
                <input 
                  id="password_confirmation" 
                  name="password_confirmation" 
                  :type="showConfirmPassword ? 'text' : 'password'"
                  autocomplete="new-password" 
                  required 
                  v-model="form.password_confirmation"
                  class="w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-slate-700 dark:text-white dark:placeholder-slate-400 transition-all"
                  placeholder="Confirm your password" 
                />
                <button
                  type="button"
                  @click="showConfirmPassword = !showConfirmPassword"
                  class="absolute right-3 top-3.5 text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 transition-colors"
                >
                  <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
              </div>
            </div>

            <!-- Password strength indicator -->
            <div v-if="form.password" class="flex items-center gap-2">
              <div class="flex-1 h-1.5 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                <div 
                  :class="[
                    'h-full rounded-full transition-all duration-300',
                    passwordStrength === 'weak' ? 'w-1/3 bg-red-500' :
                    passwordStrength === 'medium' ? 'w-2/3 bg-yellow-500' :
                    'w-full bg-green-500'
                  ]"
                ></div>
              </div>
              <span :class="[
                'text-xs font-medium',
                passwordStrength === 'weak' ? 'text-red-600 dark:text-red-400' :
                passwordStrength === 'medium' ? 'text-yellow-600 dark:text-yellow-400' :
                'text-green-600 dark:text-green-400'
              ]">
                {{ passwordStrength }}
              </span>
            </div>

            <!-- Error message -->
            <div v-if="authStore.error"
              class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-300 p-4 rounded-lg text-sm flex items-start gap-3">
              <i class="fas fa-circle-exclamation text-lg mt-0.5 flex-shrink-0"></i>
              <span>{{ authStore.error }}</span>
            </div>

            <!-- Terms checkbox -->
            <label class="flex items-start gap-3 cursor-pointer">
              <input type="checkbox" required class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-primary-600 focus:ring-primary-500 dark:bg-slate-700 mt-1" />
              <span class="text-sm text-gray-600 dark:text-slate-400">
                I agree to the
                <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium">Terms of Service</a>
                and
                <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium">Privacy Policy</a>
              </span>
            </label>

            <!-- Register button -->
            <button 
              type="submit" 
              :disabled="authStore.loading"
              class="w-full py-3 px-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-lg flex items-center justify-center gap-2">
              <span v-if="authStore.loading">
                <i class="fas fa-spinner fa-spin"></i> Creating account...
              </span>
              <span v-else>Create Account</span>
            </button>
          </form>

          <!-- Divider -->
          <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300 dark:border-slate-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-400">already have an account?</span>
            </div>
          </div>

          <!-- Footer -->
          <div class="text-center">
            <p class="text-gray-600 dark:text-slate-400 text-sm">
              <router-link to="/login" class="font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                Sign in here
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
import { reactive, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const authStore = useAuthStore()
const showPassword = ref(false)
const showConfirmPassword = ref(false)

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

// Calculate password strength
const passwordStrength = computed(() => {
  const pwd = form.password
  if (!pwd) return ''
  
  let strength = 0
  if (pwd.length >= 8) strength++
  if (pwd.match(/[a-z]/) && pwd.match(/[A-Z]/)) strength++
  if (pwd.match(/[0-9]/)) strength++
  if (pwd.match(/[^a-zA-Z0-9]/)) strength++
  
  if (strength <= 1) return 'weak'
  if (strength <= 2) return 'medium'
  return 'strong'
})

async function handleRegister() {
  try {
    await authStore.register(form)
    router.push('/')
  } catch (e) {
    // Error handled by store
  }
}
</script>
