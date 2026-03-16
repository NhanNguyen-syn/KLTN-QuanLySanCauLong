import { defineComponent, PropType } from 'vue';

// Define interfaces for the props
interface Card {
    title: string;
    price: string;
    unit: string;
    tag: string;
    features: string[];
    button_text: string;
    button_url: string;
    card_bg_color: string;
    card_text_color: string;
    tag_bg_color: string;
    tag_text_color: string;
    button_bg_color: string;
    button_text_color: string;
}

export default defineComponent({
    name: 'CourtPricing',
    props: {
        title: { type: String, required: true },
        subtitle: { type: String, required: true },
        cards: { type: Array as PropType<Card[]>, required: true },
        viewAllText: { type: String, required: true },
        viewAllUrl: { type: String, required: true },
        titleColor: { type: String, default: '#000000' },
        subtitleColor: { type: String, default: '#666666' },
        viewAllColor: { type: String, default: '#0E6B5C' },
    },
    setup(props) {
        const handleButtonClick = (e: MouseEvent, url: string, text: string) => {
            if (url && url !== '#') {
                e.preventDefault();
                window.location.href = url;
            }
        };

        return () => (
            <section style={{
                backgroundColor: '#F8F7F4',
                padding: '80px 0',
                textAlign: 'center',
                fontFamily: "'Be Vietnam Pro', sans-serif",
            }}>
                <style>{`
                    .court-pricing-item {
                        position: relative;
                        overflow: hidden;
                        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                                    box-shadow 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                    }
                    .court-pricing-item::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: -100%;
                        width: 100%;
                        height: 100%;
                        background: linear-gradient(
                            120deg,
                            transparent 0%,
                            rgba(14, 107, 92, 0.06) 30%,
                            rgba(14, 107, 92, 0.12) 50%,
                            rgba(14, 107, 92, 0.06) 70%,
                            transparent 100%
                        );
                        transition: left 0.6s ease;
                        z-index: 0;
                        pointer-events: none;
                    }
                    .court-pricing-item:hover {
                        transform: translateY(-8px) scale(1.02);
                        box-shadow: 0 20px 40px rgba(14, 107, 92, 0.15),
                                    0 8px 16px rgba(0, 0, 0, 0.08);
                    }
                    .court-pricing-item:hover::before {
                        left: 100%;
                    }
                    .court-pricing-item .card-header,
                    .court-pricing-item .card-body,
                    .court-pricing-item .card-footer {
                        position: relative;
                        z-index: 1;
                    }
                    .court-view-all-link {
                        position: relative;
                        overflow: hidden;
                        padding: 14px 32px;
                        border-radius: 50px;
                        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                        background: transparent;
                    }
                    .court-view-all-link::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(14, 107, 92, 0.08);
                        border-radius: 50px;
                        transform: scale(0);
                        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                        z-index: 0;
                    }
                    .court-view-all-link::after {
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
                        transition: left 0.6s ease 0.15s;
                        z-index: 1;
                        pointer-events: none;
                    }
                    .court-view-all-link:hover {
                        transform: translateY(-2px);
                        color: #065f46 !important;
                    }
                    .court-view-all-link:hover::before {
                        transform: scale(1);
                    }
                    .court-view-all-link:hover::after {
                        left: 150%;
                    }
                    .court-view-all-link > span {
                        position: relative;
                        z-index: 2;
                    }
                `}</style>
                <div class="container">
                    <h2 style={{
                        fontSize: '2.5rem',
                        fontWeight: 'bold',
                        color: props.titleColor,
                        marginBottom: '1rem',
                    }}>
                        {props.title}
                    </h2>

                    {props.subtitle && (
                        <p style={{
                            fontSize: '1.1rem',
                            color: props.subtitleColor,
                            marginBottom: '3rem',
                        }}>
                            {props.subtitle}
                        </p>
                    )}

                    <div class="cards-wrapper" style={{
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 300px), 1fr))',
                        gap: '2rem',
                        maxWidth: '1200px',
                        margin: '0 auto',
                    }}>
                        {props.cards.map((card, index) => {
                            const headerBg = card.card_bg_color || '#0E6B5C';
                            const headerText = (card.card_text_color && card.card_text_color.trim() !== headerBg.trim()) ? card.card_text_color : '#FFFFFF';
                            const href = card.button_url || '#';
                            return (
                                <div key={index} class="pricing-card court-pricing-item" style={{
                                    backgroundColor: '#fff',
                                    borderRadius: '15px',
                                    overflow: 'hidden',
                                    display: 'flex',
                                    flexDirection: 'column',
                                    textAlign: 'left',
                                }}>
                                    <div class="card-header" style={{
                                        backgroundColor: headerBg,
                                        color: headerText,
                                        padding: '1.5rem 2rem',
                                        position: 'relative',
                                    }}>
                                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1rem' }}>
                                            <h3 style={{ fontSize: '1.2rem', margin: 0, fontWeight: 600 }}>{card.title}</h3>
                                            {card.tag && (
                                                <span class="tag" style={{
                                                    backgroundColor: card.tag_bg_color || 'rgba(255, 255, 255, 0.2)',
                                                    color: card.tag_text_color || '#fff',
                                                    padding: '4px 10px',
                                                    borderRadius: '12px',
                                                    fontSize: '0.75rem',
                                                    fontWeight: 500,
                                                }}>
                                                    {card.tag}
                                                </span>
                                            )}
                                        </div>
                                        <div class="price" style={{ fontSize: '2.8rem', fontWeight: 'bold', lineHeight: 1 }}>
                                            {card.price}
                                            <span style={{ fontSize: '1rem', fontWeight: 'normal', marginLeft: '5px', textTransform: 'lowercase' }}>{card.unit}</span>
                                        </div>
                                    </div>

                                    <div class="card-body" style={{
                                        padding: '2rem',
                                        flexGrow: 1,
                                    }}>
                                        <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                            {card.features.map((feature, fIndex) => (
                                                <li key={fIndex} style={{
                                                    marginBottom: '1rem',
                                                    display: 'flex',
                                                    alignItems: 'center',
                                                    color: '#333',
                                                }}>
                                                    <span style={{
                                                        color: '#0E6B5C',
                                                        marginRight: '10px',
                                                        fontWeight: 'bold',
                                                        fontSize: '1.2rem',
                                                        lineHeight: 1,
                                                    }}>•</span>
                                                    {feature}
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    <div class="card-footer" style={{ padding: '0 2rem 2rem 2rem' }}>
                                        <a href={href}
                                            onClick={(e) => handleButtonClick(e, href, card.button_text)}
                                            style={{
                                                display: 'block',
                                                width: '100%',
                                                padding: '1rem',
                                                backgroundColor: card.button_bg_color || '#0E6B5C',
                                                color: card.button_text_color || '#fff',
                                                textAlign: 'center',
                                                textDecoration: 'none',
                                                borderRadius: '8px',
                                                fontWeight: 'bold',
                                                transition: 'opacity 0.3s',
                                            }}>
                                            {card.button_text}
                                        </a>
                                    </div>
                                </div>
                            )
                        })}
                    </div>

                    {props.viewAllText && props.viewAllUrl && (
                        <a href={props.viewAllUrl} class="court-view-all-link" style={{
                            display: 'inline-block',
                            marginTop: '3rem',
                            color: props.viewAllColor,
                            textDecoration: 'none',
                            fontWeight: 'bold',
                        }}>
                            <span>{props.viewAllText} →</span>
                        </a>
                    )}
                </div>
            </section>
        );
    },
});
