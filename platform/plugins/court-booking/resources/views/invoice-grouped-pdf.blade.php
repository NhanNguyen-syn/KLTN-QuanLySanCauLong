<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hóa đơn {{ $invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .invoice-wrapper { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: table; width: 100%; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; }
        .header-left, .header-right { display: table-cell; vertical-align: top; }
        .header-left { width: 60%; }
        .header-right { width: 40%; text-align: right; }
        .company-name { font-size: 24px; font-weight: bold; color: #4f46e5; margin-bottom: 5px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { background: #f3f4f6; padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb; }
        .items-table td { padding: 12px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .grand-total { background: #10b981; color: white; padding: 12px; border-radius: 8px; font-size: 16px; margin-top: 10px; text-align: right; }
    </style>
</head>
<body>
    <div class="invoice-wrapper">
        <div class="header">
            <div class="header-left">
                <div class="company-name">{{ $company['name'] }}</div>
                {{ $company['address'] }}<br>
                ĐT: {{ $company['phone'] }}
            </div>
            <div class="header-right">
                <h2 style="color: #333;">HÓA ĐƠN</h2>
                Số: {{ $invoice_number }}<br>
                Ngày: {{ $generated_at->format('d/m/Y H:i') }}
            </div>
        </div>

        <div style="margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 8px;">
            <strong>Khách hàng:</strong> {{ $first_booking->customer_name }}<br>
            <strong>SĐT:</strong> {{ $first_booking->contact }}<br>
            <strong>Mã đơn:</strong> {{ $first_booking->order_code }}
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Sân / Dịch vụ</th>
                    <th>Thời gian</th>
                    <th class="text-right">Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td colspan="3" style="background: #eef2ff; font-weight: bold; font-size: 11px; color: #4f46e5;">
                            MÃ ĐẶT SÂN: #{{ $booking->id }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{ $booking->court_name }}</strong>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}<br>
                            {{ $booking->start_time }} - {{ $booking->end_time }}
                        </td>
                        <td class="text-right">
                            {{ number_format($booking->price) }} đ
                        </td>
                    </tr>
                    <!-- Services -->
                    @if($booking->bookingServices && $booking->bookingServices->count() > 0)
                        @foreach($booking->bookingServices as $service)
                            <tr>
                                <td style="padding-left: 20px; color: #555;">
                                    + {{ $service->service->name }} (x{{ $service->quantity }})
                                </td>
                                <td></td>
                                <td class="text-right">
                                    {{ number_format($service->total_price) }} đ
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>

        <div class="grand-total">
            TỔNG CỘNG: {{ number_format($total_amount) }} đ
        </div>

        <div style="text-align: center; margin-top: 40px; color: #9ca3af; font-size: 11px;">
            Cảm ơn quý khách đã sử dụng dịch vụ!
        </div>
    </div>
</body>
</html>
