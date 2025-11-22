import { defineComponent, PropType, ref } from 'vue';

type Item = {
  question?: string;
  answer?: string;
};

type Props = {
  title?: string;
  subtitle?: string;
  titleColor?: string;
  subtitleColor?: string;
  items?: Item[];
};

export default defineComponent<Props>({
  name: 'AskedQuestions',
  props: {
    title: String,
    subtitle: String,
    titleColor: String,
    subtitleColor: String,
    items: Array as PropType<Item[]>,
  },
  setup(props) {
    const activeIndex = ref<number | null>(null);

    const toggleItem = (index: number) => {
      activeIndex.value = activeIndex.value === index ? null : index;
    };



    return () => (
      <section class="asked-questions">
        <div class="container">
          {props.title && <h2 class="aq-title" style={{ color: props.titleColor }}>{props.title}</h2>}
          {props.subtitle && <p class="aq-subtitle" style={{ color: props.subtitleColor }}>{props.subtitle}</p>}
          <div class="aq-grid">
            {(props.items || []).map((item, index) => (
              <div class={['aq-item', { 'is-active': activeIndex.value === index }]} key={index}>
                <button class="aq-question" onClick={() => toggleItem(index)} aria-expanded={activeIndex.value === index}>
                  <span>{item.question}</span>
                  <span class="aq-icon" aria-hidden="true">
                    {/* Layered icons for smooth cross-fade/rotate */}
                    <svg class="icon-plus" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12 6V18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <svg class="icon-x" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </button>
                <div class="aq-answer-wrapper">
                  <div class="aq-answer">
                    <p>{item.answer}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  },
});

