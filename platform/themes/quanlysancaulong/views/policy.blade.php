{!! dynamic_sidebar('top_sidebar') !!}

<main class="flex-1 policy-page">
    @if(!empty($page))
        @php
            $pageContent = do_shortcode($page->content ?? '');
        @endphp
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
    @endif
</main>
