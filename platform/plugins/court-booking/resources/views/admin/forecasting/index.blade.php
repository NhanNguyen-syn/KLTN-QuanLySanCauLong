@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row g-3">
        {{-- AI Insights Cards --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-bulb me-2"></i>AI Insights
                    </h3>
                    <div class="ms-auto">
                        <button class="btn btn-primary btn-sm" onclick="regenerateForecast()">
                            <i class="ti ti-refresh me-1"></i>Regenerate
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    @forelse($insights as $insight)
                        <div
                            class="alert alert-{{ $insight->priority === 'high' ? 'danger' : ($insight->priority === 'medium' ? 'warning' : 'info') }} mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $insight->title }}</strong>
                                    <p class="mb-0 mt-1">{{ $insight->description }}</p>
                                    <small class="text-muted">{{ $insight->created_at->diffForHumans() }}</small>
                                </div>
                                <button class="btn btn-sm btn-ghost-secondary" onclick="markAsRead({{ $insight->id }})">
                                    <i class="ti ti-check"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">Không có insights mới</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Forecast Accuracy</div>
                        <div class="ms-auto lh-1">
                            <div class="dropdown">
                                <span class="text-{{ $accuracy >= 70 ? 'success' : 'warning' }}">
                                    <i class="ti ti-trending-{{ $accuracy >= 70 ? 'up' : 'down' }}"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="h1 mb-3">{{ $accuracy }}%</div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-{{ $accuracy >= 70 ? 'success' : 'warning' }}"
                            style="width: {{ $accuracy }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Giờ cao điểm (Top 5)</h4>
                </div>
                <div class="card-body">
                    <canvas id="peakHoursChart" height="80"></canvas>
                </div>
            </div>
        </div>

        {{-- Weekly Trend --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dự báo 7 ngày tới</h4>
                </div>
                <div class="card-body">
                    <canvas id="weeklyTrendChart" height="60"></canvas>
                </div>
            </div>
        </div>

        {{-- Demand Heatmap --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Heatmap nhu cầu (Giờ x Ngày)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Giờ / Ngày</th>
                                    @foreach($heatmap as $day => $hours)
                                        <th>{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @for($hour = 6; $hour <= 22; $hour++)
                                    <tr>
                                        <td><strong>{{ $hour }}:00</strong></td>
                                        @foreach($heatmap as $day => $hours)
                                            @php
                                                $value = $hours[$hour] ?? 0;
                                                $bgClass = $value >= 5 ? 'bg-danger-lt' : ($value >= 3 ? 'bg-warning-lt' : 'bg-success-lt');
                                            @endphp
                                            <td class="{{ $bgClass }}">{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        // Peak Hours Chart
        const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
        new Chart(peakHoursCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($peakHours)) !!}.map(h => h + ':00'),
                datasets: [{
                    label: 'Dự kiến bookings',
                    data: {!! json_encode(array_values($peakHours)) !!},
                    backgroundColor: 'rgba(26, 90, 69, 0.8)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Weekly Trend Chart
        const weeklyCtx = document.getElementById('weeklyTrendChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($weeklyTrend)) !!},
                datasets: [{
                    label: 'Dự báo bookings',
                    data: {!! json_encode(array_values($weeklyTrend)) !!},
                    borderColor: 'rgb(26, 90, 69)',
                    backgroundColor: 'rgba(26, 90, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        async function markAsRead(id) {
            try {
                const response = await fetch(`{{ url('admin/forecasting/insight') }}/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                if (response.ok) {
                    event.target.closest('.alert').remove();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function regenerateForecast() {
            if (!confirm('Regenerate all forecasts and insights?')) return;

            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>Processing...';

            try {
                const response = await fetch('{{ route('forecasting.regenerate') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (response.ok && data.error === false) {
                    // Botble toast notification
                    if (typeof Botble !== 'undefined' && Botble.showSuccess) {
                        Botble.showSuccess(data.message || 'Regenerated successfully!');
                    }
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error toast
                    if (typeof Botble !== 'undefined' && Botble.showError) {
                        Botble.showError(data.message || 'Error regenerating forecasts');
                    } else {
                        alert(data.message || 'Error regenerating forecasts');
                    }
                    
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ti ti-refresh me-1"></i>Regenerate';
                }
            } catch (error) {
                if (typeof Botble !== 'undefined' && Botble.showError) {
                    Botble.showError('Error: ' + error.message);
                } else {
                    alert('Error: ' + error.message);
                }
                
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-refresh me-1"></i>Regenerate';
            }
        }
    </script>
@endsection