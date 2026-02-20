{!! dynamic_sidebar('top_sidebar') !!}
@php
    $page = $page ?? null;
    Theme::set('pageTitle', ($page->name ?? 'Sản Phẩm & Dịch Vụ') . ' - ' . theme_option('site_title', 'Sân cầu lông Niên Thời'));
    Theme::set('pageDescription', $page->description ?? 'Tất cả những gì bạn cần cho trình độ cầu lông');
@endphp

<style>
    .products-page {
        min-height: 100vh;
        background: #f8faf6;
    }
</style>

<div class="products-page">
    @if(!empty($page))
        @php
            $pageContent = do_shortcode($page->content ?? "");
        @endphp
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
    @else
        {{-- Fallback if no page exists --}}
        <div class="container mx-auto py-12 px-4">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Sản Phẩm & Dịch Vụ</h1>
                <p class="text-gray-600">Trang này chưa được cấu hình. Vui lòng tạo trang với slug "san-pham-dich-vu" và thêm các shortcode:</p>
                <ul class="mt-4 text-left inline-block">
                    <li class="mb-2">✓ <code>[banner-for-yard]</code> - Banner đầu trang</li>
                    <li class="mb-2">✓ <code>[products-grid]</code> - Lưới sản phẩm</li>
                    <li class="mb-2">✓ <code>[services-grid]</code> - Lưới dịch vụ</li>
                </ul>
            </div>
        </div>
    @endif
</div>
