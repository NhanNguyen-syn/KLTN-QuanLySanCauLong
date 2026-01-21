@php
    use RvMedia;
@endphp

<div class="court-grid-wrapper">
    <div class="court-grid">
        @foreach($courts as $court)
            @php
                $imageUrl = $court->image ? RvMedia::getImageUrl($court->image) : asset('themes/quanlysancaulong/images/default-court.jpg');
                $bookingUrl = $court->booking_url ?: '/dat-san';
                $price = $court->default_price ?: 150000;
                $address = $court->address ?: $court->location;
            @endphp
            
            <div class="court-card">
                <div class="court-image">
                    <img src="{{ $imageUrl }}" alt="{{ $court->name }}" loading="lazy">
                    <div class="court-image-overlay"></div>
                    
                    @if($court->slots()->where('status', 'available')->exists())
                        <div class="time-badges">
                            @php
                                $availableSlots = $court->slots()
                                    ->where('status', 'available')
                                    ->whereDate('start_at', today())
                                    ->orderBy('start_at')
                                    ->take(2)
                                    ->get();
                            @endphp
                            @foreach($availableSlots as $slot)
                                <span class="time-badge">
                                    {{ \Carbon\Carbon::parse($slot->start_at)->format('H:i') }}-{{ \Carbon\Carbon::parse($slot->end_at)->format('H:i') }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="court-info">
                    <h3 class="court-name">{{ $court->name }}</h3>
                    
                    @if($address)
                        <p class="court-location">
                            <svg class="location-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            {{ $address }}
                        </p>
                    @endif
                    
                    <div class="court-pricing">
                        <span class="pricing-label">Giá bắt đầu từ</span>
                        <span class="pricing-amount">{{ number_format($price) }}đ<span class="pricing-unit">/giờ</span></span>
                    </div>
                    
                    <a href="{{ $bookingUrl }}" class="btn-book-court">
                        Đặt sân
                        <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($courts->isEmpty())
        <div class="no-courts-message">
            <p>Hiện chưa có sân nào được đăng tải. Vui lòng quay lại sau.</p>
        </div>
    @endif
</div>

<style>
.court-grid-wrapper {
    padding: 2rem 0;
}

.court-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin: 0 auto;
}

.court-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.court-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.court-image {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.court-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.court-card:hover .court-image img {
    transform: scale(1.05);
}

.court-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 100%);
}

.time-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 2;
}

.time-badge {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    color: #333;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.court-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.court-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.75rem 0;
    line-height: 1.3;
}

.court-location {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    color: #666;
    font-size: 0.875rem;
    line-height: 1.5;
    margin: 0 0 1rem 0;
}

.location-icon {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    margin-top: 2px;
    color: #3b82f6;
}

.court-pricing {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin: auto 0 1.25rem 0;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.pricing-label {
    font-size: 0.75rem;
    color: #999;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.pricing-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #3b82f6;
    line-height: 1;
}

.pricing-unit {
    font-size: 0.875rem;
    font-weight: 500;
    color: #666;
}

.btn-book-court {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-book-court:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    transform: translateY(-2px);
    color: white;
}

.arrow-icon {
    width: 18px;
    height: 18px;
    transition: transform 0.3s ease;
}

.btn-book-court:hover .arrow-icon {
    transform: translateX(4px);
}

.no-courts-message {
    text-align: center;
    padding: 3rem 1rem;
    color: #666;
    font-size: 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .court-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .court-card {
        max-width: 500px;
        margin: 0 auto;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .court-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .court-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
}
</style>
