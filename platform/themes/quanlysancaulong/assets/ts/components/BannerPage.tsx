import { defineComponent, computed, PropType, h } from 'vue'

export interface StatItem {
  title?: string
  description?: string
}

export interface BannerProps {
  title?: string
  titleColor?: string
  titleAccentColor?: string
  subtitle?: string
  subtitleColor?: string
  backgroundColor?: string
  btn1Text?: string
  btn1Link?: string
  btn1TextColor?: string
  btn1Bg?: string
  btn2Text?: string
  btn2Link?: string
  btn2TextColor?: string
  btn2BorderColor?: string
  stats?: StatItem[]
}

export default defineComponent({
  name: 'BannerPage',
  props: {
    title: String,
    titleColor: { type: String, default: '#ffffff' },
    titleAccentColor: { type: String, default: '#6fd3c3' },
    subtitle: String,
    subtitleColor: { type: String, default: '#a7f3d0' },
    backgroundColor: { type: String, default: '#0f766e' },
    btn1Text: String,
    btn1Link: { type: String, default: '#' },
    btn1TextColor: { type: String, default: '#0f766e' },
    btn1Bg: { type: String, default: '#ffffff' },
    btn2Text: String,
    btn2Link: { type: String, default: '#' },
    btn2TextColor: { type: String, default: '#ffffff' },
    btn2BorderColor: { type: String, default: '#ffffff' },
    stats: { type: Array as PropType<StatItem[]>, default: () => [] },
  },
  setup(props) {
    const lines = computed(() => {
      const t = (props.title || '').trim()
      if (!t) return [] as string[]
      return t.split(/\r?\n/)
    })

    const centeredBg = computed(
      () =>
        `radial-gradient(1200px 600px at 20% 0%, rgba(255,255,255,0.08), transparent 60%), radial-gradient(900px 500px at 90% 10%, rgba(255,255,255,0.06), transparent 60%), ${props.backgroundColor}`
    )

    return () => (
      <section
        class="banner-page-shortcode"
        style={{
          position: 'relative',
          padding: '90px 0 70px',
          background: centeredBg.value,
          width: '100vw',
          left: '50%',
          right: '50%',
          marginLeft: '-50vw',
          marginRight: '-50vw',
          overflow: 'hidden',
        }}
      >
        <div class="container">
          <div class="text-center mx-auto" style={{ maxWidth: '900px' }}>
            {lines.value.length > 0 && (
              <h1 style={{ fontWeight: 700, lineHeight: 1.2, fontSize: 'clamp(32px, 5vw, 56px)' }}>
                {lines.value.map((line, i) => (
                  <>
                    <span style={{ color: i === 0 ? props.titleColor : props.titleAccentColor }}>{line}</span>
                    {i < lines.value.length - 1 ? <br /> : null}
                  </>
                ))}
              </h1>
            )}

            {props.subtitle && (
              <p class="mt-3" style={{ color: props.subtitleColor, fontSize: '16px' }}>
                {props.subtitle}
              </p>
            )}

            <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
              {props.btn1Text && (
                <a
                  href={props.btn1Link}
                  class="btn px-4 py-2"
                  style={{
                    backgroundColor: props.btn1Bg,
                    color: props.btn1TextColor,
                    border: `1px solid ${props.btn1Bg}`,
                    fontWeight: 600,
                  }}
                >
                  {props.btn1Text}
                </a>
              )}

              {props.btn2Text && (
                <a
                  href={props.btn2Link}
                  class="btn px-4 py-2"
                  style={{
                    backgroundColor: 'transparent',
                    color: props.btn2TextColor,
                    border: `1px solid ${props.btn2BorderColor}`,
                    fontWeight: 600,
                  }}
                >
                  {props.btn2Text}
                </a>
              )}
            </div>
          </div>

          {props.stats && props.stats.length > 0 && (
            <div class="mt-5">
              <div class="row g-4 justify-content-center row-cols-2 row-cols-md-4">
                {props.stats.map((s, idx) => (
                  <div class="col" key={idx}>
                    <div class="text-center">
                      {s.title && (
                        <div style={{ color: '#ffffff', fontWeight: 800, fontSize: '26px' }}>{s.title}</div>
                      )}
                      {s.description && (
                        <div class="mt-1" style={{ color: '#a7f3d0', fontSize: '13px' }}>
                          {s.description}
                        </div>
                      )}
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      </section>
    )
  },
})

