import { defineComponent, PropType } from 'vue'

export interface BannerStatItem {
  title: string
  description?: string
  title_color?: string
  description_color?: string
}

export interface BannerPageProps {
  title?: string
  title_color?: string
  subtitle?: string
  subtitle_color?: string
  background_color?: string
  button_1_text?: string
  button_1_link?: string
  button_1_text_color?: string
  button_1_background_color?: string
  button_2_text?: string
  button_2_link?: string
  button_2_text_color?: string
  button_2_border_color?: string
  stats?: BannerStatItem[]
}

export default defineComponent({
  name: 'BannerPage',
  props: {
    title: String,
    title_color: String,
    subtitle: String,
    subtitle_color: String,
    background_color: String,
    button_1_text: String,
    button_1_link: String,
    button_1_text_color: String,
    button_1_background_color: String,
    button_2_text: String,
    button_2_link: String,
    button_2_text_color: String,
    button_2_border_color: String,
    stats: Array as PropType<BannerPageProps['stats']>,
  },
  setup(props) {
    const bg = props.background_color || '#0f766e'
    const titleColor = props.title_color || '#ffffff'
    const subtitleColor = props.subtitle_color || '#a7f3d0'
    const b1TextColor = props.button_1_text_color || '#0f766e'
    const b1Bg = props.button_1_background_color || '#ffffff'
    const b2TextColor = props.button_2_text_color || '#ffffff'
    const b2Border = props.button_2_border_color || '#ffffff'

    return () => (
      <section
        style={{
          background: bg,
          padding: '80px 16px',
        }}
      >
        <div class="container">
          <div class="row">
            <div class="col-12 text-center">
              {props.title && (
                <h1 style={{ color: titleColor, fontWeight: 800 }}>{props.title}</h1>
              )}
              {props.subtitle && (
                <h2 style={{ color: subtitleColor, marginTop: '8px', fontWeight: 700 }}>{props.subtitle}</h2>
              )}
            </div>
          </div>

          {(props.button_1_text || props.button_2_text) && (
            <div class="row mt-4">
              <div class="col-12 d-flex justify-content-center gap-3 flex-wrap">
                {props.button_1_text && (
                  <a
                    href={props.button_1_link || '#'}
                    class="btn"
                    style={{
                      background: b1Bg,
                      color: b1TextColor,
                      fontWeight: 600,
                      padding: '10px 18px',
                      borderRadius: '8px',
                    }}
                  >
                    {props.button_1_text}
                  </a>
                )}

                {props.button_2_text && (
                  <a
                    href={props.button_2_link || '#'}
                    class="btn"
                    style={{
                      background: 'transparent',
                      color: b2TextColor,
                      border: `2px solid ${b2Border}`,
                      fontWeight: 600,
                      padding: '10px 18px',
                      borderRadius: '8px',
                    }}
                  >
                    {props.button_2_text}
                  </a>
                )}
              </div>
            </div>
          )}

          {!!(props.stats && props.stats.length) && (
            <div class="row mt-5 gy-4">
              {(props.stats || []).slice(0, 4).map((item, idx) => (
                <div class="col-6 col-md-3 text-center" key={idx}>
                  <div>
                    {item.title && (
                      <div style={{ color: item.title_color || '#ffffff', fontWeight: 800, fontSize: '20px' }}>{item.title}</div>
                    )}
                    {item.description && (
                      <div style={{ color: item.description_color || '#a7f3d0', marginTop: '6px' }}>{item.description}</div>
                    )}
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </section>
    )
  },
})

