@php $page = $page ?? null; @endphp
@if(!empty($page))
    @php
        $pageContent = do_shortcode($page->content ?? "");
    @endphp
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
@endif

<style>
    .booking-page .table-header-row {
        background: linear-gradient(90deg, #065e45 0%, #0b6f52 30%, #138262 60%, #1b9a76 80%, #26b98f 100%) !important;
    }
    .booking-page .court-header-cell {
        background-color: #065e45 !important;
    }
    .booking-page .time-header-cell {
        background-color: transparent !important;
    }
    .booking-page .booking-summary-bar {
        background: linear-gradient(90deg, #065e45 0%, #0b6f52 30%, #138262 60%, #1b9a76 80%, #26b98f 100%) !important;
    }
</style>

<main class="booking-page">
    <div id="booking-page-app" data-courts='@json($courts ?? [])'></div>
</main>
