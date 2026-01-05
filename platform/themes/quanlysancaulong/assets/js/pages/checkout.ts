import { createApp } from 'vue'
import CheckoutPage from '../customer/pages/CheckoutPage'

// Mount only on checkout page
document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('checkout-page-app')
  if (root) {
    const app = createApp(CheckoutPage)
    app.mount(root)
  }
})

