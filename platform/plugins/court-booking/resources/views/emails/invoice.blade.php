<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn đặt sân</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div
        style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; padding: 30px; border-radius: 12px 12px 0 0; text-align: center;">
        <h1 style="margin: 0; font-size: 24px;">{{ $company_name }}</h1>
        <p style="margin: 10px 0 0; opacity: 0.9;">Cảm ơn quý khách đã sử dụng dịch vụ!</p>
    </div>

    <div style="background: #f9fafb; padding: 30px; border-radius: 0 0 12px 12px;">
        <h2 style="color: #4f46e5; margin-top: 0;">Xác nhận đặt sân</h2>

        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <p style="margin: 0 0 10px;"><strong>Mã đơn:</strong> {{ $booking->order_code ?? '#' . $booking->id }}</p>
            <p style="margin: 0 0 10px;"><strong>Sân:</strong> {{ $booking->court_name }}</p>
            <p style="margin: 0 0 10px;"><strong>Ngày:</strong>
                {{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }}</p>
            <p style="margin: 0 0 10px;"><strong>Giờ:</strong> {{ $booking->start_time }} - {{ $booking->end_time }}</p>
            <p style="margin: 0;"><strong>Tổng tiền:</strong> <span
                    style="color: #10b981; font-size: 18px; font-weight: bold;">{{ number_format($booking->grand_total) }}
                    đ</span></p>
        </div>

        <p style="color: #6b7280; font-size: 14px;">
            Hóa đơn chi tiết được đính kèm trong email này dưới dạng PDF.
            Vui lòng kiểm tra và liên hệ với chúng tôi nếu có bất kỳ thắc mắc nào.
        </p>

        <div style="text-align: center; margin-top: 30px;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                Email này được gửi tự động từ hệ thống {{ $company_name }}.<br>
                Vui lòng không trả lời email này.
            </p>
        </div>
    </div>
</body>

</html>