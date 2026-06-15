import axios from 'axios'
import { useAuthStore } from '../stores/auth'

const STORAGE_KEY = 'pdf_usage_guest'
const GUEST_LIMIT = 2

export const usageService = {
    /**
     * Checks if the user is allowed to perform an action.
     * Guests are limited to GUEST_LIMIT actions.
     */
    async canUseTool() {
        const authStore = useAuthStore()
        if (authStore.isLoggedIn) return true

        const usage = this.getGuestUsage()
        return usage < GUEST_LIMIT
    },

    /**
     * Logs a tool usage. 
     * Increments local count for guests and sends a log request to the backend.
     */
    async logUsage(toolName, fileSize = null) {
        const authStore = useAuthStore()

        // Increment local counter for guests
        if (!authStore.isLoggedIn) {
            const current = this.getGuestUsage()
            localStorage.setItem(STORAGE_KEY, (current + 1).toString())
        }

        // Attempt to log to backend
        try {
            await axios.post('/api/usage/log', {
                tool_name: toolName,
                file_size: fileSize,
            })
        } catch (e) {
            console.error('Failed to log usage to backend', e)
        }
    },

    getGuestUsage() {
        const val = localStorage.getItem(STORAGE_KEY)
        return val ? parseInt(val) : 0
    },

    getRemainingFreeUses() {
        const used = this.getGuestUsage()
        return Math.max(0, GUEST_LIMIT - used)
    }
}
