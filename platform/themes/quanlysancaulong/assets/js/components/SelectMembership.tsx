import { defineComponent, PropType } from 'vue';

type Card = {
  price?: string;
  price_color?: string;
  title?: string;
  title_color?: string;
  subtitle?: string;
  subtitle_color?: string;
  features?: string;
  features_color?: string;
  button_text?: string;
  button_url?: string;
  button_bg_color?: string;
  button_text_color?: string;
  card_bg_color?: string;
  card_border_color?: string;
  is_featured?: boolean;
  featured_badge_text?: string;
  featured_badge_bg?: string;
  featured_badge_color?: string;
  discount_badge_text?: string;
  discount_badge_bg?: string;
  discount_badge_color?: string;
};

type Props = {
  title?: string;
  subtitle?: string;
  titleColor?: string;
  subtitleColor?: string;
  cards?: Card[];
};

export default defineComponent<Props>({
  name: 'SelectMembership',
  props: {
    title: String,
    subtitle: String,
    titleColor: String,
    subtitleColor: String,
    cards: Array as PropType<Card[]>,
  },
  setup(props) {
    const defaultFeaturedColor = '#0E6B5C';
    const defaultCardColor = '#FFFFFF';

    const renderCheckIcon = () => (
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style={{ marginRight: '8px', color: defaultFeaturedColor, flexShrink: 0 }}>
        <path d="M17.33 8.66998L10.5 15.5L7.66998 12.67" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    );

    const renderArrowIcon = () => (
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style={{ marginLeft: '8px' }}>
        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    );

    const handleCta = (e: MouseEvent, text?: string | null, url?: string | null) => {
      if (url && url !== '#') {
        e.preventDefault();
        window.location.href = url;
      }
    };

    return () => (
      <section class="select-membership">
        <div class="container">
          {props.title && <h2 class="sm-title" style={{ color: props.titleColor }}>{props.title}</h2>}
          {props.subtitle && <p class="sm-subtitle" style={{ color: props.subtitleColor }}>{props.subtitle}</p>}

          <div class="sm-grid">
            {(props.cards || []).map((card, index) => (
              <div
                class={['sm-card', { 'is-featured': card.is_featured }]}
                style={{
                  backgroundColor: card.card_bg_color || (card.is_featured ? defaultFeaturedColor : defaultCardColor),
                  borderColor: card.card_border_color || 'transparent',
                }}
                key={index}
              >
                {card.is_featured && card.featured_badge_text && (
                  <div class="featured-badge" style={{ backgroundColor: card.featured_badge_bg, color: card.featured_badge_color }}>
                    {card.featured_badge_text}
                  </div>
                )}

                <div class="sm-card-header">
                  <div class="price" style={{ color: card.price_color || (card.is_featured ? '#fff' : '#000') }}>{card.price}</div>
                  <h3 class="title" style={{ color: card.title_color || (card.is_featured ? '#fff' : defaultFeaturedColor) }}>{card.title}</h3>
                  <p class="subtitle" style={{ color: card.subtitle_color || (card.is_featured ? 'rgba(255,255,255,0.8)' : '#6c757d') }}>{card.subtitle}</p>
                </div>

                {card.discount_badge_text && (
                  <div class="discount-badge-wrap">
                    <span class="discount-badge" style={{ backgroundColor: card.discount_badge_bg, color: card.discount_badge_color }}>
                      {card.discount_badge_text}
                    </span>
                  </div>
                )}

                <ul class="features-list" style={{ color: card.features_color || (card.is_featured ? 'rgba(255,255,255,0.95)' : '#333') }}>
                  {(card.features || '').split('\n').map((feature, i) => feature.trim() && (
                    <li key={i}>{renderCheckIcon()}<span>{feature.trim()}</span></li>
                  ))}
                </ul>

                <div class="sm-card-footer">
                  <a
                    href={card.button_url || '#'}
                    class="sm-button"
                    onClick={(e) => handleCta(e, card.button_text, card.button_url)}
                    style={{
                      backgroundColor: card.button_bg_color,
                      color: card.button_text_color,
                    }}
                  >
                    <span>{card.button_text}</span>
                    {renderArrowIcon()}
                  </a>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  },
});

