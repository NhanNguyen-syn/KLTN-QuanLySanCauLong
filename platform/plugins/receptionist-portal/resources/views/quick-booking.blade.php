@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --text-color: #374151;
            --bg-color: #f9fafb;
        }

        .quick-booking-container {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            margin-top: 1rem;
        }

        /* --- LEFT SIDE: GRID --- */
        .booking-main {
            flex: 1;
            min-width: 0; /* Prevent flex item from overflowing */
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            background: white;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .date-navigation {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--gray-100);
            padding: 0.25rem;
            border-radius: 8px;
        }

        .btn-nav {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            color: var(--text-color);
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .btn-nav:hover {
            background: white;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        #bookingDate {
            border: none;
            background: transparent;
            font-weight: 600;
            color: var(--text-color);
            padding: 0 0.5rem;
            font-family: inherit;
        }

        .slot-grid-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            position: relative;
        }

        .slot-grid-scroll {
            overflow-x: auto;
            max-width: 100%;
        }

        .booking-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .booking-table th {
            backdrop-filter: blur(4px);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .booking-table td, .booking-table th {
            border-bottom: 1px solid var(--gray-200);
            border-right: 1px dashed var(--gray-200);
            padding: 0;
            height: 55px; /* Increased height */
            font-size: 0.95rem;
        }
        
        .booking-table tr:last-child td {
            border-bottom: none;
        }

        /* Court Column */
        .col-court {
            position: sticky;
            left: 0;
            z-index: 20;
            background: white;
            width: 140px; /* Increased width */
            min-width: 140px;
            padding: 0.75rem !important;
            border-right: 2px solid var(--gray-200) !important;
        }
        
        .col-court-header {
             background: var(--gray-100) !important;
             border-bottom: 2px solid var(--gray-200) !important;
        }

        .court-name {
            font-weight: 700;
            color: var(--text-color);
            font-size: 0.9rem;
            display: block;
        }

        .court-price {
            font-size: 0.7rem;
            color: #6b7280;
            display: block;
            margin-top: 2px;
        }

        /* Time Header */
        .col-time {
            min-width: 50px;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--gray-100);
            color: #6b7280;
            padding: 0.5rem 0 !important;
        }
        
        .time-period {
            display: block;
            font-size: 0.6rem;
            font-weight: 400;
            opacity: 0.8;
            margin-top: 2px;
        }

        /* Slots */
        .slot-cell {
            position: relative;
            cursor: pointer;
            transition: all 0.1s;
        }

        .slot-cell:hover {
            background-color: #f9fafb;
        }

        .slot-status {
            width: 100%;
            height: 100%;
            display: block;
            transition: all 0.2s;
        }

        /* Available */
        .status-available {

        }
        .slot-cell:hover .status-available {
            background-color: rgba(16, 185, 129, 0.1);
        }

        /* Booked */
        .status-booked {
            background-color: #fee2e2; /* Red 100 */
            border-left: 3px solid var(--danger-color);
        }
        .slot-cell.booked {
            cursor: not-allowed;
        }

        /* Selected */
        .status-selected {
            background-color: var(--primary-color);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.2);
        }

        /* Paid */
        .status-paid {
            background-color: #dbeafe; /* Blue 100 */
            border-left: 3px solid #2563eb;
        }

         /* Completed */
        .status-completed {
            background-color: var(--gray-200);
            cursor: not-allowed;
        }

        /* Closed/Past */
        .status-closed {
            background-color: var(--gray-200);
            background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(0,0,0,0.03) 5px, rgba(0,0,0,0.03) 10px);
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .slot-cell.closed {
            cursor: not-allowed;
        }

        /* Legend */
        .legend-bar {
            display: flex;
            gap: 1.5rem;
            padding: 1rem;
            background: white;
            border-top: 1px solid var(--gray-200);
            font-size: 0.8rem;
            color: var(--text-color);
            justify-content: center;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        /* --- RIGHT SIDE: SIDEBAR --- */
        .booking-sidebar {
            width: 320px;
            flex-shrink: 0;
            position: sticky;
            top: 2rem; /* Adjust based on admin bar height */
            height: fit-content;
        }

        .booking-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid var(--gray-200);
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-color), #6366f1);
            color: white;
            padding: 1rem;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .empty-state {
            text-align: center;
            color: #9ca3af;
            padding: 2rem 0;
            font-size: 0.9rem;
        }
        
        .empty-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }

        .selected-summary {
            background: #eef2ff;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #c7d2fe;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 0.5rem;
            border-top: 1px dashed #c7d2fe;
            font-weight: 700;
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.35rem;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-confirm {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-confirm:hover {
            background: var(--primary-hover);
        }
        
        .btn-cancel {
            width: 100%;
            padding: 0.5rem;
            background: transparent;
            color: #6b7280;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        
        .btn-cancel:hover {
            text-decoration: underline;
        }

        /* Tooltip styling */
        [data-title]:hover::after {
            content: attr(data-title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background: rgba(0,0,0,0.8);
            color: white;
            font-size: 10px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 100;
            pointer-events: none;
            margin-bottom: 4px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .quick-booking-container {
                flex-direction: column;
            }
            .booking-sidebar {
                width: 100%;
                position: static;
            }
        }
    </style>

    <div class="row">
        <div class="col-12">
            <h2 class="mb-3" style="font-weight: 700; color: #111827; font-size: 1.5rem;">📅 Đặt sân nhanh (Quick Booking)</h2>
        </div>
    </div>

    <div class="quick-booking-container">
        <!-- LEFT: MAIN GRID -->
        <div class="booking-main">
            <!-- Toolbar -->
            <div class="booking-header">
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Lịch sân ngày {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h3>
                </div>
                <div class="date-navigation">
                    <button class="btn-nav" onclick="changeDate(-1)" title="Ngày trước">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <input type="date" id="bookingDate" value="{{ $date }}" onchange="loadSlots()">
                    <button class="btn-nav" onclick="changeDate(1)" title="Ngày sau">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button onclick="goToday()" style="background: var(--primary-color); color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 6px; font-weight: 600; cursor: pointer; margin-left: 0.5rem; font-size: 0.85rem;">
                        Hôm nay
                    </button>
                </div>
            </div>

            <!-- Grid -->
            <div class="slot-grid-wrapper">
                <div class="slot-grid-scroll">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th class="col-court col-court-header">Sân / Giờ</th>
                                @foreach($timeSlots as $slot)
                                    <th class="col-time">
                                        {{ $slot }}
                                        @php
                                            $hour = (int)substr($slot, 0, 2);
                                            $period = 'Tối';
                                            if($hour < 11) $period = 'Sáng';
                                            elseif($hour < 14) $period = 'Trưa';
                                            elseif($hour < 18) $period = 'Chiều';
                                        @endphp
                                        <span class="time-period">{{ $period }}</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $now = \Carbon\Carbon::now();
                                $currentDate = \Carbon\Carbon::parse($date);
                                $isToday = $currentDate->isToday();
                            @endphp
                            @foreach($courts as $court)
                                <tr>
                                    <td class="col-court">
                                        <span class="court-name">{{ $court->name }}</span>
                                        <span class="court-price">140,000đ</span>
                                    </td>
                                    @foreach($timeSlots as $slot)
                                        @php
                                            $isBooked = isset($bookedSlots[$court->id][$slot]);
                                            $status = $isBooked ? ($bookedSlots[$court->id][$slot]['status'] ?? 'pending') : 'available';
                                            $customer = $isBooked ? ($bookedSlots[$court->id][$slot]['customer'] ?? '') : '';
                                            
                                            // Check past time
                                            $isPast = false;
                                            if ($currentDate->isPast() && !$isToday) {
                                               $isPast = true;
                                            } elseif ($isToday) {
                                                $slotTime = \Carbon\Carbon::parse($date . ' ' . $slot);
                                                if ($slotTime->lt($now)) {
                                                    $isPast = true;
                                                }
                                            }

                                            if ($isPast) {
                                                $status = 'closed';
                                            }

                                            $cellClass = match($status) {
                                                'available' => 'status-available',
                                                'paid' => 'status-paid',
                                                'completed' => 'status-completed',
                                                'closed' => 'status-closed',
                                                default => 'status-booked'
                                            };
                                            $tooltip = match($status) {
                                                'available' => 'Trống - Bấm để chọn',
                                                'paid' => "Đã thanh toán: $customer",
                                                'completed' => "Hoàn thành: $customer",
                                                'closed' => 'Đã đóng',
                                                default => "Đã đặt: $customer"
                                            };
                                        @endphp
                                        <td class="slot-cell {{ $status !== 'available' ? 'booked' : '' }} {{ $status === 'closed' ? 'closed' : '' }}" 
                                            data-court-id="{{ $court->id }}" 
                                            data-court-name="{{ $court->name }}"
                                            data-slot="{{ $slot }}" 
                                            data-price="70000"
                                            title="{{ $tooltip }}"
                                            @if($status === 'available') onclick="toggleSlot(this)" @endif>
                                            <span class="slot-status {{ $cellClass }}">
                                                @if($status === 'closed') Đóng @endif
                                            </span>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Simple Legend -->
                <div class="legend-bar">
                    <div class="legend-item">
                        <span class="legend-dot" style="border: 1px solid var(--gray-300);"></span> Trống
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: var(--primary-color);"></span> Đang chọn
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #fee2e2; border: 1px solid #ef4444;"></span> Đã đặt
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #dbeafe; border: 1px solid #2563eb;"></span> Đã TT
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: var(--gray-200); background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 4px);"></span> Đã đóng
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: SIDEBAR FORM -->
        <div class="booking-sidebar">
            <div class="booking-card">
                <div class="card-header">
                    <h3><i class="fas fa-clipboard-check"></i> Thông tin đặt sân</h3>
                </div>
                <div class="card-body">
                    <div id="emptyState" class="empty-state">
                        <div class="empty-icon">👈</div>
                        <p>Vui lòng chọn slot trên lịch để bắt đầu đặt sân</p>
                    </div>

                    <div id="bookingForm" style="display: none;">
                        <input type="hidden" id="courtId">
                        
                        <div class="selected-summary">
                            <div class="summary-row">
                                <span>Sân:</span>
                                <strong id="summaryCourt">...</strong>
                            </div>
                            <div class="summary-row">
                                <span>Thời gian:</span>
                                <span><span id="summaryStart">...</span> - <span id="summaryEnd">...</span></span>
                            </div>
                            <div class="summary-row">
                                <span>Thời lượng:</span>
                                <span id="summaryDuration">...</span>
                            </div>
                            <div class="summary-row">
                                <span>Tạm tính:</span>
                                <span id="summaryPrice">0đ</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tên khách hàng <span class="text-danger">*</span></label>
                            <input type="text" id="customerName" class="form-control" placeholder="Nhập tên khách..." required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" id="customerPhone" class="form-control" placeholder="09xxxx..." required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Thanh toán trước (VNĐ)</label>
                            <input type="number" id="paidAmount" class="form-control" placeholder="0" value="0">
                        </div>

                        <button class="btn-confirm" onclick="submitBooking()">
                            <i class="fas fa-check"></i> Xác nhận đặt sân
                        </button>
                        <button class="btn-cancel" onclick="clearSelection()">Hủy chọn</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        let selectedSlots = [];
        let selectedCourtId = null;
        let selectedCourtName = '';
        let selectedPricePerHour = 0;

        function toggleSlot(el) {
            const courtId = el.dataset.courtId;
            const courtName = el.dataset.courtName;
            const slot = el.dataset.slot;
            const price = parseFloat(el.dataset.price);

            // Constraint: Only one court at a time
            if (selectedCourtId && selectedCourtId !== courtId) {
                Botble.showError('Chỉ có thể chọn slot của 1 sân cùng lúc. Vui lòng hoàn thành hoặc hủy đơn hiện tại.');
                return;
            }
            
            const statusSpan = el.querySelector('.slot-status');

            if (statusSpan.classList.contains('status-selected')) {
                // Deselect
                statusSpan.classList.remove('status-selected');
                selectedSlots = selectedSlots.filter(s => s !== slot);
            } else {
                // Select
                statusSpan.classList.add('status-selected');
                selectedSlots.push(slot);
                selectedCourtId = courtId;
                selectedCourtName = courtName;
                selectedPricePerHour = price;
            }

            // Cleanup if empty
            if (selectedSlots.length === 0) {
                selectedCourtId = null;
                clearSelectionUI();
            } else {
                selectedSlots.sort();
                updateFormUI();
            }
        }

        function updateFormUI() {
            document.getElementById('emptyState').style.display = 'none';
            document.getElementById('bookingForm').style.display = 'block';
            document.getElementById('courtId').value = selectedCourtId;

            document.getElementById('summaryCourt').textContent = selectedCourtName;
            
            const start = selectedSlots[0];
            const endSlot = selectedSlots[selectedSlots.length - 1];
            
            // Calculate end time (+30min)
            const [h, m] = endSlot.split(':').map(Number);
            const endD = new Date(); endD.setHours(h, m + 30);
            const end = endD.toTimeString().substr(0, 5);

            document.getElementById('summaryStart').textContent = start;
            document.getElementById('summaryEnd').textContent = end;
            
            // Duration & Price
            const slotCount = selectedSlots.length;
            const hours = slotCount * 0.5;
            document.getElementById('summaryDuration').textContent = hours + ' giờ';
            
            let originalPrice = slotCount * selectedPricePerHour;
            let finalPrice = originalPrice;

            if (slotCount >= 4 && selectedPricePerHour > 0) {
                // Discount 10,000 VND per slot (~15%)
                finalPrice = Math.max(0, originalPrice - (10000 * slotCount));
            }

            let priceHtml = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(finalPrice);
            if (finalPrice < originalPrice) {
                const percentage = Math.round(((originalPrice - finalPrice) / originalPrice) * 100);
                priceHtml = `
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <span style="text-decoration: line-through; color: #9ca3af; font-size: 0.85rem; font-weight: normal;">
                            ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(originalPrice)}
                        </span>
                        <div>
                            <span style="background: #10b981; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; margin-right: 4px;">
                                Giảm ${percentage}%
                            </span>
                            ${priceHtml}
                        </div>
                    </div>
                `;
            }

            document.getElementById('summaryPrice').innerHTML = priceHtml;
        }

        function clearSelectionUI() {
            document.querySelectorAll('.status-selected').forEach(el => el.classList.remove('status-selected'));
            document.getElementById('emptyState').style.display = 'block';
            document.getElementById('bookingForm').style.display = 'none';
        }

        function clearSelection() {
            selectedSlots = [];
            selectedCourtId = null;
            clearSelectionUI();
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
            const date = document.getElementById('bookingDate').value;
             window.location.href = `{{ route('receptionist.quick-booking') }}?date=${date}`;
        }

        function submitBooking() {
            const customerName = document.getElementById('customerName').value.trim();
            const customerPhone = document.getElementById('customerPhone').value.trim();
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;

            if (!customerName) {
                Botble.showError('Vui lòng nhập tên khách hàng');
                document.getElementById('customerName').focus();
                return;
            }
            if (!customerPhone) {
                Botble.showError('Vui lòng nhập số điện thoại');
                document.getElementById('customerPhone').focus();
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

            const btn = document.querySelector('.btn-confirm');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            btn.disabled = true;

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
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(err => {
                Botble.showError('Có lỗi hệ thống xảy ra!');
                console.error(err);
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        // Auto-scroll to first open slot
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.slot-grid-scroll');
            // Find the first slot in the first row that is NOT closed
            const firstOpenSlot = document.querySelector('.slot-cell:not(.closed)');
            
            if (container && firstOpenSlot) {
                // Scroll specifically to that element, with a little padding (e.g. -100px to show some context)
                const offset = firstOpenSlot.offsetLeft - 150; 
                container.scrollTo({
                    left: offset > 0 ? offset : 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
    
    <!-- Add FontAwesome if missing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush