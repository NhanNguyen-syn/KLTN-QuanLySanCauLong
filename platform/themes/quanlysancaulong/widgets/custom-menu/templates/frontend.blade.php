<div class="footer-widget-col" style="flex: 0 0 auto; min-width: 200px;">
    @if ($config['name'] ?? null)
        <h5 class="footer-widget-title fw-semibold mb-4 d-flex align-items-center">
            <span class="me-2 d-inline-block rounded-pill" style="width:4px;height:20px;background-color:#10b981"></span>
            {{ $config['name'] }}
        </h5>
    @endif
    
    <div class="footer-menu-container">
        {!!
            Menu::generateMenu([
                'slug'    => $config['menu_id'] ?? '',
                'view'    => 'footer-menu',
                'options' => ['class' => 'list-unstyled mb-0 d-flex flex-column gap-2'],
            ])
        !!}
    </div>
</div>
