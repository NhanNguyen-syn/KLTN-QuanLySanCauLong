import { defineComponent } from 'vue';

type Props = {
  title?: string;
  title_color?: string; // from shortcode raw
  titleColor?: string;  // normalized
  description?: string;
  text_align?: string;
  textAlign?: string;
  background_image?: string; // raw id/url
  backgroundImage?: string;  // normalized url
  button_text?: string;
  buttonText?: string;
  button_url?: string;
  buttonUrl?: string;
  button_bg_color?: string;
  buttonBgColor?: string;
  button_text_color?: string;
  buttonTextColor?: string;
  overlay_color?: string;
  overlayColor?: string;
};

export default defineComponent<Props>({
  name: 'BannerForYard',
  props: {
    title: String,
    title_color: String,
    titleColor: String,
    description: String,
    text_align: String,
    textAlign: String,
    background_image: String,
    backgroundImage: String,
    button_text: String,
    buttonText: String,
    button_url: String,
    buttonUrl: String,
    button_bg_color: String,
    buttonBgColor: String,
    button_text_color: String,
    buttonTextColor: String,
    overlay_color: String,
    overlayColor: String,
  },
  setup(props) {
    const bg = props.backgroundImage || props.background_image || '';
    const hasBg = !!bg;
    const overlay = props.overlayColor || props.overlay_color || (hasBg ? 'rgba(0,0,0,.35)' : 'transparent');
    const titleColor = props.titleColor || props.title_color || (hasBg ? '#ffffff' : '#111111');
    const descColor = hasBg ? '#ffffff' : '#444444';
    const btnText = props.buttonText || props.button_text || '';
    const btnUrl = props.buttonUrl || props.button_url || '/dat-san';
    const btnBgColor = props.buttonBgColor || props.button_bg_color || '#065e45';
    const btnTextColor = props.buttonTextColor || props.button_text_color || '#ffffff';
    const rawAlign = (props.textAlign || props.text_align || 'center').toLowerCase();
    const textAlign = rawAlign === 'left' || rawAlign === 'right' || rawAlign === 'center' ? rawAlign : 'center';
    const justifyContent = textAlign === 'left' ? 'flex-start' : textAlign === 'right' ? 'flex-end' : 'center';
    const descMargin =
      textAlign === 'center'
        ? '16px auto 0'
        : textAlign === 'right'
          ? '16px 0 0 auto'
          : '16px auto 0 0';

    const handleCta = (e: MouseEvent) => {
      // Only intercept if it's a default action (like # or no href)
      const target = e.currentTarget as HTMLAnchorElement;
      const href = target.getAttribute('href') || '';

      // If it's a real URL, let it work normally
      if (href && href !== '#' && !href.startsWith('javascript:')) {
        return;
      }

      // Otherwise, prevent default and use the configured URL
      e.preventDefault();
      const bookingUrl = (window as any).BOOKING_URL ||
                        (window as any).App?.bookingUrl ||
                        btnUrl ||
                        'http://kltn-quan-ly-san-cau-long.test/san-gia';
      window.location.assign(bookingUrl);
    };

    return () => (
      <section class="banner-for-yard" style={{ backgroundImage: bg ? `url('${bg}')` : undefined }}>
        <div class="banner-for-yard__overlay" style={{ background: overlay }}></div>
        <div class="banner-for-yard__inner container" style={{ justifyContent }}>
          <div style={{ textAlign, width: '100%' }}>
            {props.title && (
              <h2
                class="banner-for-yard__title"
                style={{ color: titleColor, fontSize: '48px', textAlign }}
                innerHTML={props.title}></h2>
            )}
            {props.description && (
              <p
                class="banner-for-yard__desc"
                style={{ color: descColor, fontSize: '20px', textAlign, margin: descMargin }}
                innerHTML={props.description}></p>
            )}
            {btnText && (
              <div class="banner-for-yard__btn">
                <a href={btnUrl} onClick={handleCta} class="btn" style={{ backgroundColor: btnBgColor, color: btnTextColor }}>
                  {btnText}
                </a>
              </div>
            )}
          </div>
        </div>
      </section>
    );
  },
});
