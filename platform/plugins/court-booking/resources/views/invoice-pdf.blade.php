<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hóa đơn {{ $invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }

        .invoice-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }

        .header-left,
        .header-right {
            display: table-cell;
            vertical-align: top;
        }

        .header-left {
            width: 60%;
        }

        .header-right {
            width: 40%;
            text-align: right;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 11px;
            color: #666;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-number {
            font-size: 14px;
            color: #666;
        }

        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-box {
            display: table-cell;
            width: 50%;
            padding: 15px;
            background: #f8fafc;
            vertical-align: top;
        }

        .info-box:first-child {
            border-right: 1px solid #e5e7eb;
        }

        .info-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .info-content {
            font-size: 13px;
        }

        .info-content strong {
            font-size: 15px;
            display: block;
            margin-bottom: 5px;
        }

        .booking-details {
            margin-bottom: 20px;
            background: #4f46e5;
            color: white;
            padding: 15px;
            border-radius: 8px;
        }

        .booking-details-title {
            font-size: 11px;
            text-transform: uppercase;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .booking-details-content {
            font-size: 16px;
            font-weight: bold;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        .totals-section {
            width: 300px;
            float: right;
        }

        .totals-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-label,
        .totals-value {
            display: table-cell;
        }

        .totals-label {
            text-align: left;
            color: #6b7280;
        }

        .totals-value {
            text-align: right;
            font-weight: bold;
        }

        .grand-total {
            background: #10b981;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .footer {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 11px;
        }

        .thank-you {
            text-align: center;
            margin: 30px 0;
            font-size: 14px;
            color: #10b981;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="company-name">{{ $company['name'] }}</div>
                <div class="company-info">
                    {{ $company['address'] }}<br>
                    ĐT: {{ $company['phone'] }} | Email: {{ $company['email'] }}
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">HÓA ĐƠN</div>
                <div class="invoice-number">
                    Số: {{ $invoice_number }}<br>
                    Ngày: {{ $generated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        <!-- Customer & Booking Info -->
        <div class="info-section">
            <div class="info-box">
                <div class="info-title">Thông tin khách hàng</div>
                <div class="info-content">
                    <strong>{{ $booking->customer_name }}</strong>
                    SĐT: {{ $booking->contact }}<br>
                    Mã đơn: {{ $booking->order_code ?? '#' . $booking->id }}
                </div>
            </div>
            <div class="info-box">
                <div class="info-title">Thông tin thanh toán</div>
                <div class="info-content">
                    <strong>{{ $booking->status === 'paid' ? 'Đã thanh toán' : ($booking->status === 'completed' ? 'Hoàn thành' : 'Chờ thanh toán') }}</strong>
                    Đã TT: {{ number_format($booking->paid_amount ?? 0) }} đ<br>
                    Còn lại: {{ number_format($booking->remaining_amount) }} đ
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="booking-details">
            <div class="booking-details-title">Chi tiết đặt sân</div>
            <div class="booking-details-content">
                {{ $booking->court_name }} |
                {{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }} |
                {{ $booking->start_time }} - {{ $booking->end_time }}
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Mô tả</th>
                    <th class="text-center" style="width: 15%;">SL</th>
                    <th class="text-right" style="width: 17%;">Đơn giá</th>
                    <th class="text-right" style="width: 18%;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <!-- Court booking -->
                <tr>
                    <td>
                        <strong>{{ $booking->court_name }}</strong><br>
                        <span style="font-size: 11px; color: #6b7280;">
                            {{ $booking->start_time }} - {{ $booking->end_time }}
                        </span>
                    </td>
                    <td class="text-center">1</td>
                    <td class="text-right">{{ number_format($booking->price) }} đ</td>
                    <td class="text-right">{{ number_format($booking->price) }} đ</td>
                </tr>

                <!-- Services -->
                @if($booking->bookingServices && $booking->bookingServices->count() > 0)
                    @foreach($booking->bookingServices as $bookingService)
                        <tr>
                            <td>
                                {{ $bookingService->service->name ?? 'Dịch vụ' }}
                                @if($bookingService->notes)
                                    <br><span style="font-size: 10px; color: #9ca3af;">{{ $bookingService->notes }}</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $bookingService->quantity }}</td>
                            <td class="text-right">{{ number_format($bookingService->unit_price) }} đ</td>
                            <td class="text-right">{{ number_format($bookingService->total_price) }} đ</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <div class="totals-row">
                <span class="totals-label">Tiền sân:</span>
                <span class="totals-value">{{ number_format($booking->price) }} đ</span>
            </div>
            @if($booking->services_total > 0)
                <div class="totals-row">
                    <span class="totals-label">Tiền dịch vụ:</span>
                    <span class="totals-value">{{ number_format($booking->services_total) }} đ</span>
                </div>
            @endif
            <div class="totals-row grand-total">
                <span class="totals-label">TỔNG CỘNG:</span>
                <span class="totals-value">{{ number_format($booking->grand_total) }} đ</span>
            </div>
        </div>

        <div style="clear: both;"></div>

        <!-- Thank you -->
        <div class="thank-you">
            Cảm ơn quý khách đã sử dụng dịch vụ!
        </div>

        <!-- Footer -->
        <div class="footer">
            Đây là hóa đơn điện tử được tạo tự động. Vui lòng liên hệ {{ $company['phone'] }} nếu có thắc mắc.<br>
            {{ $company['name'] }} - {{ $company['address'] }}
        </div>

        @if($booking->notes)
            <div style="margin-top: 20px; padding: 15px; background: #fef3c7; border-radius: 8px; font-size: 11px;">
                <strong>Ghi chú:</strong><br>
                {!! nl2br(e($booking->notes)) !!}
            </div>
        @endif
    </div>
</body>

</html>