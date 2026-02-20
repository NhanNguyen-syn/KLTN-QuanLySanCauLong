@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="ti ti-users me-2"></i>{{ ucfirst($segment) }} Customers
                    </h3>
                    <span class="badge bg-primary ms-auto">{{ $customers->count() }} customers</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Total Bookings</th>
                                    <th>Lifetime Value</th>
                                    <th>Last Booking</th>
                                    <th>Days Since</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-sm me-2">
                                                    {{ strtoupper(substr($customer->member->first_name, 0, 1)) }}
                                                </span>
                                                <div>
                                                    <strong>{{ $customer->member->first_name }}
                                                        {{ $customer->member->last_name }}</strong>
                                                    @if($customer->segment === 'VIP')
                                                        <span class="badge bg-success-lt ms-1">VIP</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $customer->member->email }}</td>
                                        <td>
                                            <strong>{{ $customer->rfm_frequency }}</strong> bookings
                                        </td>
                                        <td>
                                            <strong>{{ number_format($customer->rfm_monetary) }} ₫</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $customer->metadata['last_booking_date'] ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($customer->rfm_recency > 60)
                                                <span class="badge bg-danger">{{ $customer->rfm_recency }} days</span>
                                            @elseif($customer->rfm_recency > 30)
                                                <span class="badge bg-warning">{{ $customer->rfm_recency }} days</span>
                                            @else
                                                <span class="badge bg-success">{{ $customer->rfm_recency }} days</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('members.edit', $customer->member_id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No customers in this segment
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection