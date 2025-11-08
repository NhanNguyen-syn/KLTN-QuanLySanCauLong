import { defineComponent } from 'vue'

export default defineComponent({
  name: 'DashboardPage',
  setup() {
    return () => (
      <section>
        <h1>Admin Dashboard</h1>
        <p>Đây là giao diện admin (Vue 3 + TSX). Bạn có thể dán code admin tại đây.</p>
      </section>
    )
  },
})

