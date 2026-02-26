@php
    Theme::set('pageTitle', $post->name);
    $postImage = $post->image ? \Botble\Media\Facades\RvMedia::getImageUrl($post->image, null, false, \Botble\Media\Facades\RvMedia::getDefaultImage()) : null;
@endphp

<style>
    /* Breadcrumb */
    .post-breadcrumb {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 0;
    }
    .post-breadcrumb nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6b7280;
    }
    .post-breadcrumb a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }
    .post-breadcrumb a:hover { color: #1f2937; }
    .post-breadcrumb .current { color: #1f2937; font-weight: 600; }

    /* Post Header */
    .post-header-section {
        background: white;
        padding: 40px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .post-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 16px;
        line-height: 1.3;
    }
    .post-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        color: #6b7280;
        font-size: 14px;
    }
    .post-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .post-meta-item i {
        color: #059669;
        font-size: 18px;
    }
    .post-meta-item a {
        color: #059669;
        text-decoration: none;
        font-weight: 600;
    }
    .post-meta-item a:hover {
        text-decoration: underline;
    }

    /* Content Layout */
    .post-content-section {
        padding: 48px 0 64px;
        background: white;
    }
    .post-content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
    }
    @media (min-width: 992px) {
        .post-content-grid {
            grid-template-columns: 2.5fr 1fr;
        }
    }

    /* Post Thumbnail */
    .post-thumbnail {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .post-thumbnail img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* Main Content Styling */
    .ck-content {
        color: #374151;
        font-size: 1.05rem;
        line-height: 1.8;
    }
    .ck-content h2, .ck-content h3, .ck-content h4 {
        color: #1f2937;
        font-weight: 700;
        margin-top: 32px;
        margin-bottom: 16px;
    }
    .post-description {
        font-size: 1.15rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 24px;
        line-height: 1.6;
        padding-left: 16px;
        border-left: 4px solid #059669;
    }
    .ck-content p {
        margin-bottom: 20px;
    }
    .ck-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
    }
    .ck-content figure.image {
        display: block;
        text-align: center;
        margin: 24px auto;
    }
    .ck-content figure.image img {
        margin: 0 auto;
    }
    .ck-content figure.image figcaption {
        font-size: 14px;
        color: #6b7280;
        margin-top: 8px;
    }
    .ck-content ul, .ck-content ol {
        margin-bottom: 24px;
        padding-left: 24px;
    }
    .ck-content li {
        margin-bottom: 8px;
    }
    .ck-content a {
        color: #059669;
        text-decoration: none;
    }
    .ck-content a:hover {
        text-decoration: underline;
    }
    .ck-content blockquote {
        border-left: 4px solid #059669;
        padding-left: 20px;
        margin: 24px 0;
        font-style: italic;
        color: #4b5563;
        background: #f8fafc;
        padding: 16px 20px;
        border-radius: 0 12px 12px 0;
    }

    /* Tags */
    .post-tags {
        margin-top: 40px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .post-tags-label {
        font-weight: 600;
        color: #1f2937;
    }
    .post-tag {
        display: inline-block;
        background: #f3f4f6;
        color: #4b5563;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .post-tag:hover {
        background: #059669;
        color: white;
    }

    /* Sidebar */
    .post-sidebar {
        position: sticky;
        top: 100px;
    }
    .sidebar-widget {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        margin-bottom: 24px;
    }
    .sidebar-widget-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f3f4f6;
        position: relative;
    }
    .sidebar-widget-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 40px;
        height: 2px;
        background: #059669;
    }
    
    /* Related Posts */
    .related-post-item {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        align-items: flex-start;
    }
    .related-post-item:last-child {
        margin-bottom: 0;
    }
    .related-post-thumb {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .related-post-info h4 {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 6px 0;
        line-height: 1.4;
    }
    .related-post-info a {
        color: #1f2937;
        text-decoration: none;
        transition: color 0.2s;
    }
    .related-post-info a:hover {
        color: #059669;
    }
    .related-post-date {
        font-size: 12px;
        color: #6b7280;
    }
    
    /* Comment Section overrides */
    .post-content-grid .mt-5 form {
        margin-top: 20px;
    }
</style>

<!-- Breadcrumb -->
<section class="post-breadcrumb">
    <div class="container">
        <nav>
            <a href="{{ BaseHelper::getHomepageUrl() }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ url('/tin-tuc') }}">Tin tức</a>
            <span>/</span>
            <span class="current">{{ $post->name }}</span>
        </nav>
    </div>
</section>

<!-- Post Header -->
<section class="post-header-section">
    <div class="container">
        <h1 class="post-title">{{ $post->name }}</h1>
        <div class="post-meta">
            @if ($post->categories->isNotEmpty())
                <div class="post-meta-item">
                    <i class="ti ti-folder"></i>
                    <a href="{{ $post->categories->first()->url }}">{{ $post->categories->first()->name }}</a>
                </div>
            @endif
            <div class="post-meta-item">
                <i class="ti ti-calendar"></i>
                <span>{{ $post->created_at->translatedFormat('d/m/Y') }}</span>
            </div>
            @if(isset($post->author) && $post->author->name)
                <div class="post-meta-item">
                    <i class="ti ti-user"></i>
                    <span>Tác giả: {{ $post->author->name }}</span>
                </div>
            @endif
            <div class="post-meta-item">
                <i class="ti ti-eye"></i>
                <span>{{ $post->views ?? 0 }} lượt xem</span>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="post-content-section">
    <div class="container">
        <div class="post-content-grid">
            <!-- Main Content -->
            <div>
                @if($postImage)
                <div class="post-thumbnail">
                    <img src="{{ $postImage }}" alt="{{ $post->name }}">
                </div>
                @endif
                
                @if($post->description)
                <div class="post-description">
                    {{ $post->description }}
                </div>
                @endif
                
                @if (defined('GALLERY_MODULE_SCREEN_NAME') && !empty($galleries = gallery_meta_data($post)))
                    <div style="margin-bottom: 24px;">
                        {!! render_object_gallery($galleries, ($post->first_category ? $post->first_category->name : __('Uncategorized'))) !!}
                    </div>
                @endif
                
                <div class="ck-content">
                    {!! BaseHelper::clean($post->content) !!}
                </div>

                @if ($post->tags->isNotEmpty())
                <div class="post-tags">
                    <span class="post-tags-label"><i class="ti ti-tags"></i> Tags:</span>
                    @foreach ($post->tags as $tag)
                        <a href="{{ $tag->url }}" class="post-tag">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="post-sidebar">
                @php $relatedPosts = get_related_posts($post->getKey(), 5); @endphp
                @if ($relatedPosts->isNotEmpty())
                <div class="sidebar-widget">
                    <h3 class="sidebar-widget-title">Bài viết liên quan</h3>
                    <div>
                        @foreach ($relatedPosts as $relatedItem)
                            <div class="related-post-item">
                                <a href="{{ $relatedItem->url }}">
                                    <img src="{{ \Botble\Media\Facades\RvMedia::getImageUrl($relatedItem->image, 'thumb', false, \Botble\Media\Facades\RvMedia::getDefaultImage()) }}" alt="{{ $relatedItem->name }}" class="related-post-thumb">
                                </a>
                                <div class="related-post-info">
                                    <h4><a href="{{ $relatedItem->url }}">{{ $relatedItem->name }}</a></h4>
                                    <div class="related-post-date">{{ $relatedItem->created_at->translatedFormat('d/m/Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="sidebar-widget">
                    <h3 class="sidebar-widget-title">Đăng ký nhận tin</h3>
                    <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">Nhận những thông tin mới nhất về các giải đấu và kiến thức cầu lông.</p>
                    <form onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký!');">
                        <div style="display: flex; gap: 8px;">
                            <input type="email" placeholder="Email của bạn..." required style="flex: 1; min-width: 0; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; outline: none;">
                            <button type="submit" style="background: #059669; color: white; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
