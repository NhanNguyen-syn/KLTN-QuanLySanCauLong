import { defineComponent, PropType, onMounted, ref } from 'vue';

interface Item {
  title: string;
  desc: string;
  titleColor?: string | null;
  descColor?: string | null;
}

export default defineComponent({
  name: 'WhyChoose',
  props: {
    title: { type: String, required: true },
    subtitle: { type: String, required: false, default: '' },
    items: { type: Array as PropType<Item[]>, required: true },
    titleColor: { type: String, default: '#153E35' },
    subtitleColor: { type: String, default: '#6b7280' },
  },
  setup(props) {
    const sectionRef = ref<HTMLElement | null>(null);

    onMounted(() => {
      const el = sectionRef.value;
      if (!el) return;

      // Initially hide all items
      const items = el.querySelectorAll('.why-choose-item');
      items.forEach((item) => {
        (item as HTMLElement).style.opacity = '0';
        (item as HTMLElement).style.transform = 'translateY(40px)';
      });

      // IntersectionObserver to reveal on scroll
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              // Stagger the animations
              const cards = el.querySelectorAll('.why-choose-item');
              cards.forEach((card, idx) => {
                setTimeout(() => {
                  (card as HTMLElement).style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                  (card as HTMLElement).style.opacity = '1';
                  (card as HTMLElement).style.transform = 'translateY(0)';
                }, idx * 120);
              });
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.15 }
      );

      observer.observe(el);
    });

    return () => (
      <section
        ref={sectionRef}
        class="why-choose-section"
        style={{ backgroundColor: '#F3F7F5', padding: '80px 0', textAlign: 'center', fontFamily: "'Baloo 2', sans-serif" }}
      >
        <style>{`
          .why-choose-item {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
          }
          .why-choose-item:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 12px 28px rgba(0,0,0,0.1);
          }
          .why-choose-item h3 {
            font-size: 20px;
            font-weight: 700;
            color: #153E35;
            margin: 0 0 8px;
          }
          .why-choose-item p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin: 0;
          }
        `}</style>
        <div class="container">
          <h2 style={{ fontSize: '40px', fontWeight: 800, color: props.titleColor, marginTop: 0, marginBottom: '0.5rem' }}>{props.title}</h2>
          {props.subtitle && (
            <p style={{ color: props.subtitleColor, marginBottom: '20px' }}>{props.subtitle}</p>
          )}

          <div class="why-grid" style={{display: 'grid', gap: '2rem', maxWidth: '1200px', margin: '0 auto', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))'}}>
            {props.items.map((it, idx) => (
              <div key={idx} class="why-choose-item">
                <h3 style={{ color: it.titleColor || undefined }}>{it.title}</h3>
                <p style={{ color: it.descColor || undefined }}>{it.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  },
});
