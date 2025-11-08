import { defineComponent } from 'vue'

const Feature = (props: { icon?: string; title: string; description: string }) => (
  <div style={{ textAlign: 'center' }}>
    <div style={{ marginBottom: '12px', fontSize: '32px' }}>{props.icon ?? '⭐'}</div>
    <h3 style={{ margin: '8px 0' }}>{props.title}</h3>
    <p style={{ color: '#555' }}>{props.description}</p>
  </div>
)

export default defineComponent({
  name: 'HomePage',
  setup() {
    // TODO: Replace with API call to backend to fetch theme options
    const siteTitle = 'QuanLySanCauLong NienThieu'
    const homepageTitle = `Welcome to ${siteTitle}`
    const homepageDescription = 'Start building your amazing website with Vue 3 + TSX.'

    return () => (
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h1>{homepageTitle}</h1>
            <p class="lead">{homepageDescription}</p>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-4 mb-4">
            <Feature icon="🚀" title="Fast Performance" description="Built for speed and optimized for performance." />
          </div>
          <div class="col-md-4 mb-4">
            <Feature icon="🛡️" title="Secure" description="Enterprise-grade security features built-in." />
          </div>
          <div class="col-md-4 mb-4">
            <Feature icon="⚙️" title="Customizable" description="Fully customizable to match your needs." />
          </div>
        </div>

        <div class="row">
          <RecentPosts />
        </div>
      </div>
    )
  },
})

const RecentPosts = defineComponent({
  name: 'RecentPosts',
  setup() {
    // TODO: Fetch recent posts from backend API
    const posts = [
      { id: 1, title: 'Bài viết 1', excerpt: 'Mô tả ngắn...' },
      { id: 2, title: 'Bài viết 2', excerpt: 'Mô tả ngắn...' },
      { id: 3, title: 'Bài viết 3', excerpt: 'Mô tả ngắn...' },
    ]

    return () => (
      <section>
        <h2 style={{ margin: '16px 0' }}>Bài viết mới</h2>
        <div style={{ display: 'grid', gap: '12px', gridTemplateColumns: 'repeat(auto-fill, minmax(220px, 1fr))' }}>
          {posts.map((p) => (
            <article key={p.id} style={{ border: '1px solid #eee', borderRadius: 8, padding: 12 }}>
              <h3 style={{ margin: '8px 0' }}>{p.title}</h3>
              <p style={{ color: '#666' }}>{p.excerpt}</p>
            </article>
          ))}
        </div>
      </section>
    )
  },
})

