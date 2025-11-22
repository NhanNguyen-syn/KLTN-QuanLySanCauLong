import { defineComponent, ref, computed } from 'vue';

interface Tab {
    icon: string;
    title: string;
    description: string;
    color: string;
    title_color?: string;
    description_color?: string;
}

export default defineComponent({
    props: {
        title: {
            type: String,
            default: '',
        },
        subtitle: {
            type: String,
            default: '',
        },
        titleColor: {
            type: String,
            default: '#0E6B5C',
        },
        subtitleColor: {
            type: String,
            default: '#6c757d',
        },
        tabs: {
            type: String, // Data from Blade is a string
            default: '[]',
        },
    },
    setup(props) {
        const title = ref(props.title);
        const subtitle = ref(props.subtitle);
        const titleColor = ref(props.titleColor);
        const subtitleColor = ref(props.subtitleColor);

        const parsedTabs = computed<Tab[]>(() => {
            try {
                return JSON.parse(props.tabs);
            } catch (e) {
                console.error('Failed to parse tabs data:', e);
                return [];
            }
        });

        return {
            title,
            subtitle,
            titleColor,
            subtitleColor,
            tabs: parsedTabs,
        };
    },
    template: `
        <section class="section-box">
            <div class="container mt-120">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h2 class="mb-20" :style="{ color: titleColor, fontSize: '36px' }">{{ title }}</h2>
                            <p :style="{ color: subtitleColor, fontSize: '18px', marginBottom: '3rem' }">{{ subtitle }}</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-140">
                    <div v-for="(tab, index) in tabs" :key="index" class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card-small-square">
                            <div class="card-image">
                                <div class="box-image" :style="{ backgroundColor: tab.color }">
                                    <img :src="tab.icon" :alt="tab.title" />
                                </div>
                            </div>
                            <div class="card-info">
                                <h6 class="mb-10" :style="{ color: tab.title_color || undefined, fontSize: '20px' }">{{ tab.title }}</h6>
                                <p :style="{ color: tab.description_color || undefined, fontSize: '18px' }">{{ tab.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    `,
});

