import CheckForUpdates from './components/CheckForUpdates.vue'

// Wait for vueApp to be available
const registerComponent = () => {
    if (typeof vueApp !== 'undefined') {
        vueApp.booting((vue) => {
            vue.component('v-check-for-updates', CheckForUpdates)
        })
    } else {
        // Retry after a short delay if vueApp is not yet available
        setTimeout(registerComponent, 100)
    }
}

// Start registration process when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', registerComponent)
} else {
    registerComponent()
}
