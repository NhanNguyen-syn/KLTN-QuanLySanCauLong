@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <style>
        .quick-booking-page {
            padding: 0;
        }

        /* Header */
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .booking-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .date-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .date-selector input {
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
        }

        .date-nav {
            display: flex;
            gap: 0.25rem;
        }

        .date-nav button {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .date-nav button:hover {
            background: #f3f4f6;
        }

        /* Grid Container */
        .slot-grid-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        /* Grid Table */
        .slot-grid {
            display: block;
            overflow-x: auto;
            width: 100%;
        }

        .slot-grid table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .slot-grid th,
        .slot-grid td {
            border: 1px solid #e5e7eb;
            text-align: center;
            padding: 0;
        }

        .slot-grid th {
            background: #f9fafb;
            padding: 0.625rem 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .slot-grid th.court-col {
            width: 120px;
            min-width: 120px;
            position: sticky;
            left: 0;
            background: #f3f4f6;
            z-index: 20;
        }

        .slot-grid tbody td:first-child {
            position: sticky;
            left: 0;
            background: #f9fafb;
            z-index: 5;
            padding: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Slots */
        .slot {
            width: 100%;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.6875rem;
            font-weight: 500;
            transition: all 0.15s;
            user-select: none;
        }

        .slot.available {
            background: #d1fae5;
            color: #047857;
        }

        .slot.available:hover {
            background: #a7f3d0;
        }

        .slot.booked {
            background: #fecaca;
            color: #991b1b;
            cursor: not-allowed;
        }

        .slot.selected {
            background: #4f46e5 !important;
            color: white !important;
        }

        .slot.paid {
            background: #dbeafe;
            color: #1d4ed8;
            cursor: not-allowed;
        }

        .slot.completed {
            background: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
        }

        /* Legend */
        .legend {
            display: flex;
            gap: 1.5rem;
            padding: 0.75rem 1rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            font-size: 0.8125rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .legend-item .dot {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .legend-item .dot.available {
            background: #d1fae5;
        }

        .legend-item .dot.booked {
            background: #fecaca;
        }

        .legend-item .dot.selected {
            background: #4f46e5;
        }

        .legend-item .dot.paid {
            background: #dbeafe;
        }

        /* Booking Form */
        .booking-form-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 1.5rem;
            z-index: 100;
            display: none;
        }

        .booking-form-panel.active {
            display: block;
        }

        .booking-form-panel .form-row {
            display: flex;
            align-items: flex-end;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .booking-form-panel .form-group {
            flex: 1;
            min-width: 150px;
        }

        .booking-form-panel label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .booking-form-panel input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 0.9375rem;
        }

        .booking-form-panel .selected-info {
            background: #eef2ff;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            color: #4f46e5;
            font-weight: 600;
        }

        .booking-form-panel .btn-book {
            padding: 0.625rem 1.5rem;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .booking-form-panel .btn-book:hover {
            background: #4338ca;
        }

        .booking-form-panel .btn-cancel {
            padding: 0.625rem 1rem;
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
        }

        /* Time period labels */
        .time-period {
            font-size: 0.625rem;
            color: #9ca3af;
            display: block;
        }
    </style>

    <div class="quick-booking-page">
        <!-- Header -->
        <div class="booking-header">
            <h2>📅 Đặt sân nhanh</h2>
            <div class="date-selector">
                <div class="date-nav">
                    <button onclick="changeDate(-1)">◀</button>
                </div>
                <input type="date" id="bookingDate" value="{{ $date }}" onchange="loadSlots()">
                <div class="date-nav">
                    <button onclick="changeDate(1)">▶</button>
                </div>
                <button onclick="goToday()"
                    style="margin-left: 0.5rem; padding: 0.5rem 1rem; background: #4f46e5; color: white; border: none; border-radius: 6px; cursor: pointer;">Hôm
                    nay</button>
            </div>
        </div>

        <!-- Slot Grid -->
        <div class="slot-grid-container">
            <div class="slot-grid">
                <table>
                    <thead>
                        <tr>
                            <th class="court-col">Sân</th>
                            @foreach($timeSlots as $slot)
                                <th>
                                    {{ $slot }}
                                    @if($slot >= '05:00' && $slot < '08:00')
                                        <span class="time-period">Sáng sớm</span>
                                    @elseif($slot >= '08:00' && $slot < '12:00')
                                        <span class="time-period">Buổi sáng</span>
                                    @elseif($slot >= '12:00' && $slot < '14:00')
                                        <span class="time-period">Trưa</span>
                                    @elseif($slot >= '14:00' && $slot < '18:00')
                                        <span class="time-period">Chiều</span>
                                    @else
                                        <span class="time-period">Tối</span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courts as $court)
                            <tr data-court-id="{{ $court->id }}">
                                <td>
                                    <div style="font-weight: 600;">{{ $court->name }}</div>
                                    <div style="font-size: 0.6875rem; color: #6b7280;">
                                        {{ number_format($court->price_per_hour ?? 150000) }}đ/h</div>
                                </td>
                                @foreach($timeSlots as $slot)
                                    @php
                                        $isBooked = isset($bookedSlots[$court->id][$slot]);
                                        $status = $isBooked ? ($bookedSlots[$court->id][$slot]['status'] ?? 'pending') : 'available';
                                        $customer = $isBooked ? ($bookedSlots[$court->id][$slot]['customer'] ?? '') : '';
                                    @endphp
                                    <td>
                                        <div class="slot {{ $status === 'available' ? 'available' : ($status === 'paid' ? 'paid' : ($status === 'completed' ? 'completed' : 'booked')) }}"
                                            data-court-id="{{ $court->id }}" data-court-name="{{ $court->name }}"
                                            data-slot="{{ $slot }}" data-status="{{ $status }}" @if($status === 'available')
                                            onclick="toggleSlot(this)" @endif title="{{ $isBooked ? $customer : 'Trống' }}">
                                            {{ $status === 'available' ? 'Trống' : ($status === 'paid' ? 'Đã TT' : ($status === 'completed' ? 'Xong' : 'Đặt')) }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="legend">
                <div class="legend-item"><span class="dot available"></span> Trống</div>
                <div class="legend-item"><span class="dot selected"></span> Đang chọn</div>
                <div class="legend-item"><span class="dot booked"></span> Chờ TT</div>
                <div class="legend-item"><span class="dot paid"></span> Đã TT</div>
            </div>
        </div>

        <!-- Booking Form Panel (fixed at bottom) -->
        <div class="booking-form-panel" id="bookingPanel">
            <div class="form-row">
                <div class="selected-info" id="selectedInfo">
                    Chưa chọn slot
                </div>
                <div class="form-group">
                    <label>Tên khách hàng *</label>
                    <input type="text" id="customerName" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại *</label>
                    <input type="tel" id="customerPhone" placeholder="0901234567" required>
                </div>
                <div class="form-group" style="flex: 0.5;">
                    <label>Đã thanh toán</label>
                    <input type="number" id="paidAmount" placeholder="0" value="0">
                </div>
                <button class="btn-cancel" onclick="clearSelection()">Hủy</button>
                <button class="btn-book" onclick="submitBooking()">✓ Xác nhận đặt</button>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        let selectedSlots = [];
        let selectedCourtId = null;
        let selectedCourtName = '';

        function toggleSlot(el) {
            const courtId = el.dataset.courtId;
            const courtName = el.dataset.courtName;
            const slot = el.dataset.slot;

            // Only allow selecting from one court at a time
            if (selectedCourtId && selectedCourtId !== courtId) {
                Botble.showError('Chỉ có thể chọn slot từ một sân. Vui lòng hủy chọn trước.');
                return;
            }

            if (el.classList.contains('selected')) {
                // Deselect
                el.classList.remove('selected');
                el.classList.add('available');
                selectedSlots = selectedSlots.filter(s => s !== slot);
            } else {
                // Select
                el.classList.remove('available');
                el.classList.add('selected');
                selectedSlots.push(slot);
                selectedCourtId = courtId;
                selectedCourtName = courtName;
            }

            // Sort slots
            selectedSlots.sort();

            // Update UI
            updateSelectedInfo();
        }

        function updateSelectedInfo() {
            const panel = document.getElementById('bookingPanel');
            const info = document.getElementById('selectedInfo');

            if (selectedSlots.length === 0) {
                panel.classList.remove('active');
                selectedCourtId = null;
                selectedCourtName = '';
                return;
            }

            panel.classList.add('active');

            const startTime = selectedSlots[0];
            const lastSlot = selectedSlots[selectedSlots.length - 1];
            // End time is last slot + 30 minutes
            const [h, m] = lastSlot.split(':').map(Number);
            const endMinutes = h * 60 + m + 30;
            const endTime = `${String(Math.floor(endMinutes / 60)).padStart(2, '0')}:${String(endMinutes % 60).padStart(2, '0')}`;

            const duration = selectedSlots.length * 30;
            const hours = Math.floor(duration / 60);
            const mins = duration % 60;
            const durationText = hours > 0 ? `${hours}h${mins > 0 ? mins + 'p' : ''}` : `${mins}p`;

            info.innerHTML = `
            <strong>${selectedCourtName}</strong> | 
            ${startTime} → ${endTime} (${durationText}) | 
            ${selectedSlots.length} slot
        `;
        }

        function clearSelection() {
            document.querySelectorAll('.slot.selected').forEach(el => {
                el.classList.remove('selected');
                el.classList.add('available');
            });
            selectedSlots = [];
            selectedCourtId = null;
            selectedCourtName = '';
            updateSelectedInfo();
        }

        function changeDate(delta) {
            const input = document.getElementById('bookingDate');
            const date = new Date(input.value);
            date.setDate(date.getDate() + delta);
            input.value = date.toISOString().split('T')[0];
            loadSlots();
        }

        function goToday() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('bookingDate').value = today;
            loadSlots();
        }

        function loadSlots() {
            clearSelection();
            const date = document.getElementById('bookingDate').value;
            window.location.href = `{{ route('receptionist.quick-booking') }}?date=${date}`;
        }

        function submitBooking() {
            const customerName = document.getElementById('customerName').value.trim();
            const customerPhone = document.getElementById('customerPhone').value.trim();
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;

            if (!customerName) {
                Botble.showError('Vui lòng nhập tên khách hàng');
                return;
            }
            if (!customerPhone) {
                Botble.showError('Vui lòng nhập số điện thoại');
                return;
            }
            if (selectedSlots.length === 0) {
                Botble.showError('Vui lòng chọn ít nhất một slot');
                return;
            }

            const data = {
                court_id: selectedCourtId,
                date: document.getElementById('bookingDate').value,
                slots: selectedSlots,
                customer_name: customerName,
                contact: customerPhone,
                paid_amount: paidAmount,
                services: []
            };

            fetch('{{ route("receptionist.quick-booking.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(r => r.json())
                .then(result => {
                    if (result.success) {
                        Botble.showSuccess(result.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Botble.showError(result.message);
                    }
                })
                .catch(err => {
                    Botble.showError('Có lỗi xảy ra!');
                    console.error(err);
                });
        }
    </script>
@endpush