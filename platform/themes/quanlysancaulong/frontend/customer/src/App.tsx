import { defineComponent } from 'vue'
import { RouterLink, RouterView } from 'vue-router'

export default defineComponent({
  name: 'App',
  setup() {
    return () => (
      <div>
        <header style={{ padding: '12px 16px', borderBottom: '1px solid #eee' }}>
          <nav style={{ display: 'flex', gap: '12px' }}>
            <RouterLink to="/">Trang chủ</RouterLink>
          </nav>
        </header>
        <main style={{ padding: '16px' }}>
          <RouterView />
        </main>
      </div>
    )
  },
})

