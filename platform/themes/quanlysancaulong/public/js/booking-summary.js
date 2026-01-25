// Booking summary renderer (works with shortcode or plain UIBlock form)
(function () {
    function ensureCardExists() {
        var card = document.getElementById('booking-summary-card');
        var body = document.getElementById('booking-summary-body');

        function insertAfter(ref, el) {
            if (ref && ref.parentNode) {
                if (ref.nextSibling) ref.parentNode.insertBefore(el, ref.nextSibling);
                else ref.parentNode.appendChild(el);
            }
        }

        if (!card || !body) {
            // Only inject on pages with specific anchors - NOT on general pages
            var anchor =
                document.querySelector('#booking-summary-anchor') ||
                document.querySelector('.personal-info-form');

            // If no specific anchor found, don't create the card at all
            if (!anchor) {
                return { card: null, body: null };
            }

            card = document.createElement('div');
            card.id = 'booking-summary-card';
            card.className = 'card';
            card.style.marginTop = '24px';
            card.innerHTML =
                '<div class="card-header"><strong>Thông tin đặt sân</strong></div>' +
                '<div class="card-body" id="booking-summary-body">Chưa có khung giờ nào được chọn. <a href="/dat-san">Quay lại đặt sân</a></div>';
            insertAfter(anchor, card);
            body = card.querySelector('#booking-summary-body');
        }

        return { card: card, body: body };
    }

    function render() {
        var refs = ensureCardExists();
        var card = refs.card;
        var body = refs.body;
        if (!card || !body) return; // nothing to do

        var items = [];
        try {
            var raw = localStorage.getItem('tempBooking');
            items = raw ? JSON.parse(raw) || [] : [];
        } catch (e) {
            items = [];
        }

        card.style.display = 'block';

        if (!items.length) {
            body.innerHTML = 'Chưa có khung giờ nào được chọn. <a href="/dat-san">Quay lại đặt sân</a>';
            return;
        }

        var total = 0;
        var html = items
            .map(function (it) {
                var price = Number(it.price) || 0;
                total += price;
                var court = it.court || '';
                var type = it.type || '';
                var date = it.date || '';
                var time = it.time || '';

                return (
                    '<div class="border rounded p-3 mb-3 d-flex justify-content-between">' +
                    '<div>' +
                    '<div class="fw-bold">' +
                    court +
                    ' • ' +
                    type +
                    '</div>' +
                    '<div class="text-muted small">Ngày ' +
                    date +
                    ' • ' +
                    time +
                    '</div>' +
                    '</div>' +
                    '<div class="fw-bold">' +
                    price.toLocaleString('vi-VN') +
                    '₫</div>' +
                    '</div>'
                );
            })
            .join('');

        html +=
            '<div class="d-flex justify-content-between fw-bold pt-3 border-top">' +
            '<div>Tổng tiền</div>' +
            '<div>' +
            total.toLocaleString('vi-VN') +
            '₫</div>' +
            '</div>';

        body.innerHTML = html;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
