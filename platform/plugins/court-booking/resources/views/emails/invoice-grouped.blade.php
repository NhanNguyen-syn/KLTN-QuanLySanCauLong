<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn đặt sân</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #059669, #10b981); color: white; padding: 30px; border-radius: 12px 12px 0 0; text-align: center;">
        <h1 style="margin: 0; font-size: 24px;">Đặt Sân Thành Công!</h1>
        <p style="margin: 10px 0 0; opacity: 0.9;">Cảm ơn bạn đã tin tưởng {{ $company_name }}</p>
    </div>

    <div style="background: #f9fafb; padding: 20px; border-radius: 0 0 12px 12px;">
        <div style="background: #047857; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <div style="font-size: 10px; opacity: 0.8; text-transform: uppercase;">MÃ HÓA ĐƠN</div>
                        <div style="font-size: 18px; font-weight: bold;">{{ $bookings->first()->order_code }}</div>
                    </td>
                    <td align="right">
                        <div style="font-size: 10px; opacity: 0.8; text-transform: uppercase;">NGÀY</div>
                        <div style="font-size: 14px; font-weight: bold;">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-size: 11px; color: #6b7280; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 8px;">Thông tin khách hàng</div>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="50%" valign="top" style="padding-bottom: 10px;">
                        <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">Họ và tên</div>
                        <div style="font-weight: bold; font-size: 14px;">{{ $bookings->first()->customer_name }}</div>
                    </td>
                    <td width="50%" valign="top" style="padding-bottom: 10px;">
                        <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">SĐT</div>
                        <div style="font-weight: bold; font-size: 14px;">{{ $bookings->first()->contact }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">
                        <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">Email</div>
                        <div style="font-weight: bold; font-size: 14px;">{{ $email }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-size: 11px; color: #6b7280; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 8px;">Thông tin đặt sân</div>
            
            @foreach($bookings as $booking)
            <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; background: #fff;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="30" valign="top">
                            <div style="background: #064e3b; color: white; width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 12px;">🏸</div>
                        </td>
                        <td valign="top">
                            <div style="font-weight: bold; font-size: 14px; color: #111;">{{ $booking->court_name }}</div>
                            <div style="font-size: 13px; color: #6b7280; margin-top: 2px;">{{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}</div>
                        </td>
                        <td align="right" valign="top">
                            <div style="font-weight: bold; color: #059669; font-size: 14px;">{{ number_format($booking->grand_total) }}đ</div>
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 12px; padding-top: 12px; border-top: 1px dashed #e5e7eb;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td width="30" valign="center">
                                <div style="font-size: 18px;">⏰</div>
                            </td>
                            <td>
                                <div style="font-size: 10px; color: #6b7280; text-transform: uppercase;">KHUNG GIỜ</div>
                                <div style="font-weight: bold; font-size: 14px; color: #111;">{{ $booking->start_time }} - {{ $booking->end_time }}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endforeach
        </div>

        <div style="background: #047857; color: white; padding: 20px; border-radius: 8px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding-bottom: 8px;">Tổng giá trị đơn hàng:</td>
                    <td align="right" style="font-size: 16px; font-weight: bold; padding-bottom: 8px;">{{ number_format($bookings->sum('grand_total')) }}đ</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 8px; opacity: 0.9;">Đã thanh toán:</td>
                    <td align="right" style="font-size: 16px; font-weight: bold; padding-bottom: 8px;">{{ number_format($bookings->sum('paid_amount')) }}đ</td>
                </tr>
                @php $remaining = $bookings->sum(fn($b) => $b->grand_total - $b->paid_amount); @endphp
                @if($remaining > 0)
                <tr>
                    <td style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 10px;">Cần thanh toán tại sân:</td>
                    <td align="right" style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 10px; font-size: 18px; font-weight: bold; color: #6ee7b7;">{{ number_format($remaining) }}đ</td>
                </tr>
                @endif
            </table>
        </div>

        <p style="text-align: center; font-size: 12px; color: #6b7280; margin-top: 30px;">
            Hóa đơn chi tiết đã được đính kèm trong email này.<br>
            Email được gửi tự động từ hệ thống {{ $company_name }}.
        </p>
    </div>
</body>
</html>
