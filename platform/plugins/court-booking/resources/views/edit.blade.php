@extends('core/base::layouts.master')

@section('content')
    @php
        /** @var \Botble\CourtBooking\Models\BookingList $booking */
        $totalPrice = ($items ?? collect())->sum('price');
        $totalPaid  = ($items ?? collect())->sum('paid_amount');
        $remaining  = max(0, $totalPrice - $totalPaid);
        $statusLabels = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'paid' => 'Đã cọc',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            'draft' => 'Nháp',
            'published' => 'Hiển thị',
        ];
        $statusColors = [
            'pending' => 'warning',
            'processing' => 'warning',
            'paid' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'draft' => 'secondary',
            'published' => 'success',
        ];
    @endphp

        

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>Thông tin đơn hàng</strong></div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <div><strong>Tên khách hàng:</strong> {{ $orderInfo->customer_name ?: '—' }}</div>
                            <div><strong>Liên hệ:</strong> {{ $orderInfo->contact ?: '—' }}</div>
                        </div>
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
                                @foreach(($items ?? []) as $i => $it)
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
                                    <th class="text-end">{{ number_format($remaining, 0, ',', '.') }} đ</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><strong>Cập nhật tiền cọc cho toàn bộ đơn hàng</strong></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('booking-list.update', $booking->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="apply_to_order" value="1">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tổng tiền cọc muốn thiết lập</label>
                                    <input class="form-control" type="number" step="0.01" min="0" name="paid_amount_total" value="{{ $totalPaid }}">
                                    <small class="text-muted">Hệ thống sẽ tự động phân bổ theo tỷ lệ giá của từng mục để tổng cộng đúng số tiền này (có thể để trống nếu chỉ muốn đổi trạng thái/ghi chú).</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Trạng thái đơn</label>
                                    <select name="status" class="form-select">
                                        <option value="">— Giữ nguyên —</option>
                                        @foreach($statusLabels as $key => $text)
                                            <option value="{{ $key }}" @selected($booking->status === $key)>{{ $text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea name="notes" rows="2" class="form-control" placeholder="Nhập ghi chú cho toàn bộ mục (tùy chọn)">{{ old('notes', $booking->notes) }}</textarea>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button class="btn btn-primary" type="submit">Cập nhật toàn bộ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Form chỉnh mục đơn lẻ (giữ nguyên) --}}
                {!! $form->renderForm() !!}
            </div>
        </div>
    </div>
@stop

