@php
    $containerId = 'shortcode-blog-post-' . $shortcode->hash;

    $allPosts = $posts->map(function ($post) {
        return [
            'id' => $post->id,
            'name' => $post->name,
            'description' => $post->description,
            'url' => $post->url,
            'image' => RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()),
            'authorName' => $post->author->name ?? 'N/A',
            'createdAt' => $post->created_at->translatedFormat('d/m/Y'),
            'readingTime' => __(':time phút đọc', ['time' => $post->time_to_read]),
            'categories' => $post->categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'url' => $c->url])->all(),
        ];
    })->all();

    $allCategories = $categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->all();

    $props = [
        'title' => $title,
        'subtitle' => $subtitle,
        'categories' => $allCategories,
        'posts' => $allPosts,
        'allText' => __('Tất Cả'),
    ];
@endphp

<section class="blog-post-section">
    <div id="{{ $containerId }}" data-props='@json($props)'></div>
</section>

