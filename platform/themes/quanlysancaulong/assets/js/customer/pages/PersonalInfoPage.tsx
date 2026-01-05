import { defineComponent, ref, onMounted, computed, PropType } from 'vue'

interface TempBookingItem {
  court: string
  courtId: string
  type?: string
  date: string
  time: string
  price: number
}

export default defineComponent({
  name: 'PersonalInfoPage',
  props: {
    title: { type: String as PropType<string>, default: 'Thông Tin Cá Nhân' },
    subtitle: { type: String as PropType<string>, default: 'Vui lòng cung cấp thông tin liên hệ để hoàn tất đặt sân' },
  },
  setup(props) {
    const fullName = ref('')
    const email = ref('')
    const phone = ref('')
    const tempBooking = ref<TempBookingItem[]>([])

    const total = computed(() => tempBooking.value.reduce((s, i) => s + (Number(i.price) || 0), 0))

    onMounted(() => {
      // load draft customer data
      try {
        const cd = localStorage.getItem('customerData')
        if (cd) {
          const parsed = JSON.parse(cd)
          fullName.value = parsed.fullName || ''
          email.value = parsed.email || ''
          phone.value = parsed.phone || ''
        }
      } catch {}

      // load chosen slots
      try {
        const raw = localStorage.getItem('tempBooking')
        if (raw) tempBooking.value = JSON.parse(raw)
      } catch {}
    })

    const handleSubmit = (e: Event) => {
      e.preventDefault()
      if (!fullName.value.trim()) {
        alert('Vui lòng nhập Họ và tên')
        return
      }
      if (!email.value.trim()) {
        alert('Vui lòng nhập Email')
        return
      }
      if (!phone.value.trim()) {
        alert('Vui lòng nhập Số điện thoại')
        return
      }

      localStorage.setItem(
        'customerData',
        JSON.stringify({ fullName: fullName.value, email: email.value, phone: phone.value, customerType: 'casual' })
      )

      // next step -> go to checkout page
      window.location.assign('/thanh-toan')
    }

    return () => (
      <div class="personal-info-page">
        <section class="hero-section">
          <div class="hero-grid-overlay"></div>
          <div class="container">
            <div class="hero-content">
              <h1 class="hero-title">{props.title}</h1>
              <p class="hero-subtitle">{props.subtitle}</p>
            </div>
          </div>
        </section>

        <div class="container" style={{maxWidth: '1000px', margin: '0 auto'}}>
          <div class="card" style={{marginTop: '24px'}}>
            <div class="card-header"><strong>Thông tin liên hệ</strong></div>
            <div class="card-body">
              <form onSubmit={handleSubmit}>
                <div class="mb-3">
                  <label class="form-label">Họ và tên</label>
                  <input class="form-control" type="text" value={fullName.value} onInput={(e: any) => fullName.value = e.target.value} placeholder="Nguyễn Văn A" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input class="form-control" type="email" value={email.value} onInput={(e: any) => email.value = e.target.value} placeholder="email@domain.com" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Số điện thoại</label>
                  <input class="form-control" type="tel" value={phone.value} onInput={(e: any) => phone.value = e.target.value} placeholder="0912345678" />
                </div>
                <button type="submit" class="btn btn-primary">Tiếp tục thanh toán</button>
                <a href="/dat-san" class="btn btn-link ms-2">Quay lại đặt sân</a>
              </form>
            </div>
          </div>

          <div class="card" style={{marginTop: '24px'}}>
            <div class="card-header"><strong>Thông tin đặt sân</strong></div>
            <div class="card-body">
              {tempBooking.value.length === 0 ? (
                <p>Chưa có khung giờ nào được chọn. <a href="/dat-san">Quay lại đặt sân</a></p>
              ) : (
                <div>
                  {tempBooking.value.map((item, idx) => (
                    <div class="border rounded p-3 mb-3" key={idx}>
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="fw-bold">{item.court} • {item.type}</div>
                                <div class="text-muted small">Ngày {item.date} • {item.time}</div>
                            </div>
                            <div class="fw-bold">{(Number(item.price) || 0).toLocaleString('vi-VN')}₫</div>
                        </div>
                    </div>
                  ))}
                  <div class="d-flex justify-content-between fw-bold pt-3 border-top">
                    <div>Tổng tiền</div>
                    <div>{total.value.toLocaleString('vi-VN')}₫</div>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    )
  }
})

