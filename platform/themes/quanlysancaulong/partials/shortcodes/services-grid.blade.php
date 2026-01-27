<style>
    .services-section { padding: 3rem 0; }
    .services-wrapper { background: white; border-radius: 0.5rem; border: 2px solid #d1f2e8; padding: 2rem; }
    .services-wrapper h2 { font-size: 1.5rem; font-weight: 700; color: #0a2818; margin-bottom: 2rem; }
    .services-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    @media (max-width: 768px) { .services-grid { grid-template-columns: 1fr; } }
    .service-card { padding: 1.5rem; border: 2px solid #d1f2e8; border-radius: 0.5rem; transition: border-color 0.2s; }
    .service-card:hover { border-color: #065f46; }
    .service-name { font-size: 1.125rem; font-weight: 700; color: #0a2818; margin-bottom: 0.5rem; }
    .service-description { font-size: 0.875rem; color: #4a7c6f; margin-bottom: 0.75rem; }
    .service-price { font-size: 1.125rem; font-weight: 700; color: #065f46; margin-bottom: 0.75rem; }
    .service-btn { width: 100%; padding: 0.5rem 1rem; background: #065f46; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .service-btn:hover { background: #14b8a6; }
</style>

@if($services->isNotEmpty())
    <section class="services-section">
        <div class="container mx-auto px-4" style="max-width: 80rem;">
            <div class="services-wrapper">
                <h2>{{ $shortcode->title ?: 'Dịch Vụ Thêm' }}</h2>
                <div class="services-grid" id="servicesGrid">
                    @foreach($services as $service)
                        <div class="service-card">
                            <h3 class="service-name">{{ $service->name }}</h3>
                            <p class="service-description">{{ $service->description }}</p>
                            <p class="service-price">{{ $service->price }}</p>
                            <button class="service-btn" onclick="alert('Vui lòng liên hệ trực tiếp tại quầy lễ tân.')">Liên hệ tại quầy</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
