import { defineComponent, ref } from 'vue'

// Simple admin view with mock data to be replaced later
export default defineComponent({
  name: 'AdminBookingManagementPage',
  setup() {
    const date = ref<string>(new Date().toISOString().split('T')[0])

    const rows = ref([
      { id: 1, customer: 'Nguyễn Văn A', phone: '0901 234 567', court: 'Sân 1', date: date.value, time: '18:00', price: 80000, status: 'Pending' },
      { id: 2, customer: 'Trần Thị B', phone: '0902 345 678', court: 'Sân 2', date: date.value, time: '19:00', price: 80000, status: 'Confirmed' },
    ])

    return () => (
      <div class="container py-4">
        <h1 class="h3 fw-bold mb-3">Quản lý đặt sân (Mẫu)</h1>
        <div class="card shadow-sm">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Điện thoại</th>
                    <th>Sân</th>
                    <th>Ngày</th>
                    <th>Giờ</th>
                    <th class="text-end">Giá</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                  {rows.value.map(r => (
                    <tr key={r.id}>
                      <td>{r.id}</td>
                      <td>{r.customer}</td>
                      <td>{r.phone}</td>
                      <td>{r.court}</td>
                      <td>{r.date}</td>
                      <td>{r.time}</td>
                      <td class="text-end">{r.price.toLocaleString('vi-VN')}₫</td>
                      <td>
                        <span class="badge bg-secondary">{r.status}</span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    )
  },
})

