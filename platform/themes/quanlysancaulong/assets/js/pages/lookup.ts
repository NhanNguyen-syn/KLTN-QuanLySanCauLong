type LookupResponse = { success: true; data: any } | { success: false; message: string };

const statusMap: Record<string, { label: string; cls: string }> = {
    processing: { label: 'Đang xử lý', cls: 'badge badge--blue' },
    pending: { label: 'Chờ thanh toán', cls: 'badge badge--blue' },
    paid: { label: 'Đã thanh toán', cls: 'badge badge--green' },
    completed: { label: 'Hoàn thành', cls: 'badge badge--green' },
    cancelled: { label: 'Đã hủy', cls: 'badge badge--red' },
    refunded: { label: 'Hoàn tiền', cls: 'badge badge--amber' }
};

function money(n: number) {
    try {
        return n.toLocaleString('vi-VN') + 'đ';
    } catch {
        return `${n}đ`;
    }
}

function el<T extends HTMLElement>(id: string) {
    return document.getElementById(id) as T | null;
}

async function fetchLookup(orderCode: string): Promise<LookupResponse> {
    const url = `/api/court-booking/lookup?order_code=${encodeURIComponent(orderCode)}`;
    const res = await fetch(url, { headers: { Accept: 'application/json' } });
    const json = await res.json().catch(() => null);
    if (!res.ok) {
        return { success: false, message: json?.message || 'NOT_FOUND' };
    }
    return json as LookupResponse;
}

function renderNotFound(orderCode: string) {
    const result = el<HTMLDivElement>('lookup-result');
    if (!result) return;
    result.hidden = false;
    result.innerHTML = `
    <div class="lookup-card lookup-card--empty">
      <div class="empty-icon">✕</div>
      <h3>Không tìm thấy</h3>
      <p>Mã hóa đơn <strong>${orderCode}</strong> không tồn tại trong hệ thống.</p>
      <div class="empty-hint">Vui lòng kiểm tra lại hoặc liên hệ hotline.</div>
    </div>
  `;
}

function renderSuccess(data: any) {
    const result = el<HTMLDivElement>('lookup-result');
    if (!result) return;

    const status = statusMap[data.status] || { label: data.status, cls: 'badge badge--gray' };
    const itemsHtml = (data.items || [])
        .map(
            (it: any) => `
      <div class="item-row">
        <div class="item-main">
          <div class="item-title">${it.court_name || 'Sân'}</div>
          <div class="item-sub">${it.date} • ${it.start_time} - ${it.end_time}</div>
        </div>
        <div class="item-side">
          <div class="item-price">${money(Number(it.price || 0))}</div>
          <div class="item-paid">Đã cọc: ${money(Number(it.paid_amount || 0))}</div>
        </div>
      </div>
    `
        )
        .join('');

    result.hidden = false;
    result.innerHTML = `
    <div class="lookup-card">
      <div class="lookup-card__head">
        <div>
          <div class="code">Mã hóa đơn: <strong>${data.order_code}</strong></div>
          <div class="meta">Cập nhật: ${data.updated_at || ''}</div>
        </div>
        <div class="${status.cls}">${status.label}</div>
      </div>

      <div class="lookup-card__body">
        <div class="grid">
          <div class="panel">
            <div class="panel__title">Thông tin đơn</div>
            <div class="kv"><span>Khách hàng</span><span>${data.customer_name || '—'}</span></div>
            <div class="kv"><span>Liên hệ</span><span>${data.contact || '—'}</span></div>
            <div class="kv"><span>Ghi chú</span><span>${data.notes || '—'}</span></div>
          </div>

          <div class="panel">
            <div class="panel__title">Tổng tiền</div>
            <div class="total">
              <div class="total__row"><span>Tổng giá</span><strong>${money(Number(data.total_price || 0))}</strong></div>
              <div class="total__row"><span>Đã cọc</span><strong>${money(Number(data.total_paid || 0))}</strong></div>
            </div>
          </div>
        </div>

        <div class="panel panel--list">
          <div class="panel__title">Chi tiết sân</div>
          ${itemsHtml}
        </div>
      </div>
    </div>
  `;
}

function setLoading(loading: boolean) {
    const btn = el<HTMLButtonElement>('lookup-btn');
    const input = el<HTMLInputElement>('order-code');
    if (btn) {
        btn.disabled = loading || !(input?.value || '').trim();
        const t = btn.querySelector('.lookup-btn__text');
        if (t) t.textContent = loading ? 'Đang tìm...' : 'Tra cứu';
    }
}

function init() {
    const input = el<HTMLInputElement>('order-code');
    const btn = el<HTMLButtonElement>('lookup-btn');
    if (!input || !btn) return;

    const run = async () => {
        const code = (input.value || '').trim().toUpperCase();
        input.value = code;
        if (!code) return;

        setLoading(true);
        const resp = await fetchLookup(code);
        setLoading(false);

        if (!resp.success) {
            renderNotFound(code);
            return;
        }
        renderSuccess(resp.data);
    };

    input.addEventListener('input', () => {
        btn.disabled = !(input.value || '').trim();
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Enter') run();
    });

    btn.addEventListener('click', run);
}

document.addEventListener('DOMContentLoaded', init);
