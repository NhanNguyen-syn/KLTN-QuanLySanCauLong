@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #eef2ff;
        --success: #10b981;
        --success-light: #d1fae5;
        --warning: #f59e0b;
        --warning-light: #fef3c7;
        --danger: #ef4444;
        --danger-light: #fee2e2;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    .revenue-dashboard {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Page Header */
    .revenue-dashboard .page-header {
        margin-bottom: 2rem;
    }
    .revenue-dashboard .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
        letter-spacing: -0.025em;
    }
    .revenue-dashboard .page-header .subtitle {
        font-size: 0.9375rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* Filter Bar */
    .revenue-dashboard .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .revenue-dashboard .filter-bar .filter-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-700);
    }
    .revenue-dashboard .filter-bar select,
    .revenue-dashboard .filter-bar input[type="date"] {
        height: 38px;
        padding: 0 12px;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        font-size: 0.875rem;
        color: var(--gray-700);
        background: white;
        transition: all 0.15s;
    }
    .revenue-dashboard .filter-bar select:focus,
    .revenue-dashboard .filter-bar input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    .revenue-dashboard .btn-primary {
        height: 38px;
        padding: 0 16px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
    }
    .revenue-dashboard .btn-primary:hover {
        background: #4338ca;
    }
    .revenue-dashboard .btn-success {
        height: 38px;
        padding: 0 16px;
        background: var(--success);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.15s;
    }
    .revenue-dashboard .btn-success:hover {
        background: #059669;
        color: white;
    }

    /* Stats Grid */
    .revenue-dashboard .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1200px) {
        .revenue-dashboard .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .revenue-dashboard .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .revenue-dashboard .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }
    .revenue-dashboard .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    .revenue-dashboard .stat-card.primary::before { background: var(--primary); }
    .revenue-dashboard .stat-card.success::before { background: var(--success); }
    .revenue-dashboard .stat-card.warning::before { background: var(--warning); }
    .revenue-dashboard .stat-card.danger::before { background: var(--danger); }

    .revenue-dashboard .stat-card .stat-label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .revenue-dashboard .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1.2;
        margin-top: 0.5rem;
        letter-spacing: -0.025em;
    }
    .revenue-dashboard .stat-card .stat-value .unit {
        font-size: 1rem;
        font-weight: 500;
        color: var(--gray-400);
        margin-left: 4px;
    }

    /* Charts Section */
    .revenue-dashboard .charts-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1024px) {
        .revenue-dashboard .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .revenue-dashboard .card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .revenue-dashboard .card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .revenue-dashboard .card-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }
    .revenue-dashboard .card-body {
        padding: 1.5rem;
    }

    /* Toggle Buttons */
    .revenue-dashboard .toggle-group {
        display: inline-flex;
        background: var(--gray-100);
        border-radius: 8px;
        padding: 3px;
    }
    .revenue-dashboard .toggle-group button {
        padding: 6px 12px;
        font-size: 0.8125rem;
        font-weight: 500;
        border: none;
        background: transparent;
        color: var(--gray-500);
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s;
    }
    .revenue-dashboard .toggle-group button.active {
        background: white;
        color: var(--gray-900);
        box-shadow: var(--shadow-sm);
    }

    /* Table */
    .revenue-dashboard .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .revenue-dashboard .data-table th {
        text-align: left;
        padding: 0.875rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
    }
    .revenue-dashboard .data-table td {
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
    }
    .revenue-dashboard .data-table tbody tr:hover {
        background: var(--gray-50);
    }
    .revenue-dashboard .data-table tbody tr:last-child td {
        border-bottom: none;
    }
    .revenue-dashboard .data-table .rank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8125rem;
    }
    .revenue-dashboard .data-table .rank-1 { background: #fef3c7; color: #b45309; }
    .revenue-dashboard .data-table .rank-2 { background: #e5e7eb; color: #4b5563; }
    .revenue-dashboard .data-table .rank-3 { background: #fed7aa; color: #c2410c; }
    .revenue-dashboard .data-table .rank-default { background: var(--gray-100); color: var(--gray-600); }

    .revenue-dashboard .data-table .court-name {
        font-weight: 600;
        color: var(--gray-900);
    }
    .revenue-dashboard .data-table .count-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 20px;
        font-size: 0.8125rem;
        font-weight: 500;
    }
    .revenue-dashboard .data-table .revenue {
        font-weight: 600;
        color: var(--success);
    }

    /* Empty State */
    .revenue-dashboard .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--gray-400);
    }
