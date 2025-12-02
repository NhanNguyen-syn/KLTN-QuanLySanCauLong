import { defineComponent, ref, computed, PropType } from 'vue';

interface Category {
    id: number;
    name: string;
    url?: string;
}

interface Post {
    id: number;
    name: string;
    description: string;
    url: string;
    image: string;
    authorName: string;
    createdAt: string;
    readingTime: string;
    categories: Category[];
}

export default defineComponent({
    name: 'BlogPost',
    props: {
        title: { type: String, default: '' },
        subtitle: { type: String, default: '' },
        categories: { type: Array as PropType<Category[]>, required: true },
        posts: { type: Array as PropType<Post[]>, required: true },
        allText: { type: String, default: 'Tất Cả' },
    },
    setup(props) {
        const activeCategoryId = ref<number | null>(null);

        const filteredPosts = computed(() => {
            if (activeCategoryId.value === null) {
                return props.posts;
            }
            return props.posts.filter(post =>
                post.categories.some(cat => cat.id === activeCategoryId.value)
            );
        });

        const setActiveCategory = (id: number | null) => {
            activeCategoryId.value = id;
        };

        const PostCard = (post: Post) => (
            <div class="bp-card">
                <a href={post.url} class="bp-card-image-link">
                    <img src={post.image} alt={post.name} loading="lazy" decoding="async" />
                    {post.categories[0] && (
                        <span class="bp-card-category-tag">{post.categories[0].name}</span>
                    )}
                </a>
                <div class="bp-card-content">
                    <h3 class="bp-card-title"><a href={post.url}>{post.name}</a></h3>
                    <p class="bp-card-description">{post.description}</p>
                    <div class="bp-card-meta">
                        <div class="bp-meta-info">
                            <span class="bp-meta-author">{post.authorName}</span>
                            <span class="bp-meta-date">{post.createdAt}</span>
                        </div>
                        <a href={post.url} class="bp-card-arrow">→</a>
                    </div>
                </div>
            </div>
        );

        return () => (
            <div class="bp-container">
                <header class="bp-header">
                    {props.title && <h2 class="bp-title">{props.title}</h2>}
                    {props.subtitle && <p class="bp-subtitle">{props.subtitle}</p>}
                    <div class="bp-filters">
                        <button
                            class={['bp-filter-btn', activeCategoryId.value === null ? 'active' : '']}
                            onClick={() => setActiveCategory(null)}
                        >
                            {props.allText}
                        </button>
                        {props.categories.map(cat => (
                            <button
                                key={cat.id}
                                class={['bp-filter-btn', activeCategoryId.value === cat.id ? 'active' : '']}
                                onClick={() => setActiveCategory(cat.id)}
                            >
                                {cat.name}
                            </button>
                        ))}
                    </div>
                </header>
                <div class="bp-grid">
                    {filteredPosts.value.map(post => <PostCard key={post.id} {...post} />)}
                </div>
            </div>
        );
    },
});

