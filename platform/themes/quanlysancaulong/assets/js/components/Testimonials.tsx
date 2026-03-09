import { defineComponent, PropType } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay } from 'swiper/modules';
import 'swiper/css';

interface TestimonialItem {
  name: string;
  role: string;
  avatar: string;
  content: string;
  stars: number;
}

export default defineComponent({
  name: 'Testimonials',
  components: { Swiper, SwiperSlide },
  props: {
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    itemsRow1: { type: Array as PropType<TestimonialItem[]>, required: true },
    itemsRow2: { type: Array as PropType<TestimonialItem[]>, required: true },
    titleColor: { type: String, default: '#153E35' },
    subtitleColor: { type: String, default: '#6b7280' },
    bgColor: { type: String, default: '#F3F7F5' },
    cardBgColor: { type: String, default: '#ffffff' },
    starColor: { type: String, default: '#C6F432' },
    speed: { type: Number, default: 5000 },
    secondRowSpeed: { type: Number, default: 7000 },
    buttonText: { type: String, default: 'See more' },
    buttonUrl: { type: String, default: '#' },
    buttonBgColor: { type: String, default: '#C6F432' },
    buttonTextColor: { type: String, default: '#153E35' },
  },
  setup(props) {
    const duplicateItems = (items: TestimonialItem[], times: number = 10) => {
      const result: TestimonialItem[] = [];
      for (let i = 0; i < times; i++) {
        result.push(...items);
      }
      return result;
    };

    const baseSwiperOptions: any = {
      modules: [Autoplay],
      loop: true,
      loopAdditionalSlides: 3,
      slidesPerView: 'auto',
      spaceBetween: 24,
      centeredSlides: true,
      allowTouchMove: false,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
        reverseDirection: false,
      },
      freeMode: true,
      freeModeMomentum: false,
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 16,
          centeredSlides: false,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 24,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 24,
        },
        1200: {
          slidesPerView: 'auto',
          spaceBetween: 24,
        }
      }
    };

    const swiperOptionsRow1: any = { ...baseSwiperOptions, speed: props.speed };
    const swiperOptionsRow2: any = { ...baseSwiperOptions, speed: props.secondRowSpeed };

    // Duplicate items để tạo infinite scroll
    const duplicatedItemsRow1 = duplicateItems(props.itemsRow1);
    const duplicatedItemsRow2 = duplicateItems(props.itemsRow2);

    const renderStars = (count: number) => {
      const stars = [];
      for (let i = 0; i < 5; i++) {
        stars.push(
          <span key={i} style={{ color: i < count ? props.starColor : '#E5E7EB' }}>★</span>
        );
      }
      return <div class="testimonial-stars">{stars}</div>;
    };

    return () => (
      <section
        class="testimonials-section"
        style={{ backgroundColor: props.bgColor, fontFamily: "'Be Vietnam Pro', sans-serif" }}
      >
        <style>{`
          .testimonials-section {
            padding: 0 0 80px;
            overflow: hidden;
          }
          .testimonials-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
          }
          .testimonials-header-content {
            max-width: 700px;
            margin: 0 auto 48px;
          }
          .testimonial-swiper {
            overflow: visible; /* Show shadows */
          }
          .testimonial-swiper .swiper-wrapper {
            transition-timing-function: linear !important;
          }
          .testimonial-content {
            white-space: normal !important; /* Ensure text wraps */
          }
          .testimonial-swiper .swiper-slide {
            width: 400px;
            height: auto;
            display: flex;
            flex-direction: column;
          }
          .testimonial-card {
            background: ${props.cardBgColor};
            border: 1px solid #F3F4F6;
            border-radius: 24px;
            padding: 24px;
            text-align: left;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            flex-grow: 1;
          }
          .testimonial-card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
          }
          .testimonial-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
          }
          .testimonial-info {
            flex-grow: 1;
          }
          .testimonial-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #111827;
          }
          .testimonial-role {
            font-size: 0.9rem;
            color: #6B7280;
            margin-top: 4px;
          }
          .testimonial-stars {
            font-size: 1rem;
            letter-spacing: 1.5px;
            flex-shrink: 0;
          }
          .testimonial-content {
            color: #4B5563;
            font-size: 1rem;
            line-height: 1.6;
            flex-grow: 1;
          }
          .testimonials-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-top: 48px;
            border: none;
            cursor: pointer;
          }
          .testimonials-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
          }
          .button-icon {
            width: 24px;
            height: 24px;
            background-color: ${props.buttonTextColor};
            color: ${props.buttonBgColor};
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
          }
          .testimonials-button:hover .button-icon {
             transform: rotate(-45deg);
          }
          .button-icon svg {
            width: 14px;
            height: 14px;
          }
        `}</style>

        <div class="testimonials-container">
          <div class="testimonials-header-content">
            <h2 style={{ fontSize: '2.75rem', fontWeight: 700, color: props.titleColor, marginTop: 0, marginBottom: '16px' }}>
              {props.title}
            </h2>
            {props.subtitle && (
              <p style={{ color: props.subtitleColor, fontSize: '1.1rem', lineHeight: 1.7 }}>
                {props.subtitle}
              </p>
            )}
          </div>
        </div>

        {/* Row 1: Auto-scrolling slider */}
        <Swiper {...swiperOptionsRow1} class="testimonial-swiper">
          {duplicatedItemsRow1.map((item: TestimonialItem, idx: number) => (
            <SwiperSlide key={idx}>
              <div class="testimonial-card">
                <div class="testimonial-card-header">
                  {item.avatar && <img src={item.avatar} alt={item.name} class="testimonial-avatar" />}
                  <div class="testimonial-info">
                    <h4 class="testimonial-name">{item.name}</h4>
                    {item.role && <p class="testimonial-role">{item.role}</p>}
                  </div>
                  {renderStars(item.stars)}
                </div>
                <p class="testimonial-content">{item.content}</p>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>

        {/* Row 2: Another auto-scrolling slider */}
        <Swiper {...swiperOptionsRow2} class="testimonial-swiper" style={{ marginTop: '32px' }}>
          {duplicatedItemsRow2.map((item: TestimonialItem, idx: number) => (
            <SwiperSlide key={`row2-${idx}`}>
              <div class="testimonial-card">
                <div class="testimonial-card-header">
                  {item.avatar && <img src={item.avatar} alt={item.name} class="testimonial-avatar" />}
                  <div class="testimonial-info">
                    <h4 class="testimonial-name">{item.name}</h4>
                    {item.role && <p class="testimonial-role">{item.role}</p>}
                  </div>
                  {renderStars(item.stars)}
                </div>
                <p class="testimonial-content">{item.content}</p>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>

        <div class="testimonials-container">
          {props.buttonText && (
            <a
              href={props.buttonUrl}
              class="testimonials-button"
              style={{
                backgroundColor: props.buttonBgColor,
                color: props.buttonTextColor,
              }}
            >
              <span>{props.buttonText}</span>
              <span class="button-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5-5 5M6 12h12"></path>
                </svg>
              </span>
            </a>
          )}
        </div>
      </section>
    );
  },
});
