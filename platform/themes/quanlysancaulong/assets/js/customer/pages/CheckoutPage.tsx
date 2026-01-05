import { defineComponent, reactive, ref, computed, onMounted } from 'vue'

interface BookingItem {
  court?: string
  courtId?: string
  date: string
  time: string
  price: number
}

export default defineComponent({
  name: 'CheckoutPage',
  setup() {
    const personalInfo = ref<any>(null)
    const customerData = ref<any>(null)
    const bookingData = ref<BookingItem[]>([])

    const formData = reactive({
      paymentMethod: 'bank-transfer', // 'vnpay'
      paymentType: 'full', // 'deposit'
    })

    const orderPlaced = ref(false)

    onMounted(() => {
      try {
        const p = localStorage.getItem('personalInfo')
        if (p) personalInfo.value = JSON.parse(p)
      } catch {}
      try {
        const c = localStorage.getItem('customerData')
        if (c) customerData.value = JSON.parse(c)
      } catch {}
      try {
        const b = localStorage.getItem('tempBooking')
        if (b) bookingData.value = JSON.parse(b)
      } catch {}
    })

    const isCasualCustomer = computed(() => (customerData.value?.customerType || 'casual') === 'casual')

    const total = computed(() => bookingData.value.reduce((s, i) => s + (Number(i.price) || 0), 0))
    const depositAmount = computed(() => Math.round(total.value * 0.3))
    const paymentAmount = computed(() => (formData.paymentType === 'deposit' && isCasualCustomer.value) ? depositAmount.value : total.value)

    const calculateDuration = () => {
      if (!bookingData.value.length) return '0h'
      const hours = bookingData.value.length * 0.5
      return `${hours}h`
    }

    const getTimeRange = () => {
      const times = bookingData.value.map(i => i.time).sort()
      if (!times.length) return ''
      if (times.length === 1) return times[0]
      return `${times[0]} - ${times[times.length - 1]}`
    }

    const getDisplayName = () => personalInfo.value?.fullName || customerData.value?.fullName || ''
    const getDisplayEmail = () => personalInfo.value?.email || customerData.value?.email || ''
    const getDisplayPhone = () => personalInfo.value?.phone || customerData.value?.phone || ''

    const submit = (e: Event) => {
      e.preventDefault()
      // TODO: integrate real payment. For now, just mark order placed
      orderPlaced.value = true
    }

    const orderId = computed(() => {
      const n = Math.floor(Math.random() * 999999).toString().padStart(6, '0')
      return `#BD${n}`
    })

    return () => (
      <div class="checkout-page container" style={{maxWidth:'1100px', margin:'24px auto'}}>
        {orderPlaced.value ? (
          <div class="text-center" style={{padding:'60px 0'}}>
            <div class="mb-3">
              <span class="badge bg-success" style={{fontSize:'16px'}}>Đặt sân thành công</span>
            </div>
            <h1 class="h2 mb-2">Đặt Sân Thành Công!</h1>
            <p class="text-muted mb-4">Cảm ơn bạn đã đặt sân. Chúng tôi sẽ gửi thông tin chi tiết qua email.</p>
            <div class="card mx-auto" style={{maxWidth:'520px'}}>
              <div class="card-body">
                <div class="d-flex justify-content-between"><span>Mã đơn hàng</span><strong>{orderId.value}</strong></div>
                <div class="d-flex justify-content-between mt-2"><span>Trạng thái</span><span class="text-success fw-bold">Đã xác nhận</span></div>
              </div>
            </div>
            <a href="/" class="btn btn-primary mt-4">Về Trang Chủ</a>
          </div>
        ) : (
          <div class="row g-4">
            <div class="col-lg-8">
              <form onSubmit={submit} class="card">
                <div class="card-body">
                  <h5 class="card-title">Phương thức thanh toán</h5>
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="pm1" value="bank-transfer" checked={formData.paymentMethod==='bank-transfer'} onChange={(e:any)=>formData.paymentMethod=e.target.value} />
                    <label class="form-check-label" for="pm1">Chuyển khoản ngân hàng</label>
                  </div>
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="pm2" value="vnpay" checked={formData.paymentMethod==='vnpay'} onChange={(e:any)=>formData.paymentMethod=e.target.value} />
                    <label class="form-check-label" for="pm2">VNPay</label>
                  </div>

                  {isCasualCustomer.value && (
                    <div class="mt-4">
                      <h6>Hình thức thanh toán</h6>
                      <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="paymentType" id="pt1" value="full" checked={formData.paymentType==='full'} onChange={(e:any)=>formData.paymentType=e.target.value} />
                        <label class="form-check-label" for="pt1">Thanh toán toàn bộ</label>
                      </div>
                      <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="paymentType" id="pt2" value="deposit" checked={formData.paymentType==='deposit'} onChange={(e:any)=>formData.paymentType=e.target.value} />
                        <label class="form-check-label" for="pt2">Đặt cọc 30%</label>
                      </div>
                    </div>
                  )}

                  {formData.paymentMethod === 'bank-transfer' && (
                    <div class="mt-4 p-3 bg-light rounded">
                      <div><small class="text-muted text-uppercase">Ngân hàng</small><div class="fw-bold">Vietcombank</div></div>
                      <div class="mt-2"><small class="text-muted text-uppercase">Số tài khoản</small><div class="fw-bold text-primary">0123456789</div></div>
                      <div class="mt-2"><small class="text-muted text-uppercase">Chủ tài khoản</small><div class="fw-bold">BADMINTON COURT CENTER</div></div>
                      <div class="mt-2"><small class="text-muted text-uppercase">Nội dung</small><div class="fw-bold"><code>{getDisplayName() || '[TEN BAN]'} - DAT SAN</code></div></div>
                    </div>
                  )}

                  {formData.paymentMethod === 'vnpay' && (
                    <div class="alert alert-info mt-4" role="alert">
                      Bạn sẽ được chuyển đến cổng thanh toán VNPay để hoàn tất giao dịch một cách an toàn.
                    </div>
                  )}

                  <button type="submit" class="btn btn-primary w-100 mt-4">
                    {formData.paymentMethod === 'vnpay' ? 'Thanh Toán Với VNPay' : 'Xác Nhận Thanh Toán'}
                  </button>
                </div>
              </form>
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tóm tắt đơn hàng</h5>

                  {(personalInfo.value || customerData.value) && (
                    <div class="mb-3">
                      <div class="small text-muted text-uppercase">Thông tin đặt sân</div>
                      <div class="mt-2">Họ và tên: <strong>{getDisplayName()}</strong></div>
                      <div>Email: <strong>{getDisplayEmail()}</strong></div>
                      <div>SĐT: <strong>{getDisplayPhone()}</strong></div>
                    </div>
                  )}

                  {!!bookingData.value.length && (
                    <div class="mb-3">
                      <div class="small text-muted text-uppercase">Lịch đặt sân</div>
                      <div class="mt-2">Ngày: <strong>{bookingData.value[0].date}</strong></div>
                      <div>Khung giờ: <strong>{getTimeRange()}</strong></div>
                      <div>Thời lượng: <strong>{calculateDuration()}</strong></div>
                    </div>
                  )}

                  <div class="d-flex justify-content-between">
                    <span>Tổng tiền sân</span>
                    <strong>{total.value.toLocaleString('vi-VN')}đ</strong>
                  </div>
                  {formData.paymentType === 'deposit' && isCasualCustomer.value && (
                    <div class="d-flex justify-content-between text-muted mt-1">
                      <span>Đặt cọc 30%</span>
                      <strong class="text-success">{depositAmount.value.toLocaleString('vi-VN')}đ</strong>
                    </div>
                  )}
                  <hr />
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold">Cần thanh toán</span>
                    <span class="h4 m-0 text-primary">{paymentAmount.value.toLocaleString('vi-VN')}đ</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
    )
  }
})

