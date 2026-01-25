@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <style>
        .quick-booking-page {
            max-width: 800px;
            margin: 0 auto;
        }

        .booking-form {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px #eef2ff;
        }

        .availability-status {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .availability-status.available {
            background: #d1fae5;
            color: #047857;
        }

        .availability-status.unavailable {
            background: #fee2e2;
            color: #b91c1c;
        }

        .services-section {
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .services-section h4 {
            font-size: 0.9375rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .service-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .service-item:last-child {
            border-bottom: none;
        }

        .service-info {
            flex: 1;
        }

        .service-name {
            font-weight: 500;
        }

        .service-price {
            font-size: 0.8125rem;
            color: #6b7280;
        }

        .service-qty {
            width: 60px;
            text-align: center;
        }

        .summary-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.375rem 0;
        }

        .summary-row.total {
            font-size: 1.125rem;
            font-weight: 700;
            border-top: 1px solid #e5e7eb;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background: #4338ca;
        }

        .btn-submit:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
    </style>

    <div class="quick-booking-page">
        <div class="booking-form">
            <h2 style="margin-bottom: 1.5rem;">Đặt sân nhanh</h2>

            <form id="quickBookingForm">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Sân</label>
                        <select name="court_id" id="court_id" required>
                            <option value="">-- Chọn sân --</option>
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}">{{ $court->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ngày</label>
                        <input type="date" name="date" id="date" value="{{ $today }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giờ bắt đầu</label>
                        <input type="time" name="start_time" id="start_time" value="08:00" required>
                    </div>
                    <div class="form-group">
                        <label>Giờ kết thúc</label>
                        <input type="time" name="end_time" id="end_time" value="09:00" required>
                    </div>
                </div>

                <div id="availabilityStatus" style="display: none;"></div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tên khách hàng</label>
                        <input type="text" name="customer_name" id="customer_name" required placeholder="Nguyễn Văn A">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" name="contact" id="contact" required placeholder="0901234567">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Giá sân</label>
                        <input type="number" name="price" id="price" required placeholder="100000" value="100000">
                    </div>
                    <div class="form-group">
                        <label>Đã thanh toán</label>
                        <input type="number" name="paid_amount" id="paid_amount" placeholder="0" value="0">
                    </div>
                </div>

                @if($services->count() > 0)
                    <div class="services-section">
                        <h4>Dịch vụ kèm theo</h4>
                        @foreach($services->groupBy('category') as $category => $categoryServices)
                            <div style="margin-bottom: 0.75rem;">
                                <strong
                                    style="font-size: 0.8125rem; color: #6b7280;">{{ $categoryServices->first()->category_label }}</strong>
                                @foreach($categoryServices as $service)
                                    <div class="service-item">
                                        <div class="service-info">
                                            <div class="service-name">{{ $service->name }}</div>
                                            <div class="service-price">{{ $service->formatted_price }}/{{ $service->unit }}</div>
                                        </div>
                                        <input type="number" class="service-qty form-control" data-id="{{ $service->id }}"
                                            data-price="{{ $service->price }}" min="0" value="0" style="width: 70px;">
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="summary-box">
                    <div class="summary-row">
                        <span>Tiền sân:</span>
                        <span id="courtPriceDisplay">0 đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Tiền dịch vụ:</span>
                        <span id="servicePriceDisplay">0 đ</span>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng cộng:</span>
                        <span id="totalDisplay">0 đ</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">Xác nhận đặt sân</button>
            </form>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('quickBookingForm');
            const checkFields = ['court_id', 'date', 'start_time', 'end_time'];

            checkFields.forEach(field => {
                document.getElementById(field).addEventListener('change', checkAvailability);
            });

            document.getElementById('price').addEventListener('input', updateTotal);
            document.querySelectorAll('.service-qty').forEach(el => {
                el.addEventListener('input', updateTotal);
            });

            function checkAvailability() {
                const courtId = document.getElementById('court_id').value;
                const date = document.getElementById('date').value;
                const startTime = document.getElementById('start_time').value;
                const endTime = document.getElementById('end_time').value;

                if (!courtId || !date || !startTime || !endTime) return;

                fetch(`{{ route('receptionist.check-availability') }}?court_id=${courtId}&date=${date}&start_time=${startTime}&end_time=${endTime}`)
                    .then(r => r.json())
                    .then(data => {
                        const statusDiv = document.getElementById('availabilityStatus');
                        statusDiv.style.display = 'block';

                        if (data.available) {
                            statusDiv.className = 'availability-status available';
                            statusDiv.innerHTML = '✓ Khung giờ trống, có thể đặt';
                            document.getElementById('submitBtn').disabled = false;
                        } else {
                            statusDiv.className = 'availability-status unavailable';
                            statusDiv.innerHTML = '✗ Khung giờ đã có người đặt';
                            document.getElementById('submitBtn').disabled = true;
                        }
                    });
            }

            function updateTotal() {
                const courtPrice = parseFloat(document.getElementById('price').value) || 0;
                let servicePrice = 0;

                document.querySelectorAll('.service-qty').forEach(el => {
                    const qty = parseInt(el.value) || 0;
                    const price = parseFloat(el.dataset.price) || 0;
                    servicePrice += qty * price;
                });

                document.getElementById('courtPriceDisplay').textContent = formatNumber(courtPrice) + ' đ';
                document.getElementById('servicePriceDisplay').textContent = formatNumber(servicePrice) + ' đ';
                document.getElementById('totalDisplay').textContent = formatNumber(courtPrice + servicePrice) + ' đ';
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('vi-VN').format(num);
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const services = [];
                document.querySelectorAll('.service-qty').forEach(el => {
                    const qty = parseInt(el.value) || 0;
                    if (qty > 0) {
                        services.push({ id: el.dataset.id, quantity: qty });
                    }
                });

                const formData = {
                    court_id: document.getElementById('court_id').value,
                    date: document.getElementById('date').value,
                    start_time: document.getElementById('start_time').value,
                    end_time: document.getElementById('end_time').value,
                    customer_name: document.getElementById('customer_name').value,
                    contact: document.getElementById('contact').value,
                    price: document.getElementById('price').value,
                    paid_amount: document.getElementById('paid_amount').value || 0,
                    services: services
                };

                fetch('{{ route("receptionist.quick-booking.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.href = '{{ route("receptionist.index") }}';
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        alert('Có lỗi xảy ra!');
                        console.error(err);
                    });
            });

            updateTotal();
        });
    </script>
@endpush