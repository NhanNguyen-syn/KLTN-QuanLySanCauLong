import { defineComponent, CSSProperties } from 'vue';

export default defineComponent({
    name: 'BannerPage',
    props: {
        title: { type: String, required: false, default: 'Train Hard. Play Smart.\nRise Together.' },
        description: { type: String, required: false, default: 'A badminton club for those who want to grow — on and off the court.' },
        backgroundImage: { type: String, required: false, default: null },
        buttonText: { type: String, required: false, default: 'Become a Member' },
        buttonUrl: { type: String, required: false, default: '#' },
        satisfiedText: { type: String, required: false, default: 'Satisfied by 1k Users' },
        // Không dùng ảnh mẫu mặc định, để trống để hiển thị đúng dữ liệu truyền từ PHP

    },
    setup(props) {
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
                <div style={overlayStyle}></div>
                <div style={contentStyle}>
                    <div style={leftContentStyle}>
                        {/* Satisfied text */}
                        {props.satisfiedText && <p style={satisfiedTextStyle}>{props.satisfiedText}</p>}

                        {props.title && (
                            <h1 style={titleStyle}>
                                {props.title.split('\n').map((line: string, index: number) => (
                                    <span key={index}>
                                        {line}
                                        {index < props.title.split('\n').length - 1 && <br />}
                                    </span>
                                ))}
                            </h1>
                        )}
                        {props.buttonText && props.buttonUrl && (
                            <a href={props.buttonUrl} onClick={handleCta} style={buttonStyle}>
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
                        )}
                    </div>
                    <div style={rightContentStyle}>
                        {props.description && <p style={descriptionStyle}>{props.description}</p>}
                    </div>
                </div>
            </section>
        );
    },
});

