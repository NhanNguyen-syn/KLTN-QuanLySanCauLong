import { createApp } from 'vue'
import BookingPage from '../customer/pages/BookingPage'

// Dedicated entry for the booking page only
// This keeps the main site bundle smaller and avoids loading
// booking logic on unrelated pages.
document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('booking-page-app')
  if (root) {
    const app = createApp(BookingPage)
    app.mount(root)
  }
})

