<div class="card mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <strong>Thông tin đơn hàng</strong> — Mã: {{ $booking->order_code }}

                <div class="mt-1 text-muted small">
                    <div>
                        <strong>Khách hàng:</strong>
                        {{ $booking->customer_name ?? $booking->name ?? $booking->full_name ?? '—' }}
                    </div>
                    <div>
                        <strong>Liên hệ:</strong>
                        {{ $booking->contact ?? $booking->customer_phone ?? $booking->phone ?? $booking->contact_phone ?? $booking->customer_email ?? $booking->email ?? '—' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Sân</th>
                    <th>Ngày</th>
                    <th>Khung giờ</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Giá</th>
                    <th class="text-end">Đã cọc</th>
                    <th class="text-end">Còn lại</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $i => $it)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $it->court_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($it->date)->format('d/m/Y') }}</td>
                        <td>{{ $it->start_time }} - {{ $it->end_time }}</td>
                        <td>
                            @php($s = (string)($it->status ?? ''))
                            @php($color = $statusColors[$s] ?? 'secondary')
                            @php($label = $statusLabels[$s] ?? ($s ?: '—'))
                            <span class="badge bg-{{ $color }}">{{ $label }}</span>
                        </td>
                        <td class="text-end">{{ number_format($it->price, 0, ',', '.') }} đ</td>
                        <td class="text-end">{{ number_format($it->paid_amount, 0, ',', '.') }} đ</td>
                        <td class="text-end">{{ number_format(max(0, $it->price - $it->paid_amount), 0, ',', '.') }} đ</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Tổng</th>
                    <th class="text-end">{{ number_format($totalPrice, 0, ',', '.') }} đ</th>
                    <th class="text-end">{{ number_format($totalPaid, 0, ',', '.') }} đ</th>
                    <th class="text-end">{{ number_format(max(0, $totalPrice - $totalPaid), 0, ',', '.') }} đ</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

