<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 small text-white-50">
    @if($copyrightText)
        <span>{{ $copyrightText }}</span>
    @endif
    
    @if(!empty($links))
        <div class="d-flex flex-wrap gap-3">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" class="text-white-50 text-decoration-none hover-link">
                    {{ $link['text'] }}
                </a>
            @endforeach
        </div>
    @endif
</div>

<style>
.hover-link:hover {
    color: #10b981 !important;
}
</style>
