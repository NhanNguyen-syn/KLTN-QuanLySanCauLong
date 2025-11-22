import { defineComponent, PropType } from 'vue';

type Item = {
  title?: string;
  description?: string;
  time_1?: string;
  time_2?: string;
  bg_color?: string;
  text_color?: string;
  image?: string;
  price_label?: string;
  price_value?: string;
  price_label_color?: string;
  price_value_color?: string;
  button_url?: string;
  button_bg_color?: string;
  button_text_color?: string;
};

type Props = {
  title?: string;
  titleColor?: string;
  description?: string;
  descriptionColor?: string;
  items?: Item[];
  viewAllText?: string;
  viewAllUrl?: string;
  viewAllBg?: string;
  viewAllColor?: string;
};

export default defineComponent<Props>({
  name: 'BookingBadmintonCourt',
  props: {
    title: String,
    titleColor: String,
    description: String,
    descriptionColor: String,
    items: Array as PropType<Item[]>,
    viewAllText: String,
    viewAllUrl: String,
    viewAllBg: String,
    viewAllColor: String,
  },
  setup(props) {
    const wrapStyle = {
      padding: '40px 0',
      background: 'transparent',
    } as any;

    const headingStyle = {
      fontSize: '40px',
      lineHeight: 1.2,
      textAlign: 'center' as const,
      color: props.titleColor || '#0E6B5C',
      margin: '0 0 10px',
      fontWeight: 700,
    };

    const subStyle = {
      fontSize: '16px',
      textAlign: 'center' as const,
      color: props.descriptionColor || '#6c757d',
      margin: '0 0 30px',
    };

    const grid = {
      display: 'grid',
      gridTemplateColumns: 'repeat(4, minmax(0, 1fr))',
      gap: '20px',
    } as any;

    const card = (it: Item) => ({
      background: it.bg_color || '#ffffff',
      color: it.text_color || '#1f2937',
      borderRadius: '16px',
      boxShadow: '0 10px 20px rgba(0,0,0,.06)',
      overflow: 'hidden',
    }) as any;

    const imageBox = (img?: string) => ({
      position: 'relative',
      height: '180px',
      backgroundColor: '#e5e7eb',
      backgroundImage: img ? `url(${img})` : undefined,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    }) as any;

    const timesWrap = {
      position: 'absolute' as const,
      left: '12px',
      bottom: '12px',
      display: 'flex',
      gap: '8px',
    } as any;

    const timePill = (bg = '#f1f5f9', color = '#0b3d2d') => ({
      background: bg,
      color,
      padding: '6px 10px',
      borderRadius: '8px',
      fontSize: '12px',
      fontWeight: 600,
    });

    const body = { padding: '16px' } as any;

    const priceRow = (it: Item) => ({
      display: 'flex',
      alignItems: 'baseline',
      justifyContent: 'space-between',
      paddingTop: '10px',
    }) as any;

    const circleBtn = (it: Item) => ({
      width: '36px',
      height: '36px',
      borderRadius: '50%',
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: it.button_bg_color || '#d1fae5',
      color: it.button_text_color || '#0f766e',
      textDecoration: 'none',
    }) as any;

    const viewAllWrap = { textAlign: 'center', marginTop: '24px' } as any;
    const viewAllBtn = {
      display: 'inline-block',
      borderRadius: '999px',
      padding: '10px 22px',
      background: props.viewAllBg || '#0E6B5C',
      color: props.viewAllColor || '#ffffff',
      textDecoration: 'none',
      fontWeight: 600,
    } as any;

    return () => (
      <section class="booking-badminton-court" style={wrapStyle}>
        {props.title && <h2 style={headingStyle} innerHTML={props.title}></h2>}
        {props.description && (
          <p style={subStyle} innerHTML={props.description}></p>
        )}
        <div class="container">
          <div class="bbc-grid" style={grid}>
            {(props.items || []).slice(0, 8).map((it, idx) => (
              <div class="bbc-card" style={card(it)} key={idx}>
                {/* Image background with time pills */}
                <div style={imageBox(it.image)}>
                  <div style={timesWrap}>
                    {it.time_1 && (
                      <span style={timePill('#f1f5f9', it.text_color || '#0b3d2d')}>{it.time_1}</span>
                    )}
                    {it.time_2 && (
                      <span style={timePill('#f1f5f9', it.text_color || '#0b3d2d')}>{it.time_2}</span>
                    )}
                  </div>
                </div>
                <div style={body}>
                  {it.title && <h3 style={{ margin: '0 0 4px', fontSize: '18px' }}>{it.title}</h3>}
                  {it.description && (
                    <p style={{ margin: 0, opacity: .8, fontSize: '14px' }}>{it.description}</p>
                  )}
                  <div style={priceRow(it)}>
                    <div>
                      {it.price_label && (
                        <div style={{ fontSize: '13px', color: it.price_label_color || 'inherit' }}>{it.price_label}</div>
                      )}
                      {it.price_value && (
                        <div style={{ fontSize: '18px', fontWeight: 800, color: it.price_value_color || 'inherit' }}>{it.price_value}</div>
                      )}
                    </div>
                    <a href={it.button_url || '#'} style={circleBtn(it)} aria-label="Select">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            ))}
          </div>
          {(props.viewAllText || props.viewAllUrl) && (
            <div style={viewAllWrap}>
              <a href={props.viewAllUrl || '#'} class="btn-view-all" style={viewAllBtn}>{props.viewAllText || 'Xem tất cả'}</a>
            </div>
          )}
        </div>
      </section>
    );
  },
});

