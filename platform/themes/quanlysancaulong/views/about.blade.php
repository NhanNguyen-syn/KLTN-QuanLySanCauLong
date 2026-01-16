{!! dynamic_sidebar('top_sidebar') !!}
@php $page = $page ?? null; @endphp
@php $page = $page ?? null; @endphp



<div class="min-h-screen flex flex-col bg-background">
    <main class="flex-1 about-page">
        @if(!empty($page))
            @php
                $pageContent = do_shortcode($page->content ?? "");
            @endphp
            {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
        @endif
    </main>
</div>
