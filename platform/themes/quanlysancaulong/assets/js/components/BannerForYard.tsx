import { defineComponent } from 'vue';

type Props = {
  title?: string;
  title_color?: string; // from shortcode raw
  titleColor?: string;  // normalized
  description?: string;
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
    const btnUrl = props.buttonUrl || props.button_url || '/';
    const btnBgColor = props.buttonBgColor || props.button_bg_color || '#0d6efd';
    const btnTextColor = props.buttonTextColor || props.button_text_color || '#ffffff';

    return () => (
      <section class="banner-for-yard" style={{ backgroundImage: bg ? `url('${bg}')` : undefined }}>
        <div class="banner-for-yard__overlay" style={{ background: overlay }}></div>
        <div class="banner-for-yard__inner container">
          <div>
            {props.title && (
              <h2 class="banner-for-yard__title" style={{ color: titleColor, fontSize: '48px' }}
                innerHTML={props.title}></h2>
            )}
            {props.description && (
              <p class="banner-for-yard__desc" style={{ color: descColor, fontSize: '20px' }} innerHTML={props.description}></p>
            )}
            {btnText && (
              <div class="banner-for-yard__btn">
                <a href={btnUrl} class="btn" style={{ backgroundColor: btnBgColor, color: btnTextColor }}>
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

