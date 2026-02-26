@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row g-3">
        {{-- AI Business Advisor Card --}}
        <div class="col-12 mb-3">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="ti ti-robot me-2"></i>Cố Vấn Kinh Doanh AI
                    </h3>
                    <button class="btn btn-light btn-sm" id="btn-ask-ai" onclick="generateAiAdvice()">
                        <i class="ti ti-wand me-1"></i>Phân Tích Dữ Liệu Ngay
                    </button>
                </div>
                <div class="card-body">
                    <div id="ai-advice-container">
                        <div class="text-center text-muted py-4" id="ai-empty-state">
                            <i class="ti ti-chart-dots" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="mt-2">Nhấn nút "Phân Tích Dữ Liệu Ngay" để AI đọc các số liệu hiện tại và đưa ra lời khuyên kinh doanh cho bạn.</p>
                        </div>
                        
                        <div class="text-center py-4 d-none" id="ai-loading-state">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0 text-primary">AI đang đọc dữ liệu và suy nghĩ chiến lược...</p>
                        </div>

                        <div id="ai-result-content" class="d-none">
                            <div class="alert alert-info">
                                <h4 class="alert-title"><i class="ti ti-bulb me-2"></i>Lời khuyên từ AI:</h4>
                                <div id="ai-response-text" class="text-dark" style="line-height: 1.6; font-size: 15px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- AI Insights Cards --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-bulb me-2"></i>Phân tích & Nhận định AI
                    </h3>
                    <div class="ms-auto">
                        <button class="btn btn-primary btn-sm" onclick="regenerateForecast()">
                            <i class="ti ti-refresh me-1"></i>Tạo lại dự báo
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
                        <div class="subheader">ĐỘ CHÍNH XÁC DỰ BÁO</div>
                        <div class="ms-auto lh-1">
                            <span class="text-{{ $accuracy >= 70 ? 'success' : ($accuracy >= 40 ? 'warning' : 'muted') }}">
                                <i class="ti ti-trending-{{ $accuracy >= 50 ? 'up' : 'down' }}"></i>
                            </span>
                        </div>
                    </div>
                    <div class="h1 mb-1">{{ $accuracy }}%</div>
                    <div class="progress progress-sm mb-2">
                        <div class="progress-bar bg-{{ $accuracy >= 70 ? 'success' : ($accuracy >= 40 ? 'warning' : 'danger') }}"
                            style="width: {{ max($accuracy, 3) }}%"></div>
                    </div>
                    <small class="text-muted">
                        @if($accuracy == 0)
                            Chưa đủ dữ liệu. Bấm "Tạo lại dự báo" để tính toán.
                        @elseif($accuracy < 50)
                            Hệ thống đang học từ dữ liệu. Càng nhiều lượt đặt, độ chính xác càng cao.
                        @elseif($accuracy < 70)
                            Độ chính xác khá. Sẽ cải thiện khi có thêm dữ liệu lịch sử.
                        @else
                            Dự báo đáng tin cậy dựa trên dữ liệu lịch sử.
                        @endif
                    </small>
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

    {{-- Regenerate Confirmation Modal --}}
    <div class="modal modal-blur fade" id="regenerateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-warning"></div>
                <div class="modal-body text-center py-4">
                    <i class="ti ti-refresh" style="font-size: 3rem; color: var(--tblr-warning);"></i>
                    <h3 class="mt-3">Tạo lại dữ liệu dự báo?</h3>
                    <div class="text-muted">
                        Hệ thống sẽ phân tích lại toàn bộ dữ liệu đặt sân lịch sử, tạo dự báo mới cho 7 ngày tới và cập nhật các thông tin insights.
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <button class="btn w-100" data-bs-dismiss="modal">Hủy bỏ</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-warning w-100" id="btn-confirm-regenerate">
                                    <i class="ti ti-refresh me-1"></i>Tạo lại dự báo
                                </button>
                            </div>
                        </div>
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

        function regenerateForecast() {
            const modal = new bootstrap.Modal(document.getElementById('regenerateModal'));
            modal.show();
        }

        // Attach click handler to the modal confirm button
        document.getElementById('btn-confirm-regenerate').addEventListener('click', async function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('regenerateModal'));
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>Đang xử lý...';

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
                    const accuracy = data.data?.accuracy ?? 0;
                    
                    // Update modal to show success result
                    const modalBody = document.querySelector('#regenerateModal .modal-body');
                    modalBody.innerHTML = `
                        <i class="ti ti-circle-check" style="font-size: 3rem; color: var(--tblr-success);"></i>
                        <h3 class="mt-3">Hoàn tất!</h3>
                        <div class="text-muted mb-3">${data.message}</div>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <span class="badge fs-4 px-4 py-2" style="background: ${accuracy >= 70 ? '#2fb344' : (accuracy >= 40 ? '#f76707' : '#d63939')}; color: #fff;">
                                <i class="ti ti-chart-line me-1"></i>Độ chính xác: ${accuracy}%
                            </span>
                        </div>
                    `;
                    document.querySelector('#regenerateModal .modal-status').className = 'modal-status bg-success';
                    document.querySelector('#regenerateModal .modal-footer').innerHTML = `
                        <div class="w-100">
                            <button class="btn btn-success w-100" onclick="window.location.reload()">
                                <i class="ti ti-check me-1"></i>Đã hiểu, tải lại trang
                            </button>
                        </div>
                    `;

                    // Botble toast notification
                    if (typeof Botble !== 'undefined' && Botble.showSuccess) {
                        Botble.showSuccess(data.message);
                    }
                } else {
                    // Show error toast
                    if (typeof Botble !== 'undefined' && Botble.showError) {
                        Botble.showError(data.message || 'Lỗi khi tạo lại dự báo');
                    } else {
                        alert(data.message || 'Lỗi khi tạo lại dự báo');
                    }
                    
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ti ti-refresh me-1"></i>Tạo lại dự báo';
                }
            } catch (error) {
                if (typeof Botble !== 'undefined' && Botble.showError) {
                    Botble.showError('Lỗi: ' + error.message);
                } else {
                    alert('Lỗi: ' + error.message);
                }
                
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-refresh me-1"></i>Tạo lại dự báo';
                modal.hide();
            }
        });
        async function generateAiAdvice() {
            const btn = document.getElementById('btn-ask-ai');
            const emptyState = document.getElementById('ai-empty-state');
            const loadingState = document.getElementById('ai-loading-state');
            const resultContent = document.getElementById('ai-result-content');
            const responseText = document.getElementById('ai-response-text');

            btn.disabled = true;
            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>Đang hỏi AI...';
            
            if (emptyState) emptyState.classList.add('d-none');
            resultContent.classList.add('d-none');
            loadingState.classList.remove('d-none');

            try {
                const response = await fetch('{{ route('forecasting.ai-advice') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();
                
                loadingState.classList.add('d-none');

                if (response.ok && data.error === false) {
                    responseText.innerHTML = data.data;
                    resultContent.classList.remove('d-none');
                } else {
                    responseText.innerHTML = '<span class="text-danger"><i class="ti ti-alert-triangle me-1"></i>' + (data.message || 'Có lỗi xảy ra khi gọi AI.') + '</span>';
                    resultContent.classList.remove('d-none');
                    if (typeof Botble !== 'undefined' && Botble.showError) {
                        Botble.showError(data.message || 'Error communicating with AI');
                    }
                }
            } catch (error) {
                loadingState.classList.add('d-none');
                responseText.innerHTML = '<span class="text-danger"><i class="ti ti-alert-triangle me-1"></i>Lỗi kết nối: ' + error.message + '</span>';
                resultContent.classList.remove('d-none');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-wand me-1"></i>Phân Tích Dữ Liệu Lại';
            }
        }
    </script>
@endsection