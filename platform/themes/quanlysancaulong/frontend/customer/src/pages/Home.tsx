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
      </div>
    )
  },
})

