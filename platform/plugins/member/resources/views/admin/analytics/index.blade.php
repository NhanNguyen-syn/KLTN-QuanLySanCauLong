@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row g-3">
        {{-- Stats Overview --}}
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="ti ti-chart-pie me-2"></i>Customer Segmentation Overview
                    </h3>
                    <div class="ms-auto">
                        <button class="btn btn-primary" onclick="recalculateSegments()">
                            <i class="ti ti-refresh me-1"></i>Recalculate All
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach(['VIP' => 'success', 'Regular' => 'primary', 'At-Risk' => 'warning', 'New' => 'info', 'Churned' => 'danger'] as $segment => $color)
                            <div class="col-md-2">
                                <div class="card bg-{{ $color }}-lt">
                                    <div class="card-body text-center">
                                        <h3 class="mb-1">{{ $stats[$segment] ?? 0 }}</h3>
                                        <div class="text-muted">{{ $segment }}</div>
                                        <a href="{{ route('customer-analytics.segment', $segment) }}"
                                            class="btn btn-sm btn-{{ $color }} mt-2">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">VIP Customers</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">High-value customers requiring premium attention</p>
                    <a href="{{ route('customer-analytics.segment', 'VIP') }}" class="btn btn-success">
                        View VIP List <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">At-Risk Customers</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Customers showing signs of churn - need re-engagement</p>
                    <a href="{{ route('customer-analytics.segment', 'At-Risk') }}" class="btn btn-warning">
                        View At-Risk List <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function recalculateSegments() {
            if (!confirm('This will recalculate segments for all customers. Continue?')) return;

            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>Processing...';

            try {
                const response = await fetch('{{ route("customer-analytics.recalculate") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (data.error === false) {
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ti ti-refresh me-1"></i>Recalculate All';
                }
            } catch (error) {
                alert('Error: ' + error.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-refresh me-1"></i>Recalculate All';
            }
        }
    </script>
@endsection