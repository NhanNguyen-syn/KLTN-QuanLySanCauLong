@php
    Theme::set('pageTitle', 'Tag: ' . $tag->name);
@endphp

<style>
    .page-header {
        background: #f8fafc;
        padding: 40px 0;
        text-align: center;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 40px;
    }
    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 10px;
    }
    .post-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }
    @media (min-width: 768px) {
        .post-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 992px) {
        .post-grid { grid-template-columns: repeat(3, 1fr); }
    }
    .post-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
    }
    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .post-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .post-card-content {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .post-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .post-card-title a {
        color: #1f2937;
        text-decoration: none;
    }
    .post-card-title a:hover {
        color: #059669;
    }
    .post-card-desc {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 16px;
        flex: 1;
    }
    .post-card-meta {
        font-size: 13px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .post-card-meta i {
        margin-right: 4px;
    }
</style>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Tag: {{ $tag->name }}</h1>
    </div>
</div>

<div class="container">
    @if ($posts->isNotEmpty())
        <div class="post-grid">
            @foreach ($posts as $post)
                <div class="post-card">
                    <a href="{{ $post->url }}">
                        <img src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($post->image, 'small', false, \Botble\Media\Facades\RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}" class="post-card-img">
                    </a>
                    <div class="post-card-content">
                        <h3 class="post-card-title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                        <p class="post-card-desc">{{ Str::limit($post->description, 120) }}</p>
                        <div class="post-card-meta">
                            <span><i class="ti ti-calendar"></i>{{ $post->created_at->translatedFormat('d/m/Y') }}</span>
                            <span><i class="ti ti-eye"></i>{{ $post->views ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {!! $posts->withQueryString()->links() !!}
        </div>
    @else
        <div class="text-center my-5 py-5">
            <h3 class="text-muted">Chưa có bài viết nào với tag này.</h3>
        </div>
    @endif
</div>
