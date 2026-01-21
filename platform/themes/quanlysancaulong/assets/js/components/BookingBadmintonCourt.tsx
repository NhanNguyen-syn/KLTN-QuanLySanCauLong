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
    // Thiết kế lại theo layout trong folder d (giống /san-va-gia):
    // - card bo góc lớn, shadow nhẹ, hover shadow mạnh
    // - ảnh dạng cover + overlay gradient
    // - nút tròn mũi tên ở góc phải dưới
    // - responsive: 1/2/4 cột

    const wrapStyle = {
      padding: '64px 0',
      background: 'transparent',
    } as any;

    const headingStyle = {
      fontSize: '40px',
      lineHeight: 1.2,
      textAlign: 'center' as const,
      color: props.titleColor || '#0E6B5C',
      margin: '0 0 10px',
      fontWeight: 800,
    };

    const subStyle = {
      fontSize: '16px',
      textAlign: 'center' as const,
      color: props.descriptionColor || '#6b7280',
      margin: '0 auto 36px',
      maxWidth: '860px',
    } as any;

    const grid = {
      display: 'grid',
      gridTemplateColumns: 'repeat(1, minmax(0, 1fr))',
      gap: '24px',
    } as any;

    const card = () => ({
      background: '#ffffff',
      borderRadius: '16px',
      overflow: 'hidden',
      border: '1px solid rgba(15, 23, 42, 0.08)',
      boxShadow: '0 1px 2px rgba(0,0,0,.05)',
      transition: 'box-shadow .25s ease, transform .25s ease, border-color .25s ease',
    }) as any;

    const imageBox = (img?: string) => ({
      position: 'relative',
      height: '240px',
      overflow: 'hidden',
      backgroundColor: '#e5e7eb',
    }) as any;

    const imageLayer = (img?: string) => ({
      position: 'absolute',
      inset: 0,
      backgroundImage: img ? `url(${img})` : undefined,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      transform: 'scale(1)',
      transition: 'transform .7s ease',
    }) as any;

    const overlay = {
      position: 'absolute' as const,
      inset: 0,
      background: 'linear-gradient(to top, rgba(0,0,0,.55), rgba(0,0,0,0))',
      opacity: 0.65,
    } as any;

    const timesWrap = {
      position: 'absolute' as const,
      left: '16px',
      bottom: '16px',
      display: 'flex',
      flexWrap: 'wrap',
      gap: '8px',
      zIndex: 2,
    } as any;

    const timePill = () => ({
      background: 'rgba(255,255,255,.9)',
      color: '#111827',
      padding: '6px 10px',
      borderRadius: '10px',
      fontSize: '12px',
      fontWeight: 800,
      boxShadow: '0 1px 2px rgba(0,0,0,.08)',
      backdropFilter: 'blur(6px)',
    });

    const body = { padding: '18px 18px 16px' } as any;

    const titleStyle = {
      margin: '0 0 6px',
      fontSize: '20px',
      fontWeight: 800,
      color: '#111827',
      transition: 'color .2s ease',
    } as any;

    const descStyle = {
      margin: 0,
      opacity: 0.8,
      fontSize: '14px',
      color: '#6b7280',
      minHeight: '40px', // Đảm bảo chiều cao tối thiểu dù không có text
      display: '-webkit-box',
      WebkitLineClamp: 2,
      WebkitBoxOrient: 'vertical' as const,
      overflow: 'hidden',
    } as any;

    const bottomRow = {
      marginTop: '14px',
      paddingTop: '14px',
      borderTop: '1px solid rgba(15, 23, 42, 0.08)',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: '12px',
    } as any;

    const priceLabelStyle = (it: Item) => ({
      fontSize: '12px',
      fontWeight: 600,
      color: it.price_label_color || '#6b7280',
      marginBottom: '2px',
    });

    const priceValueStyle = (it: Item) => ({
      fontSize: '18px',
      fontWeight: 900,
      color: it.price_value_color || '#111827',
      lineHeight: 1.1,
    });

    const circleBtn = (it: Item) => ({
      width: '40px',
      height: '40px',
      borderRadius: '999px',
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: it.button_bg_color || 'rgba(5, 150, 105, 0.1)',
      color: it.button_text_color || '#059669',
      textDecoration: 'none',
      transition: 'all .25s ease',
    }) as any;

    const viewAllWrap = { textAlign: 'center', marginTop: '28px' } as any;
    const viewAllBtn = {
      display: 'inline-block',
      borderRadius: '12px',
      padding: '12px 26px',
      background: props.viewAllBg || '#065f46',
      color: props.viewAllColor || '#ffffff',
      textDecoration: 'none',
      fontWeight: 800,
      boxShadow: '0 12px 24px rgba(6, 95, 70, 0.18)',
    } as any;

    return () => (
      <section class="booking-badminton-court" style={wrapStyle}>
        {props.title && <h2 style={headingStyle} innerHTML={props.title}></h2>}
        {props.description && <p style={subStyle} innerHTML={props.description}></p>}

        {/* Responsive grid via CSS media query (inline) để không phụ thuộc tailwind */}
        <style>
          {`
            .bbc-grid { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 24px; }
            @media (min-width: 768px) { .bbc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
            @media (min-width: 1200px) { .bbc-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }

            .bbc-card:hover { box-shadow: 0 16px 30px rgba(0,0,0,.12); transform: translateY(-2px); border-color: rgba(5, 150, 105, 0.35); }
            .bbc-card:hover .bbc-image { transform: scale(1.1); }
            .bbc-card:hover .bbc-title { color: #059669; }
            .bbc-card:hover .bbc-circle { background: #059669 !important; color: #ffffff !important; }
          `}
        </style>

        <div class="container">
          <div class="bbc-grid">
            {(props.items || []).slice(0, 8).map((it, idx) => (
              <div class="bbc-card" style={card()} key={idx}>
                <div style={imageBox(it.image)}>
                  <div class="bbc-image" style={imageLayer(it.image)} />
                  <div style={overlay} />

                  <div style={timesWrap}>
                    {it.time_1 && <span style={timePill()}>{it.time_1}</span>}
                    {it.time_2 && <span style={timePill()}>{it.time_2}</span>}
                  </div>
                </div>

                <div style={body}>
                  {it.title && (
                    <h3 class="bbc-title" style={titleStyle}>
                      {it.title}
                    </h3>
                  )}
                  {it.description && <p style={descStyle}>{it.description}</p>}

                  <div style={bottomRow}>
                    <div style={{ minWidth: 0 }}>
                      {it.price_label && <div style={priceLabelStyle(it)}>{it.price_label}</div>}
                      {it.price_value && <div style={priceValueStyle(it)}>{it.price_value}</div>}
                    </div>

                    <a href={it.button_url || '#'} class="bbc-circle" style={circleBtn(it)} aria-label="Select">
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
              <a href={props.viewAllUrl || '#'} class="btn-view-all" style={viewAllBtn}>
                {props.viewAllText || 'Xem tất cả'}
              </a>
            </div>
          )}
        </div>
      </section>
    );
  },
});