</style>

<div class="revenue-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Thống kê Doanh thu</h1>
        <p class="subtitle">Theo dõi hiệu suất kinh doanh sân cầu lông</p>
    </div>

    <!-- Filter Bar -->
    <form id="filter-form" class="filter-bar">
        <span class="filter-label">Thời gian:</span>
        <select name="range" id="range-select">
            @foreach($dateRanges as $key => $rangeData)
                <option value="{{ $key }}" 
                    data-start="{{ $rangeData['start'] }}" 
                    data-end="{{ $rangeData['end'] }}"
                    {{ $range === $key ? 'selected' : '' }}>
                    {{ $rangeData['label'] }}
                </option>
            @endforeach
            <option value="custom" {{ $range === 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
        </select>
        <div class="custom-date-inputs" style="{{ $range !== 'custom' ? 'display:none' : 'display:flex;gap:0.5rem;align-items:center;' }}">
            <span class="filter-label">Từ:</span>
            <input type="date" name="start_date" id="start-date" value="{{ $startDate }}">
            <span class="filter-label">Đến:</span>
            <input type="date" name="end_date" id="end-date" value="{{ $endDate }}">
        </div>
        <button type="submit" class="btn-primary">Lọc dữ liệu</button>
        <a href="{{ route('revenue-statistics.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
           class="btn-success" id="export-btn">Xuất báo cáo</a>
    </form>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-label">Tổng doanh thu</div>
            <div class="stat-value">{{ number_format($summary['total_revenue']) }}<span class="unit">đ</span></div>
        </div>
        <div class="stat-card success">
            <div class="stat-label">Đơn hoàn thành</div>
            <div class="stat-value">{{ $summary['confirmed_bookings'] }}<span class="unit">đơn</span></div>
        </div>
        <div class="stat-card danger">
            <div class="stat-label">Đơn đã hủy</div>
            <div class="stat-value">{{ $summary['cancelled_bookings'] }}<span class="unit">đơn</span></div>
        </div>
        <div class="stat-card warning">
            <div class="stat-label">Tỷ lệ hoàn thành</div>
            <div class="stat-value">{{ $summary['confirmation_rate'] }}<span class="unit">%</span></div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="charts-grid">
        <div class="card">
            <div class="card-header">
                <h3>Doanh thu theo thời gian</h3>
                <div class="toggle-group">
                    <button type="button" class="active" data-chart-type="daily">Ngày</button>
                    <button type="button" data-chart-type="monthly">Tháng</button>
                </div>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="revenue-chart"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Phân bổ theo sân</h3>
            </div>
            <div class="card-body" style="height: 300px;">
                @if($revenueByCourt->count() > 0)
                    <canvas id="court-chart"></canvas>
                @else
                    <div class="empty-state">Chưa có dữ liệu</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Courts -->
    <div class="card">
        <div class="card-header">
            <h3>Top sân được đặt nhiều nhất</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Hạng</th>
                    <th>Tên sân</th>
                    <th style="width: 150px; text-align: center;">Số lượt đặt</th>
                    <th style="width: 180px; text-align: right;">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCourts as $index => $court)
                <tr>
                    <td>
                        <span class="rank {{ $index === 0 ? 'rank-1' : ($index === 1 ? 'rank-2' : ($index === 2 ? 'rank-3' : 'rank-default')) }}">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td class="court-name">{{ $court->court_name }}</td>
                    <td style="text-align: center;">
                        <span class="count-badge">{{ $court->booking_count }} lượt</span>
                    </td>
                    <td style="text-align: right;" class="revenue">{{ number_format($court->total_revenue) }} đ</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">Chưa có dữ liệu</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartDataUrl = '{{ route("revenue-statistics.chart-data") }}';
    let revenueChart = null;
    let courtChart = null;
    
    initCharts();
    
    document.getElementById('range-select').addEventListener('change', function() {
        const customInputs = document.querySelector('.custom-date-inputs');
        if (this.value === 'custom') {
            customInputs.style.display = 'flex';
        } else {
            customInputs.style.display = 'none';
            const option = this.options[this.selectedIndex];
            document.getElementById('start-date').value = option.dataset.start;
            document.getElementById('end-date').value = option.dataset.end;
        }
    });
    
    document.querySelectorAll('.toggle-group button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.toggle-group button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadChartData(this.dataset.chartType);
        });
    });
    
    document.getElementById('filter-form').addEventListener('submit', function() {
        const exportBtn = document.getElementById('export-btn');
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        exportBtn.href = '{{ route("revenue-statistics.export") }}?start_date=' + startDate + '&end_date=' + endDate;
    });
    
    function initCharts() {
        const revenueCtx = document.getElementById('revenue-chart');
        if (revenueCtx) {
            revenueChart = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Doanh thu',
                        data: [],
                        backgroundColor: '#4f46e5',
                        borderRadius: 6,
                        barThickness: 24,
                        yAxisID: 'y'
                    }, {
                        label: 'Số đơn',
                        data: [],
                        type: 'line',
                        borderColor: '#f59e0b',
                        backgroundColor: '#fef3c7',
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: '#f59e0b',
                        tension: 0.4,
                        fill: false,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: { boxWidth: 8, usePointStyle: true, padding: 20 }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#fff',
                            bodyColor: '#e5e7eb',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: ctx => ctx.datasetIndex === 0 
                                    ? 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(ctx.parsed.y) + ' đ'
                                    : 'Số đơn: ' + ctx.parsed.y
                            }
                        }
                    },
                    scales: {
                        y: {
                            position: 'left',
                            beginAtZero: true,
                            grid: { color: '#f3f4f6' },
                            border: { display: false },
                            ticks: {
                                color: '#9ca3af',
                                callback: v => v >= 1000000 ? (v/1000000).toFixed(0) + 'M' : v >= 1000 ? (v/1000).toFixed(0) + 'K' : v
                            }
                        },
                        y1: { position: 'right', beginAtZero: true, grid: { display: false }, border: { display: false }, ticks: { color: '#9ca3af' } },
                        x: { grid: { display: false }, border: { display: false }, ticks: { color: '#9ca3af' } }
                    }
                }
            });
        }
        
        const courtCtx = document.getElementById('court-chart');
        if (courtCtx) {
            const courtData = @json($revenueByCourt);
            if (courtData && courtData.length > 0) {
                courtChart = new Chart(courtCtx, {
                    type: 'doughnut',
                    data: {
                        labels: courtData.map(c => c.court_name),
                        datasets: [{
                            data: courtData.map(c => c.total_revenue),
                            backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
                            borderWidth: 0,
                            spacing: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 16, usePointStyle: true, pointStyle: 'circle' }
                            },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: { label: ctx => ctx.label + ': ' + new Intl.NumberFormat('vi-VN').format(ctx.parsed) + ' đ' }
                            }
                        }
                    }
                });
            }
        }
        
        loadChartData('daily');
    }
    
    function loadChartData(chartType) {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        
        fetch(`${chartDataUrl}?chart_type=${chartType}&start_date=${startDate}&end_date=${endDate}&year={{ date('Y') }}`)
            .then(r => r.json())
            .then(data => {
                if (data.success && revenueChart) {
                    revenueChart.data.labels = data.data.labels;
                    revenueChart.data.datasets[0].data = data.data.revenues;
                    revenueChart.data.datasets[1].data = data.data.bookings;
                    revenueChart.update('none');
                }
            })
            .catch(console.error);
    }
});
</script>
@endpush