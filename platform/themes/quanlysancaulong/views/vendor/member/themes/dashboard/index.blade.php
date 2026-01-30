@extends('plugins/member::themes.dashboard.layouts.master')

@section('content')
<style>
    /* ===== DASHBOARD STYLES ===== */
    :root {
        --primary-color: #059669;
        --primary-dark: #047857;
        --primary-light: #10b981;
        --bg-light: #f0fdfa;
    }

    .dashboard-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Welcome Card */
    .welcome-card {
        background: white;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .welcome-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .welcome-info h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 4px 0;
    }

    .welcome-info p {
        color: #6b7280;
        margin: 0;
        font-size: 15px;
    }

    .welcome-info .member-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--bg-light);
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 10px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 14px;
    }

    .stat-card .stat-icon.primary {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-card .stat-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-card .stat-icon.orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .stat-card .stat-icon.purple {
        background: #faf5ff;
        color: #9333ea;
    }

    .stat-card .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .stat-card .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
    }

    .quick-actions h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 18px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .quick-action-btn.primary {
        background: var(--primary-color);
        color: white;
    }

    .quick-action-btn.primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .quick-action-btn.outline {
        background: white;
        color: #374151;
        border-color: #e5e7eb;
    }

    .quick-action-btn.outline:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: var(--bg-light);
    }

    .quick-action-btn i {
        font-size: 20px;
    }

    /* Bookings Table */
    .bookings-section {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
    }

    .bookings-section h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 18px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .bookings-table {
        width: 100%;
        border-collapse: collapse;
    }

    .bookings-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .bookings-table td {
        padding: 16px;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
    }

    .bookings-table tr:hover {
        background: #f9fafb;
    }

    .booking-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .booking-status.confirmed {
        background: #ecfdf5;
        color: #059669;
    }

    .booking-status.pending {
        background: #fffbeb;
        color: #d97706;
    }

    .booking-status.cancelled {
        background: #fef2f2;
        color: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .empty-state p {
        margin: 0 0 16px 0;
        font-size: 15px;
    }

    .empty-state a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--primary-color);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: background 0.2s ease;
    }

    .empty-state a:hover {
        background: var(--primary-dark);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-card {
            flex-direction: column;
            text-align: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <div class="welcome-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="welcome-info">
            <h2>Xin chào, {{ $user->first_name ?: $user->name }}!</h2>
            <p>Chào mừng bạn quay lại. Hãy đặt sân và tận hưởng trận cầu lống tuyệt vời!</p>
            <div class="member-badge">
                <i class="ti ti-award"></i>
                Thành viên từ {{ $user->created_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Statistics -->
    @php
        $totalBookings = 0;
        $upcomingBookings = 0;
        $completedBookings = 0;
        $memberDays = $user->created_at->diffInDays(now());

        // Try to get real booking data if available
        if (class_exists('\Botble\CourtBooking\Models\BookingList')) {
            $bookings = \Botble\CourtBooking\Models\BookingList::where('member_id', $user->id)->get();
            $totalBookings = $bookings->count();
            $upcomingBookings = $bookings->where('status', 'confirmed')
                ->where('date', '>=', now()->toDateString())
                ->count();
            $completedBookings = $bookings->where('status', 'completed')->count();
        }
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="ti ti-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-label">Tổng đặt sân</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="ti ti-calendar-event"></i>
            </div>
            <div class="stat-value">{{ $upcomingBookings }}</div>
            <div class="stat-label">Sắp diễn ra</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="ti ti-circle-check"></i>
            </div>
            <div class="stat-value">{{ $completedBookings }}</div>
            <div class="stat-label">Đã hoàn thành</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="ti ti-user-star"></i>
            </div>
            <div class="stat-value">{{ $memberDays }}</div>
            <div class="stat-label">Ngày thành viên</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>
            <i class="ti ti-bolt" style="color: var(--primary-color);"></i>
            Thao tác nhanh
        </h3>
        <div class="quick-actions-grid">
            <a href="{{ route('public.booking') }}" class="quick-action-btn primary">
                <i class="ti ti-calendar-plus"></i>
                Đặt sân ngay
            </a>
            <a href="{{ url('/tra-cuu') }}" class="quick-action-btn outline">
                <i class="ti ti-search"></i>
                Tra cứu booking
            </a>
            <a href="{{ url('/goi-thanh-vien') }}" class="quick-action-btn outline">
                <i class="ti ti-award"></i>
                Xem gói thành viên
            </a>
            <a href="{{ route('public.member.settings') }}" class="quick-action-btn outline">
                <i class="ti ti-settings"></i>
                Cài đặt tài khoản
            </a>
        </div>
    </div>

    <!-- Upcoming Bookings -->
    <div class="bookings-section" id="bookings">
        <h3>
            <i class="ti ti-calendar-time" style="color: var(--primary-color);"></i>
            Lịch đặt sân sắp tới
        </h3>

        @php
            $upcomingList = [];
            if (class_exists('\Botble\CourtBooking\Models\BookingList')) {
                $upcomingList = \Botble\CourtBooking\Models\BookingList::where('member_id', $user->id)
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date', 'asc')
                    ->take(5)
                    ->get();
            }
        @endphp

        @if(count($upcomingList) > 0)
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Mã đặt</th>
                        <th>Ngày</th>
                        <th>Khung giờ</th>
                        <th>Sân</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($upcomingList as $booking)
                        <tr>
                            <td><strong>{{ $booking->order_code ?? 'N/A' }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}</td>
                            <td>{{ $booking->time_slot ?? 'N/A' }}</td>
                            <td>{{ $booking->court->name ?? 'N/A' }}</td>
                            <td>
                                <span class="booking-status {{ $booking->status }}">
                                    @if($booking->status === 'confirmed')
                                        <i class="ti ti-check"></i> Đã xác nhận
                                    @elseif($booking->status === 'pending')
                                        <i class="ti ti-clock"></i> Chờ xác nhận
                                    @else
                                        {{ ucfirst($booking->status) }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="ti ti-calendar-off"></i>
                <p>Bạn chưa có lịch đặt sân nào sắp tới</p>
                <a href="{{ route('public.booking') }}">
                    <i class="ti ti-plus"></i>
                    Đặt sân ngay
                </a>
            </div>
        @endif
    </div>

    <!-- Activity Logs (keep original for compatibility) -->
    <div class="bookings-section">
        <h3>
            <i class="ti ti-activity" style="color: var(--primary-color);"></i>
            Hoạt động gần đây
        </h3>
        <activity-log-component></activity-log-component>
    </div>
</div>
@stop