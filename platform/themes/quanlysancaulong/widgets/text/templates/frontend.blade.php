<div class="footer-widget-col" style="flex: 0 0 auto; width: 240px;">
    @if (!empty($config['name']))
        <h5 class="footer-widget-title fw-semibold mb-4 d-flex align-items-center">
            <span class="me-2 d-inline-block rounded-pill" style="width:4px;height:20px;background-color:#10b981"></span>
            {{ $config['name'] }}
        </h5>
    @endif
    <div class="footer-widget-content small text-white-50">
        {!! nl2br($config['content']) !!}
    </div>
</div>
