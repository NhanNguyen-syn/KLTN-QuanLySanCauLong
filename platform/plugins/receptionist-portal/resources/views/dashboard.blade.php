@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<style>
    .receptionist-dashboard {
        padding: 0;
    }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
        .quick-actions { grid-template-columns: repeat(2, 1fr); }
    }
    .quick-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .quick-btn:hover {
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        transform: translateY(-2px);
        color: #4f46e5;
    }
    .quick-btn .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .quick-btn .icon-circle svg {
        width: 20px;
        height: 20px;
    }
    .quick-btn.qb-booking .icon-circle { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
    .quick-btn.qb-list .icon-circle { background: linear-gradient(135deg, #06b6d4, #0891b2); }
    .quick-btn.qb-vip .icon-circle { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .quick-btn.qb-service .icon-circle { background: linear-gradient(135deg, #10b981, #059669); }
    .quick-btn .icon-circle svg { color: white; }
    .quick-btn span { font-weight: 600; font-size: 0.9375rem; }
    
    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1024px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .stats-row { grid-template-columns: 1fr; } }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    .stat-card.primary::before { background: linear-gradient(90deg, #4f46e5, #7c3aed); }
    .stat-card.success::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-card.warning::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-card.info::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
    
    .stat-card .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-card .stat-icon svg { width: 24px; height: 24px; }
    .stat-card.primary .stat-icon { background: #eef2ff; color: #4f46e5; }
    .stat-card.success .stat-icon { background: #d1fae5; color: #10b981; }
    .stat-card.warning .stat-icon { background: #fef3c7; color: #f59e0b; }
    .stat-card.info .stat-icon { background: #dbeafe; color: #06b6d4; }
    
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-card .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
    }
    @media (max-width: 1200px) { .content-grid { grid-template-columns: 1fr; } }
    
    /* Cards */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
    }
    .card-header h3 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }
    .card-header .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .card-body { padding: 0; }
    
    /* Booking Items */
    .booking-list { max-height: 450px; overflow-y: auto; }
    .booking-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        transition: background 0.15s;
    }
    .booking-item:last-child { border-bottom: none; }
    .booking-item:hover { background: #f9fafb; }
    
    .booking-info { flex: 1; min-width: 0; }
    .booking-info h4 {
        font-size: 0.9375rem;
        font-weight: 600;
        margin: 0 0 0.25rem;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .booking-info h4 .time-badge {
        background: #eef2ff;
        color: #4f46e5;
        padding: 0.125rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .booking-info .meta {
        font-size: 0.8125rem;
        color: #6b7280;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .booking-info .meta .divider { color: #d1d5db; }
    .booking-info .meta .price { font-weight: 600; color: #1f2937; }
    .booking-info .meta .remaining { color: #dc2626; }
    
    .booking-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .status-pending { background: #fef3c7; color: #b45309; }
    .status-confirmed { background: #dbeafe; color: #1d4ed8; }
    .status-paid { background: #d1fae5; color: #047857; }
    .status-completed { background: #e5e7eb; color: #374151; }
    
    /* Buttons */
    .btn-action {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    .btn-action svg { width: 14px; height: 14px; }
    .btn-checkin { background: #10b981; color: white; }
    .btn-checkin:hover { background: #059669; }
    .btn-payment { background: #4f46e5; color: white; }
    .btn-payment:hover { background: #4338ca; }
    .btn-checkout { background: #f59e0b; color: white; }
    .btn-checkout:hover { background: #d97706; }
    
    /* Sidebar Cards */
    .sidebar-card { margin-bottom: 1rem; }
    .sidebar-card:last-child { margin-bottom: 0; }
    .sidebar-card .card-body { max-height: 280px; overflow-y: auto; }
    
    .sidebar-item {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sidebar-item:last-child { border-bottom: none; }
    .sidebar-item:hover { background: #f9fafb; }
    .sidebar-item .info h5 {
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0 0 0.125rem;
        color: #1f2937;
    }
    .sidebar-item .info .sub {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    /* Empty State */
    .empty-state {
        padding: 2rem;
        text-align: center;
        color: #9ca3af;
    }
    .empty-state svg {
        width: 48px;
        height: 48px;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }
    .empty-state p { margin: 0; font-size: 0.875rem; }
    
    /* Modal Improvements */
    .modal-content { border-radius: 16px; border: none; }
    .modal-header { border-bottom: 1px solid #f3f4f6; }
    .modal-footer { border-top: 1px solid #f3f4f6; }
</style>

<div class="receptionist-dashboard">
    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('receptionist.quick-booking') }}" class="quick-btn qb-booking">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span>Đặt sân nhanh</span>
        </a>
        <a href="{{ route('booking-list.index') }}" class="quick-btn qb-list">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span>Xem tất cả đơn</span>
        </a>
        <a href="{{ route('revenue-statistics.index') }}" class="quick-btn qb-vip">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <span>Thống kê</span>
        </a>
        <a href="{{ route('services.index') }}" class="quick-btn qb-service">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span>Dịch vụ</span>
        </a>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card primary">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_today'] }}</div>
            <div class="stat-label">Đơn hôm nay</div>
        </div>
        <div class="stat-card success">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $stats['checked_in'] }}</div>
            <div class="stat-label">Đã hoàn thành</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $stats['waiting_checkin'] }}</div>
            <div class="stat-label">Chờ check-in</div>
        </div>
        <div class="stat-card info">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['revenue_today'] / 1000000, 1) }}M</div>
            <div class="stat-label">Doanh thu hôm nay</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Today's Bookings -->
        <div class="card">
            <div class="card-header">
                <h3>📅 Lịch hôm nay ({{ Carbon\Carbon::today()->format('d/m/Y') }})</h3>
                <span class="badge bg-primary text-white">{{ $todayBookings->count() }} đơn</span>
            </div>
            <div class="card-body">
                <div class="booking-list">
                    @forelse($todayBookings as $booking)
                    <div class="booking-item" data-id="{{ $booking->id }}">
                        <div class="booking-info">
                            <h4>
                                <span class="time-badge">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                                {{ $booking->court_name }}
                            </h4>
                            <div class="meta">
                                <span>👤 {{ $booking->customer_name }}</span>
                                <span class="divider">•</span>
                                <span>📞 {{ $booking->contact }}</span>
                                <span class="divider">•</span>
                                <span class="price">💰 {{ number_format($booking->grand_total) }}đ</span>
                                @if($booking->paid_amount < $booking->grand_total)
                                <span class="divider">•</span>
                                <span class="remaining">⚠️ Còn {{ number_format($booking->remaining_amount) }}đ</span>
                                @endif
                            </div>
                        </div>
                        <div class="booking-actions">
                            <span class="status-badge status-{{ $booking->status }}">
                                @switch($booking->status)
                                    @case('pending') Chờ TT @break
                                    @case('confirmed') Xác nhận @break
                                    @case('paid') Đã TT @break
                                    @case('completed') Xong @break
                                    @default {{ $booking->status }}
                                @endswitch
                            </span>
                            @if($booking->status === 'pending' || $booking->status === 'confirmed')
                            <button class="btn-action btn-checkin" onclick="checkin({{ $booking->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                In
                            </button>
                            @endif
                            @if($booking->remaining_amount > 0)
                            <button class="btn-action btn-payment" onclick="openPayment({{ $booking->id }}, {{ $booking->remaining_amount }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                TT
                            </button>
                            @endif
                            @if($booking->isFullyPaid() && $booking->status !== 'completed')
                            <button class="btn-action btn-checkout" onclick="checkout({{ $booking->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Out
                            </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>Chưa có đơn nào hôm nay</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Pending Payments -->
            <div class="card sidebar-card">
                <div class="card-header">
                    <h3>💳 Chờ thanh toán</h3>
                    <span class="badge bg-warning text-dark">{{ $pendingPayments->count() }}</span>
                </div>
                <div class="card-body">
                    @forelse($pendingPayments as $booking)
                    <div class="sidebar-item">
                        <div class="info">
                            <h5>{{ $booking->court_name }}</h5>
                            <div class="sub">{{ $booking->customer_name }} • {{ number_format($booking->remaining_amount) }}đ</div>
                        </div>
                        <button class="btn-action btn-payment" onclick="openPayment({{ $booking->id }}, {{ $booking->remaining_amount }})">TT</button>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Không có đơn chờ</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming -->
            <div class="card sidebar-card">
                <div class="card-header">
                    <h3>⏰ Sắp đến giờ (2h tới)</h3>
                </div>
                <div class="card-body">
                    @forelse($upcomingBookings as $booking)
                    <div class="sidebar-item">
                        <div class="info">
                            <h5>{{ $booking->start_time }} - {{ $booking->court_name }}</h5>
                            <div class="sub">{{ $booking->customer_name }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Không có lịch sắp tới</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">💳 Thanh toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <input type="hidden" id="payment_booking_id">
                    <div class="mb-3">
                        <label class="form-label">Số tiền còn lại</label>
                        <input type="text" id="remaining_display" class="form-control form-control-lg text-end fw-bold text-danger" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số tiền thanh toán</label>
                        <input type="number" id="payment_amount" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phương thức</label>
                        <select id="payment_method" class="form-select form-select-lg" required>
                            <option value="cash">💵 Tiền mặt</option>
                            <option value="transfer">🏦 Chuyển khoản</option>
                            <option value="card">💳 Thẻ</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary btn-lg" onclick="submitPayment()">✓ Xác nhận thanh toán</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
<script>
function checkin(bookingId) {
    if (!confirm('Xác nhận check-in?')) return;
    fetch(`{{ url('admin/receptionist/checkin') }}/${bookingId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            Botble.showSuccess(data.message);
            setTimeout(() => location.reload(), 500);
        } else {
            Botble.showError(data.message);
        }
    })
    .catch(() => Botble.showError('Có lỗi xảy ra!'));
}

function checkout(bookingId) {
    if (!confirm('Xác nhận check-out?')) return;
    fetch(`{{ url('admin/receptionist/checkout') }}/${bookingId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            Botble.showSuccess(data.message);
            setTimeout(() => location.reload(), 500);
        } else {
            Botble.showError(data.message);
        }
    })
    .catch(() => Botble.showError('Có lỗi xảy ra!'));
}

function openPayment(bookingId, remaining) {
    document.getElementById('payment_booking_id').value = bookingId;
    document.getElementById('remaining_display').value = new Intl.NumberFormat('vi-VN').format(remaining) + ' đ';
    document.getElementById('payment_amount').value = remaining;
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function submitPayment() {
    const bookingId = document.getElementById('payment_booking_id').value;
    const amount = document.getElementById('payment_amount').value;
    const method = document.getElementById('payment_method').value;
    
    fetch(`{{ url('admin/receptionist/payment') }}/${bookingId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount, payment_method: method })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
            Botble.showSuccess(data.message);
            setTimeout(() => location.reload(), 500);
        } else {
            Botble.showError(data.message);
        }
    })
    .catch(() => Botble.showError('Có lỗi xảy ra!'));
}
</script>
@endpush
