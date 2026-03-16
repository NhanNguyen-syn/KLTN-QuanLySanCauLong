import { defineComponent, CSSProperties, ref, onMounted } from 'vue';

export default defineComponent({
    name: 'BannerPage',
    props: {
        title: { type: String, required: false, default: 'Train Hard. Play Smart.\nRise Together.' },
        description: { type: String, required: false, default: 'A badminton club for those who want to grow — on and off the court.' },
        backgroundImage: { type: String, required: false, default: null },
        buttonText: { type: String, required: false, default: 'Become a Member' },
        buttonUrl: { type: String, required: false, default: '#' },
        satisfiedText: { type: String, required: false, default: 'Satisfied by 1k Users' },
    },
    setup(props) {
        const isVisible = ref(false);

        onMounted(() => {
            // Small delay to ensure the DOM is ready and initial styles are applied
            requestAnimationFrame(() => {
                isVisible.value = true;
            });
        });

        const sectionStyle: CSSProperties = {
            position: 'relative',
            minHeight: '50vh',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            backgroundRepeat: 'no-repeat',
            display: 'flex',
            alignItems: 'center',
            backgroundColor: '#222',
            padding: '4rem 5%',
            boxSizing: 'border-box',
            overflow: 'hidden',
        };

        const overlayStyle: CSSProperties = {
            position: 'absolute',
            inset: 0,
            background: 'linear-gradient(90deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,0) 70%)',
            pointerEvents: 'none',
            zIndex: 1,
        };

        if (props.backgroundImage) {
            sectionStyle.backgroundImage = `url(${props.backgroundImage})`;
        }

        const contentStyle: CSSProperties = {
            position: 'relative',
            zIndex: 2,
            color: '#fff',
            width: '100%',
            height: '100%',
        };

        const titleStyle: CSSProperties = {
            fontSize: 'clamp(2.8rem, 5.5vw, 4.2rem)',
            fontWeight: '700',
            lineHeight: '1.2',
            letterSpacing: '-0.02em',
            marginBottom: '2.5rem',
            maxWidth: '600px',
        };

        const descriptionStyle: CSSProperties = {
            fontSize: 'clamp(0.95rem, 1.6vw, 1.15rem)',
            lineHeight: '1.8',
            maxWidth: '420px',
            opacity: 0.92,
        };

        const buttonStyle: CSSProperties = {
            display: 'inline-flex',
            alignItems: 'center',
            gap: '0.75rem',
            padding: '1.1rem 2.2rem',
            fontSize: '1rem',
            fontWeight: '600',
            color: '#000',
            backgroundColor: '#fff',
            border: 'none',
            borderRadius: '50px',
            cursor: 'pointer',
            textDecoration: 'none',
            transition: 'all 0.3s ease',
            boxShadow: '0 4px 14px rgba(0,0,0,0.15)',
        };

        const satisfiedTextStyle: CSSProperties = {
            fontSize: 'clamp(0.85rem, 1.2vw, 0.95rem)',
            fontWeight: '400',
            opacity: 0.85,
            marginBottom: '1.5rem',
            letterSpacing: '0.02em',
        };

        const leftContentStyle: CSSProperties = {
            position: 'absolute',
            left: '5%',
            top: '50%',
            transform: 'translateY(-50%)',
            maxWidth: '600px',
        };

        const rightContentStyle: CSSProperties = {
            position: 'absolute',
            right: '8%',
            top: '50%',
            transform: 'translateY(-50%)',
            maxWidth: '420px',
            textAlign: 'right',
        };

        // --- Animation helpers ---
        const animBaseHidden: CSSProperties = {
            opacity: 0,
            transform: 'translateY(35px)',
            transition: 'opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1)',
        };

        const animBaseVisible: CSSProperties = {
            opacity: 1,
            transform: 'translateY(0)',
        };

        const animSlideLeftHidden: CSSProperties = {
            opacity: 0,
            transform: 'translateX(40px)',
            transition: 'opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1)',
        };

        const animSlideLeftVisible: CSSProperties = {
            opacity: 1,
            transform: 'translateX(0)',
        };

        const getAnimStyle = (delay: number, direction: 'up' | 'left' = 'up'): CSSProperties => {
            const hidden = direction === 'up' ? animBaseHidden : animSlideLeftHidden;
            const visible = direction === 'up' ? animBaseVisible : animSlideLeftVisible;

            if (!isVisible.value) {
                return { ...hidden };
            }
            return {
                ...hidden,
                ...visible,
                transitionDelay: `${delay}ms`,
            };
        };

        const handleCta = (e: MouseEvent) => {
            const text = (props.buttonText || '').toLowerCase();
            const cta = ['đặt sân', 'dat san', 'đặt sân ngay', 'dat san ngay', 'bắt đầu ngay', 'bat dau ngay'];
            if (cta.some(t => text.includes(t))) {
                e.preventDefault();
                const bookingUrl = (window as any).App?.baseUrl ? `${(window as any).App.baseUrl}/san-gia` : '/san-gia';
                window.location.href = bookingUrl;
            }
        };

        return () => (
            <section class="banner-page-shortcode" style={sectionStyle}>
                <style>{`
                    .banner-cta-btn {
                        position: relative;
                        overflow: hidden;
                    }
                    .banner-cta-btn::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: -100%;
                        width: 60%;
                        height: 100%;
                        background: linear-gradient(
                            120deg,
                            transparent 0%,
                            rgba(255, 255, 255, 0.3) 35%,
                            rgba(255, 255, 255, 0.6) 50%,
                            rgba(255, 255, 255, 0.3) 65%,
                            transparent 100%
                        );
                        transition: left 0.6s ease;
                        z-index: 1;
                        pointer-events: none;
                    }
                    .banner-cta-btn:hover {
                        box-shadow: 0 6px 24px rgba(255, 255, 255, 0.3) !important;
                        transform: scale(1.05);
                    }
                    .banner-cta-btn:hover::before {
                        left: 150%;
                    }
                    .banner-cta-btn > span,
                    .banner-cta-btn > svg {
                        position: relative;
                        z-index: 2;
                    }
                `}</style>
                <div style={overlayStyle}></div>
                <div style={contentStyle}>
                    <div style={leftContentStyle}>
                        {/* Satisfied text — delay 0ms */}
                        {props.satisfiedText && (
                            <p style={{ ...satisfiedTextStyle, ...getAnimStyle(0) }}>
                                {props.satisfiedText}
                            </p>
                        )}

                        {/* Title — delay 200ms */}
                        {props.title && (
                            <h1 style={{ ...titleStyle, ...getAnimStyle(200) }}>
                                {props.title.split('\n').map((line: string, index: number) => (
                                    <span key={index}>
                                        {line}
                                        {index < props.title.split('\n').length - 1 && <br />}
                                    </span>
                                ))}
                            </h1>
                        )}

                        {/* Button — delay 400ms */}
                        {props.buttonText && props.buttonUrl && (
                            <div style={getAnimStyle(400)}>
                                <a href={props.buttonUrl} onClick={handleCta} class="banner-cta-btn" style={buttonStyle}>
                                    <span>{props.buttonText}</span>
                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M5 12H19M19 12L13 6M19 12L13 18" />
                                    </svg>
                                </a>
                            </div>
                        )}
                    </div>
                    <div style={rightContentStyle}>
                        {/* Description — delay 500ms, slides in from right */}
                        {props.description && (
                            <p style={{ ...descriptionStyle, ...getAnimStyle(500, 'left') }}>
                                {props.description}
                            </p>
                        )}
                    </div>
                </div>
            </section>
        );
    },
});
