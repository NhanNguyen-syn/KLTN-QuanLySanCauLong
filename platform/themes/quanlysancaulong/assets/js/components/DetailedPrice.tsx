import { defineComponent, PropType, CSSProperties } from 'vue';

type Plan = {
  id?: number | string;
  title?: string;
  badge?: string | null;
  price?: string | null;
  priceSuffix?: string | null;
  note?: string | null;
  buttonText?: string | null;
  buttonUrl?: string | null;
  isFeatured?: boolean;
  features?: string[];
  // Custom colors per plan
  headerStartColor?: string;
  headerEndColor?: string;
  labelBgColor?: string;
  labelTextColor?: string;
  featuredBgColor?: string;
  featuredText?: string;
};

export default defineComponent({
  name: 'DetailedPrice',
  props: {
    sectionTitle: { type: String, default: 'Bảng Giá Chi Tiết' },
    sectionSubtitle: { type: String, default: 'Lựa chọn gói phù hợp với nhu cầu của bạn' },
    titleColor: { type: String, default: '#0f3d2e' },
    labelColor: { type: String, default: '#0d5e43' },
    plans: { type: Array as PropType<Plan[]>, default: () => [] },
  },
  setup(props) {
    console.log('DetailedPrice props:', props);
    console.log('Plans:', props.plans);

    const wrapper: CSSProperties = { background: '#f5f9f7', padding: '64px 0' };
    const container: CSSProperties = { maxWidth: '1100px', margin: '0 auto', padding: '0 20px' };
    const heading: CSSProperties = { textAlign: 'center', color: props.titleColor, fontSize: '32px', fontWeight: 700, margin: 0 };
    const sub: CSSProperties = { textAlign: 'center', color: '#6b7f74', marginTop: '8px', fontSize: '15px' };
    // CSS classes in _detailed-price.scss lo việc chia cột responsive
    const grid: CSSProperties = { alignItems: 'stretch' };

    const baseCard: CSSProperties = {
      background: '#fff',
      borderRadius: '20px', // bo góc lớn hơn
      overflow: 'hidden',
      boxShadow: '0 12px 34px rgba(0,0,0,.09)',
      border: '1px solid #e5ede9'
    };

    const makeHeader = (p: Plan): CSSProperties => ({
      background: `linear-gradient(135deg, ${p.headerStartColor || '#1fb383'} 0%, ${p.headerEndColor || '#0e8a61'} 100%)`,
      color: '#fff',
      padding: '28px', // tăng padding
      position: 'relative',
      minHeight: '190px',
      display: 'flex',
      flexDirection: 'column',
      justifyContent: 'center',
      alignItems: 'flex-start' // tránh stretch làm badge dài toàn hàng
    });

    const makeFeaturedBadge = (p: Plan): CSSProperties => ({
      position: 'absolute',
      top: '12px',
      right: '12px',
      background: p.featuredBgColor || '#0a2818',
      color: '#fff',
      padding: '6px 12px',
      borderRadius: '999px',
      fontSize: '11px',
      fontWeight: 800,
      textTransform: 'uppercase',
      letterSpacing: '.2px'
    });

    const planTitle: CSSProperties = { fontSize: '24px', fontWeight: 800, margin: 0 };
    const makePlanBadge = (p: Plan): CSSProperties => ({
      display: 'inline-flex',
      alignItems: 'center',
      alignSelf: 'flex-start', // không cho kéo full chiều ngang
      background: p.labelBgColor || '#eaf6f1',
      color: p.labelTextColor || props.labelColor,
      borderRadius: '999px',
      padding: '4px 12px',
      lineHeight: '1',
      fontWeight: 800,
      fontSize: '13px',
      marginTop: '6px',
      whiteSpace: 'nowrap'
    });

    // Hiển thị giá và hậu tố cùng hàng
    const priceWrap: CSSProperties = { marginTop: '16px', display: 'flex', alignItems: 'baseline', gap: '6px' };
    const price: CSSProperties = { fontSize: '52px', fontWeight: 900, lineHeight: 1 };
    const suffix: CSSProperties = { fontSize: '16px', fontWeight: 700, opacity: 0.95, marginLeft: '6px' };
    const note: CSSProperties = { marginTop: '12px', fontSize: '14px', opacity: 0.95, lineHeight: 1.5 };

    const cardBody: CSSProperties = { padding: '26px 28px 28px', background: '#fff' };

    const featureList: CSSProperties = {
      listStyle: 'none',
      padding: 0,
      margin: '12px 0 20px',
      display: 'grid',
      rowGap: '10px'
    };

    const featureItem: CSSProperties = {
      display: 'flex',
      alignItems: 'center',
      gap: '10px',
      color: '#26443a',
      fontSize: '14px',
      lineHeight: '1.8'
    };

    const checkIcon: CSSProperties = { flex: '0 0 22px', display: 'inline-flex' };

    const btnContainer: CSSProperties = { display: 'flex', justifyContent: 'center' };
    const btnSingle: CSSProperties = {
      display: 'inline-flex',
      justifyContent: 'center',
      alignItems: 'center',
      gap: '8px',
      padding: '14px 22px', // nút rộng và thoáng hơn
      borderRadius: '12px',
      border: '1.5px solid #cfe6db', // viền mảnh
      background: '#fff',
      color: '#0b5b40',
      fontWeight: 800,
      textDecoration: 'none',
      fontSize: '15px',
      transition: 'all 0.2s ease',
      cursor: 'pointer',
      width: '100%'
    };

    const handleBtnClick = (e: MouseEvent, text?: string, url?: string | null) => {
      if (url && url !== '#') {
        // If it's a standard link, we can just let the browser handle it,
        // or we can explicitly redirect. We'll explicitly navigate:
        e.preventDefault();
        window.location.href = url;
      }
    };

    return () => (
      <div class="detailed-price-section detailed-price-wrapper" style={wrapper}>
        <style>{`
          .dp-btn {
            position: relative;
            overflow: hidden;
          }
          .dp-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(
              120deg,
              transparent 0%,
              rgba(14, 107, 92, 0.08) 40%,
              rgba(14, 107, 92, 0.15) 50%,
              rgba(14, 107, 92, 0.08) 60%,
              transparent 100%
            );
            transition: left 0.6s ease;
            z-index: 1;
            pointer-events: none;
          }
          .dp-btn:hover {
            background: #0b5b40 !important;
            color: #fff !important;
            border-color: #0b5b40 !important;
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(11, 91, 64, 0.25);
          }
          .dp-btn:hover::before {
            left: 150%;
          }
        `}</style>
        <div class="dp-container" style={container}>
          <h2 class="dp-heading" style={heading}>{props.sectionTitle}</h2>
          <p class="dp-subtitle" style={sub}>{props.sectionSubtitle}</p>
          <div class="dp-grid" style={grid}>
            {props.plans.map((plan, idx) => {
              const href = plan.buttonUrl || '/';
              return (
                <div class="dp-card" style={baseCard} key={idx}>
                  <div class="dp-card-header" style={makeHeader(plan)}>
                    {plan.isFeatured && plan.featuredText && plan.featuredText.trim() !== '' && (
                      <div class="dp-featured-badge" style={makeFeaturedBadge(plan)}>{plan.featuredText}</div>
                    )}
                    <h3 class="dp-plan-title" style={planTitle}>{plan.title}</h3>
                    {plan.badge && plan.badge.trim() !== '' && <div class="dp-plan-badge" style={makePlanBadge(plan)}>{plan.badge}</div>}
                    <div class="dp-price-wrap" style={priceWrap}>
                      <span class="dp-price" style={price}>{plan.price}</span>
                      <span class="dp-suffix" style={suffix}>{plan.priceSuffix}</span>
                    </div>
                    {plan.note && <div class="dp-note" style={note}>{plan.note}</div>}
                  </div>
                  <div class="dp-card-body" style={cardBody}>
                    {plan.features && plan.features.length > 0 && (
                      <ul style={featureList}>
                        {plan.features.map((f, i) => (
                          <li key={i} style={featureItem}>
                            <span style={checkIcon}>
                              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#158a68" stroke-width="2" />
                                <path d="M7 12l3 3 7-7" stroke="#158a68" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </span>
                            <span>{f}</span>
                          </li>
                        ))}
                      </ul>
                    )}
                    <div style={btnContainer}>
                      <a href={href} class="dp-btn" style={btnSingle}
                        onClick={(e) => handleBtnClick(e, plan.buttonText || 'Bắt Đầu Ngay', href)}>
                        {plan.buttonText || 'Bắt Đầu Ngay'}
                      </a>
                    </div>
                  </div>
                </div>
              )
            })}
          </div>
        </div>
      </div>
    );
  },
});
