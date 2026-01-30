@extends('plugins/member::themes.dashboard.layouts.master')

@push('header')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        /* ===== CLEAN DASHBOARD DESIGN ===== */
        :root {
            --sidebar-bg: #0f2a22;
            --sidebar-width: 240px;
            --green-dark: #1a5a45;
            --green-light: #e8f5e9;
            --accent: #1a5a45;
            --bg: #f5f5f5;
            --card-bg: #ffffff;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-muted: #999999;
            --border: #e8e8e8;
            --radius: 16px;
            --radius-sm: 12px;
        }

        * {
            font-family: 'Inter', system-ui, sans-serif !important;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg) !important;
        }

        /* ===== LAYOUT ===== */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 8px 32px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: #2d7a5e;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
        }

        .brand-name {
            color: #fff;
            font-weight: 700;
            font-size: 16px;
        }

        .sidebar-section {
            margin-bottom: 24px;
        }

        .sidebar-label {
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 12px;
            margin-bottom: 12px;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu li {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.15s;
        }

        .nav-link i {
            font-size: 20px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .nav-link.active {
            background: #2d7a5e;
            color: #fff;
        }

        .nav-link .badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 28px 40px;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #1e6b52;
            color: #fff;
        }

        .btn-outline {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            color: var(--text-primary);
            padding: 12px 20px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-outline:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
        }

        .user-email {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ===== STATS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            position: relative;
        }

        .stat-card.highlight {
            background: var(--accent);
            color: #fff;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .stat-card.highlight .stat-title {
            color: rgba(255, 255, 255, 0.8);
        }

        .stat-arrow {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--text-secondary);
        }

        .stat-card.highlight .stat-arrow {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .stat-card.highlight .stat-value {
            color: #fff;
        }

        .stat-change {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #22c55e;
        }

        .stat-card.highlight .stat-change {
            color: rgba(255, 255, 255, 0.8);
        }

        /* ===== CONTENT GRID ===== */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-action {
            font-size: 13px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .card-body {
            padding: 20px;
        }

        /* Quick Booking Card */
        .quick-book-card {
            background: var(--green-dark);
            grid-column: span 2;
        }

        .quick-book-card .card-header {
            padding: 24px 24px 0;
        }

        .quick-book-card .card-title {
            color: #fff;
        }

        .quick-book-card .card-body {
            padding: 24px;
        }

        .court-slots {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .court-slot {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .court-slot:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .court-slot .time {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
        }

        .court-slot .court {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-book {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: #f97316;
            color: #fff;
            padding: 16px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-book:hover {
            background: #ea580c;
            color: #fff;
        }

        /* Activity Card */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--green-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 18px;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .activity-time {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 32px 16px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.4;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Upcoming Bookings */
        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .booking-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px;
            background: var(--bg);
            border-radius: 10px;
            transition: all 0.2s;
        }

        .booking-item:hover {
            background: var(--green-light);
        }

        .booking-date {
            width: 48px;
            height: 48px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .booking-date .day {
            font-size: 18px;
            font-weight: 700;
            line-height: 1;
        }

        .booking-date .month {
            font-size: 10px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .booking-info {
            flex: 1;
        }

        .booking-court {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .booking-time {
            font-size: 13px;
            color: var(--text-muted);
        }

        .booking-status {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 500;
        }

        .booking-status.confirmed {
            background: #dcfce7;
            color: #16a34a;
        }

        .booking-status.pending {
            background: #fef3c7;
            color: #d97706;
        }

        /* Hide system elements */
        .header--mobile,
        .ps-drawer--mobile,
        .ps-site-overlay,
        .ps-block--user-wellcome,
        .ps-block--earning-count {
            display: none !important;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid {
                grid-template-columns: 1fr 1fr;
            }

            .quick-book-card {
                grid-column: span 1;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .stats-grid,
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('body')
<div class="dashboard">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="ti ti-ball-tennis"></i>
            </div>
            <div class="brand-name">Badminton Court</div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Menu</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('public.member.dashboard') }}" class="nav-link active">
                        <i class="ti ti-layout-dashboard"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/dat-san') }}" class="nav-link">
                        <i class="ti ti-calendar-plus"></i>
                        Đặt Sân
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tra-cuu') }}" class="nav-link">
                        <i class="ti ti-history"></i>
                        Lịch Sử
                        <span class="badge">2+</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">General</div>
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('public.member.settings') }}" class="nav-link">
                        <i class="ti ti-settings"></i>
                        Cài Đặt
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.member.logout') }}" class="nav-link">
                        <i class="ti ti-logout"></i>
                        Đăng Xuất
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <!-- Header -->
        <header class="page-header">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Quản lý lịch đặt sân và hoạt động của bạn</p>
            </div>
            <div class="header-actions">
                <a href="{{ url('/dat-san') }}" class="btn-primary">
                    <i class="ti ti-plus"></i>
                    Đặt Sân Mới
                </a>
                <div class="user-info">
                    <img src="{{ auth('member')->user()->avatar_url }}" alt="Avatar" class="user-avatar">
                    <div>
                        <div class="user-name">{{ auth('member')->user()->name }}</div>
                        <div class="user-email">{{ auth('member')->user()->email }}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats -->
        @php
            $memberHours = auth('member')->user()->created_at->diffInHours(now());
            $memberDays = round($memberHours / 24, 1);
        @endphp
        <div class="stats-grid">
            <div class="stat-card highlight">
                <div class="stat-header">
                    <div class="stat-title">Tổng Lượt Đặt</div>
                    <div class="stat-arrow"><i class="ti ti-arrow-up-right"></i></div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-change">
                    <i class="ti ti-trending-up"></i>
                    Tăng từ tháng trước
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Đã Hoàn Thành</div>
                    <div class="stat-arrow"><i class="ti ti-arrow-up-right"></i></div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-change">
                    <i class="ti ti-trending-up"></i>
                    Tăng từ tháng trước
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Sắp Diễn Ra</div>
                    <div class="stat-arrow"><i class="ti ti-arrow-up-right"></i></div>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-change">
                    <i class="ti ti-trending-up"></i>
                    Tăng từ tháng trước
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Ngày Hội Viên</div>
                    <div class="stat-arrow"><i class="ti ti-arrow-up-right"></i></div>
                </div>
                <div class="stat-value">{{ $memberDays }}</div>
                <div class="stat-change">
                    <i class="ti ti-user-check"></i>
                    Thành viên tích cực
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Quick Booking -->
            <div class="card quick-book-card">
                <div class="card-header">
                    <h3 class="card-title">Đặt Sân Nhanh</h3>
                </div>
                <div class="card-body">
                    <div class="court-slots">
                        <div class="court-slot">
                            <div class="time">08:00 - 09:00</div>
                            <div class="court">Sân 01</div>
                        </div>
                        <div class="court-slot">
                            <div class="time">09:00 - 10:00</div>
                            <div class="court">Sân 02</div>
                        </div>
                        <div class="court-slot">
                            <div class="time">10:00 - 11:00</div>
                            <div class="court">Sân 03</div>
                        </div>
                    </div>
                    <a href="{{ url('/dat-san') }}" class="btn-book">
                        <i class="ti ti-calendar-plus"></i>
                        Xem Tất Cả Sân Trống
                    </a>
                </div>
            </div>

            <!-- Activity -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hoạt Động Gần Đây</h3>
                    <a href="#" class="card-action">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="empty-state">
                        <i class="ti ti-activity"></i>
                        <p>Chưa có hoạt động nào</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Bookings -->
            <div class="card" style="grid-column: span 2;">
                <div class="card-header">
                    <h3 class="card-title">Lịch Đặt Sắp Tới</h3>
                    <a href="{{ url('/tra-cuu') }}" class="card-action">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="empty-state">
                        <i class="ti ti-calendar-off"></i>
                        <p>Chưa có lịch đặt sân nào</p>
                    </div>
                </div>
            </div>

            <!-- Favorites -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sân Yêu Thích</h3>
                </div>
                <div class="card-body">
                    <div class="empty-state">
                        <i class="ti ti-heart"></i>
                        <p>Chưa có sân yêu thích</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@stop

@section('content')
@stop