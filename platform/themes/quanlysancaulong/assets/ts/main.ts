import { createApp } from 'vue'
import BannerPage from './components/BannerPage'

function mountBannerShortcodes(context: Document | HTMLElement = document) {
  const nodes = context.querySelectorAll<HTMLElement>('.banner-page-shortcode-root:not([data-v-app])')

  nodes.forEach((el) => {
    try {
      const raw = el.getAttribute('data-props') || '{}'
      const props = JSON.parse(raw)
      const app = createApp(BannerPage, props)
      app.mount(el)
    } catch (e) {
      // eslint-disable-next-line no-console
      console.error('BannerPage mount failed:', e)
    }
  })
}

// Initial mount on page load
document.addEventListener('DOMContentLoaded', () => mountBannerShortcodes())

// --- AJAX/Dynamic Content Handling ---

// Use MutationObserver to detect when new nodes are added to the page
const observer = new MutationObserver((mutationsList) => {
  for (const mutation of mutationsList) {
    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
      mutation.addedNodes.forEach((node) => {
        // We only care about element nodes
        if (node.nodeType === Node.ELEMENT_NODE) {
          mountBannerShortcodes(node as HTMLElement)
        }
      })
    }
  }
})

// Start observing the document body for added nodes
observer.observe(document.body, { childList: true, subtree: true })

