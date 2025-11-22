@extends('core/base::layouts.master')

@section('content')
    @php
        $booking = $courtSlot->getBooking();
        $user = $booking ? $booking->user : null;
    @endphp

    {!! Form::open(['route' => ['court-slot.update', $courtSlot->id], 'method' => 'PUT']) !!}

    <div class="row">
        {{-- Left Column: Slot & Booking Info --}}
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title">Thông tin Chi tiết Slot</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Sân:</strong> {{ $courtSlot->court->name ?? '-' }}</p>
                            <p><strong>Ngày:</strong> {{ $courtSlot->start_at->format('d/m/Y') }}</p>
                            <p><strong>Thời gian:</strong> {{ $courtSlot->start_at->format('H:i') }} - {{ $courtSlot->end_at->format('H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Giá khách vãng lai:</strong> {{ number_format($courtSlot->base_price ?? 0) }} VND</p>
                            <p><strong>Giá thành viên cố định:</strong> {{ number_format($courtSlot->member_price ?? 0) }} VND</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($booking)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin Đặt sân</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Khách hàng:</strong> {{ $user->name ?? '-' }}</p>
                                <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
                                <p><strong>Điện thoại:</strong> {{ $user->phone ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Mã Booking:</strong> {{ $booking->code }}</p>
                                <p><strong>Tổng tiền:</strong> {{ number_format($booking->total_amount) }} VND</p>
                                <p><strong>Trạng thái thanh toán:</strong> {{ $booking->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">Slot này chưa được đặt.</div>
            @endif
        </div>

        {{-- Right Column: Edit Form --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Chỉnh sửa</h4>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Trạng thái Slot</label>
                        {!! Form::select('status', [
                            'available' => 'Có sẵn',
                            'reserved' => 'Đã giữ',
                            'booked' => 'Đã đặt',
                            'blocked' => 'Bị khóa',
                        ], $courtSlot->status, ['class' => 'form-control'])
                        !!}
                    </div>

                    <div class="form-group mb-3">
                        <label for="notes" class="form-label">Ghi chú (Booking)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="4" @if(!$booking) disabled @endif>{{ old('notes', $booking->notes ?? '') }}</textarea>
                        @if(!$booking)
                            <small class="form-text text-muted">Chỉ có thể thêm ghi chú khi slot đã được đặt.</small>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('court-slot.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

