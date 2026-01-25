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
            const ctaTexts = ['đặt sân', 'dat san', 'bắt đầu ngay', 'bat dau ngay'];
            const buttonText = (text || '').trim().toLowerCase();

            if (ctaTexts.some(t => buttonText.includes(t))) {
                e.preventDefault();
                const bookingUrl = (window as any).BOOKING_URL || (window as any).App?.bookingUrl || 'http://kltn-quan-ly-san-cau-long.test/san-gia';
                window.location.assign(bookingUrl);
            } else if (url) {
                window.location.href = url;
            } else {
                e.preventDefault();
            }
        };

        return () => (
            <section style={{
                backgroundColor: '#F8F7F4',
                padding: '80px 0',
                textAlign: 'center',
                fontFamily: "'Be Vietnam Pro', sans-serif",
            }}>
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
                        gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
                        gap: '2rem',
                        maxWidth: '1200px',
                        margin: '0 auto',
                    }}>
                        {props.cards.map((card, index) => {
                            const headerBg = card.card_bg_color || '#0E6B5C';
                            const headerText = (card.card_text_color && card.card_text_color.trim() !== headerBg.trim()) ? card.card_text_color : '#FFFFFF';
                            const ctaTexts = ['đặt sân', 'dat san', 'đặt sân ngay', 'dat san ngay', 'bắt đầu ngay', 'bat dau ngay'];
                            const isCta = ctaTexts.some(t => (card.button_text || '').toLowerCase().includes(t));
                            const href = isCta ? '/san-gia' : (card.button_url || '#');
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
                        <a href={props.viewAllUrl} style={{
                            display: 'inline-block',
                            marginTop: '3rem',
                            color: props.viewAllColor,
                            textDecoration: 'none',
                            fontWeight: 'bold',
                        }}>
                            {props.viewAllText} →
                        </a>
                    )}
                </div>
            </section>
        );
    },
});
