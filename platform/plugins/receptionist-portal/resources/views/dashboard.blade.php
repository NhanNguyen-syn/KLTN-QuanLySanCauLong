@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<style>
    .receptionist-dashboard {
        max-width: 1600px;
        margin: 0 auto;
    }
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1024px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .stats-row { grid-template-columns: 1fr; }
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }
    .stat-card .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
    }
    .stat-card.primary .stat-icon { background: #eef2ff; color: #4f46e5; }
    .stat-card.success .stat-icon { background: #d1fae5; color: #10b981; }
    .stat-card.warning .stat-icon { background: #fef3c7; color: #f59e0b; }
    .stat-card.info .stat-icon { background: #dbeafe; color: #3b82f6; }
    
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 1024px) {
        .content-grid { grid-template-columns: 1fr; }
    }
    
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-header h3 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }
    .card-body { padding: 1rem; }
    
    .booking-item {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .booking-item:last-child { border-bottom: none; }
    .booking-item:hover { background: #f9fafb; }
    .booking-info h4 {
        font-size: 0.9375rem;
        font-weight: 600;
        margin: 0 0 0.25rem;
    }
    .booking-info .meta {
        font-size: 0.8125rem;
        color: #6b7280;
    }
    .booking-actions {
        display: flex;
        gap: 0.5rem;
    }
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.8125rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
    }
    .btn-checkin { background: #10b981; color: white; }
    .btn-checkin:hover { background: #059669; }
    .btn-payment { background: #4f46e5; color: white; }
    .btn-payment:hover { background: #4338ca; }
    .btn-checkout { background: #f59e0b; color: white; }
    .btn-checkout:hover { background: #d97706; }
    
    .status-badge {
        display: inline-flex;
        padding: 0.25rem 0.625rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-pending { background: #fef3c7; color: #b45309; }
    .status-confirmed { background: #dbeafe; color: #1d4ed8; }
    .status-paid { background: #d1fae5; color: #047857; }
    .status-completed { background: #e5e7eb; color: #374151; }
    
    .upcoming-list { max-height: 400px; overflow-y: auto; }
    .pending-list { max-height: 300px; overflow-y: auto; }
    
    .quick-actions {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .quick-btn {
        flex: 1;
        padding: 1rem;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        background: white;
        cursor: pointer;
        text-align: center;
        transition: all 0.15s;
        text-decoration: none;
        color: inherit;
    }
    .quick-btn:hover {
        border-color: #4f46e5;
        background: #eef2ff;
    }
    .quick-btn i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        display: block;
        color: #4f46e5;
    }
    .quick-btn span {
        font-weight: 500;
        font-size: 0.875rem;
    }
</style>

<div class="receptionist-dashboard">
    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('receptionist.quick-booking') }}" class="quick-btn">
            <i class="ti ti-calendar-plus"></i>
            <span>Đặt sân nhanh</span>
        </a>
        <a href="{{ route('booking-list.index') }}" class="quick-btn">
            <i class="ti ti-list"></i>
            <span>Xem tất cả đơn</span>
        </a>
        <a href="{{ route('receptionist.vip.index') }}" class="quick-btn">
            <i class="ti ti-star"></i>
            <span>Khách VIP</span>
        </a>
        <a href="{{ route('services.index') }}" class="quick-btn">
            <i class="ti ti-bottle"></i>
            <span>Dịch vụ</span>
        </a>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="ti ti-calendar"></i></div>
            <div class="stat-value">{{ $stats['total_today'] }}</div>
            <div class="stat-label">Đơn hôm nay</div>
        </div>
        <div class="stat-card success">
            <div class="stat-icon"><i class="ti ti-check"></i></div>
            <div class="stat-value">{{ $stats['checked_in'] }}</div>
            <div class="stat-label">Đã hoàn thành</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon"><i class="ti ti-clock"></i></div>
            <div class="stat-value">{{ $stats['waiting_checkin'] }}</div>
            <div class="stat-label">Chờ check-in</div>
        </div>
        <div class="stat-card info">
            <div class="stat-icon"><i class="ti ti-cash"></i></div>
            <div class="stat-value">{{ number_format($stats['revenue_today'] / 1000000, 1) }}M</div>
            <div class="stat-label">Doanh thu hôm nay</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Today's Bookings -->
        <div class="card">
            <div class="card-header">
                <h3>Lịch hôm nay ({{ Carbon\Carbon::today()->format('d/m/Y') }})</h3>
                <span class="text-muted">{{ $todayBookings->count() }} đơn</span>
            </div>
            <div class="card-body upcoming-list">
                @forelse($todayBookings as $booking)
                <div class="booking-item" data-id="{{ $booking->id }}">
                    <div class="booking-info">
                        <h4>{{ $booking->court_name }} - {{ $booking->start_time }} → {{ $booking->end_time }}</h4>
                        <div class="meta">
                            <span>{{ $booking->customer_name }}</span>
                            <span>• {{ $booking->contact }}</span>
                            <span>• {{ number_format($booking->grand_total) }}đ</span>
                            @if($booking->paid_amount < $booking->grand_total)
                            <span class="text-danger">• Còn {{ number_format($booking->remaining_amount) }}đ</span>
                            @endif
                        </div>
                    </div>
                    <div class="booking-actions">
                        <span class="status-badge status-{{ $booking->status }}">
                            @switch($booking->status)
                                @case('pending') Chờ TT @break
                                @case('confirmed') Đã xác nhận @break
                                @case('paid') Đã TT @break
                                @case('completed') Hoàn thành @break
                                @default {{ $booking->status }}
                            @endswitch
                        </span>
                        @if($booking->status === 'pending' || $booking->status === 'confirmed')
                        <button class="btn-sm btn-checkin" onclick="checkin({{ $booking->id }})">Check-in</button>
                        @endif
                        @if($booking->remaining_amount > 0)
                        <button class="btn-sm btn-payment" onclick="openPayment({{ $booking->id }}, {{ $booking->remaining_amount }})">Thanh toán</button>
                        @endif
                        @if($booking->isFullyPaid() && $booking->status !== 'completed')
                        <button class="btn-sm btn-checkout" onclick="checkout({{ $booking->id }})">Check-out</button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">Chưa có đơn nào hôm nay</div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Pending Payments -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Chờ thanh toán</h3>
                    <span class="badge bg-warning text-dark">{{ $pendingPayments->count() }}</span>
                </div>
                <div class="card-body pending-list">
                    @forelse($pendingPayments as $booking)
                    <div class="booking-item">
                        <div class="booking-info">
                            <h4>{{ $booking->court_name }}</h4>
                            <div class="meta">
                                {{ $booking->customer_name }} • {{ number_format($booking->remaining_amount) }}đ
                            </div>
                        </div>
                        <button class="btn-sm btn-payment" onclick="openPayment({{ $booking->id }}, {{ $booking->remaining_amount }})">TT</button>
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted">Không có đơn chờ</div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming -->
            <div class="card">
                <div class="card-header">
                    <h3>Sắp đến giờ (2h tới)</h3>
                </div>
                <div class="card-body">
                    @forelse($upcomingBookings as $booking)
                    <div class="booking-item">
                        <div class="booking-info">
                            <h4>{{ $booking->start_time }} - {{ $booking->court_name }}</h4>
                            <div class="meta">{{ $booking->customer_name }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted">Không có</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thanh toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <input type="hidden" id="payment_booking_id">
                    <div class="mb-3">
                        <label class="form-label">Số tiền còn lại</label>
                        <input type="text" id="remaining_display" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số tiền thanh toán</label>
                        <input type="number" id="payment_amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phương thức</label>
                        <select id="payment_method" class="form-select" required>
                            <option value="cash">Tiền mặt</option>
                            <option value="transfer">Chuyển khoản</option>
                            <option value="card">Thẻ</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="submitPayment()">Xác nhận</button>
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
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    });
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
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    });
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
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    });
}
</script>
@endpush
