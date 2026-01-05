import { createApp } from 'vue'
import PersonalInfoPage from '../customer/pages/PersonalInfoPage'

// Only mount on the personal info page
document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('personal-info-page-app')
  if (root) {
    const title = root.getAttribute('data-title') || 'Thông Tin Cá Nhân'
    const subtitle = root.getAttribute('data-subtitle') || 'Vui lòng cung cấp thông tin liên hệ để hoàn tất đặt sân'
    const app = createApp(PersonalInfoPage, { title, subtitle })
    app.mount(root)
  }
})

