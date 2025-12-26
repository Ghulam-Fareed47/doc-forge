import { defineStore } from 'pinia'
import axios from 'axios'

// Set axios defaults for Sanctum
axios.defaults.withCredentials = true
axios.defaults.baseURL = import.meta.env.VITE_API_URL || 'http://localhost:8000'
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Configure axios to read XSRF token from cookie and send as header
axios.defaults.xsrfCookieName = 'XSRF-TOKEN'
axios.defaults.xsrfHeaderName = 'X-XSRF-TOKEN'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
        error: null,
        isInitialized: false
    }),

    getters: {
        isLoggedIn: (state) => !!state.user,
    },

    actions: {
        async initialize() {
            try {
                await this.fetchUser()
            } catch (e) {
                // User not logged in, ignore
            } finally {
                this.isInitialized = true
            }
        },

        async fetchUser() {
            try {
                const response = await axios.get('/api/user')
                this.user = response.data
                return this.user
            } catch (error) {
                this.user = null
                throw error
            }
        },

        async login(credentials) {
            this.loading = true
            this.error = null
            try {
                // CSRF cookie for Sanctum
                await axios.get('/sanctum/csrf-cookie')
                console.log('Cookies visible to JS:', document.cookie)

                // Manually extract XSRF token from cookie
                const xsrfToken = document.cookie
                    .split('; ')
                    .find(row => row.startsWith('XSRF-TOKEN='))
                    ?.split('=')[1]

                if (xsrfToken) {
                    // Decode the URI-encoded token
                    const decodedToken = decodeURIComponent(xsrfToken)
                    axios.defaults.headers.common['X-XSRF-TOKEN'] = decodedToken
                    console.log('XSRF Token set:', decodedToken.substring(0, 50) + '...')
                } else {
                    console.error('XSRF-TOKEN cookie not found!')
                }

                await axios.post('/login', credentials)
                await this.fetchUser()
            } catch (error) {
                console.error('Login Error Details:', error.response?.data)
                this.error = error.response?.data?.message || error.message || 'Login failed'
                throw error
            } finally {
                this.loading = false
            }
        },

        async register(userData) {
            this.loading = true
            this.error = null
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/register', userData)
                await this.fetchUser()
            } catch (error) {
                this.error = error.response?.data?.message || 'Registration failed'
                throw error
            } finally {
                this.loading = false
            }
        },

        async logout() {
            try {
                await axios.post('/logout')
            } finally {
                this.user = null
                this.error = null
            }
        }
    }
})
