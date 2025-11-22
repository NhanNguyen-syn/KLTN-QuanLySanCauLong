import { defineComponent, PropType } from 'vue';

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
    return () => (
      <section class="why-choose-section" style={{ backgroundColor: '#F3F7F5', padding: '80px 0', textAlign: 'center', fontFamily: "'Baloo 2', sans-serif" }}>
        {/* Scoped styles for responsive 1-2-3 columns like the design */}
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

