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
    const submitted = ref(false)

    const total = computed(() => tempBooking.value.reduce((s, i) => s + (Number(i.price) || 0), 0))

    // --- Validation rules ---
    const nameError = computed(() => {
      if (!fullName.value.trim()) return 'Vui lòng nhập họ và tên'
      if (!/^[\p{L}\p{N}\s]+$/u.test(fullName.value.trim())) return 'Họ và tên chỉ được chứa chữ cái, số và khoảng trắng'
      return ''
    })

    const emailError = computed(() => {
      if (!email.value.trim()) return 'Vui lòng nhập email'
      if (!email.value.includes('@')) return 'Email phải chứa ký tự @'
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) return 'Vui lòng nhập đúng định dạng email (ví dụ: email@domain.com)'
      return ''
    })

    const phoneError = computed(() => {
      if (!phone.value.trim()) return 'Vui lòng nhập số điện thoại'
      if (!/^\d+$/.test(phone.value.trim())) return 'Số điện thoại chỉ được chứa chữ số'
      if (phone.value.trim().length > 12) return 'Số điện thoại không được quá 12 số'
      if (phone.value.trim().length < 9) return 'Số điện thoại phải có ít nhất 9 số'
      return ''
    })

    const isFormValid = computed(() => !nameError.value && !emailError.value && !phoneError.value)

    // Phone: only allow digits
    const handlePhoneInput = (e: any) => {
      const val = e.target.value.replace(/\D/g, '').slice(0, 12)
      phone.value = val
      e.target.value = val
    }

    // Name: allow text + numbers + spaces only
    const handleNameInput = (e: any) => {
      fullName.value = e.target.value
    }

    onMounted(() => {
      try {
        const cd = localStorage.getItem('customerData')
        if (cd) {
          const parsed = JSON.parse(cd)
          fullName.value = parsed.fullName || ''
          email.value = parsed.email || ''
          phone.value = parsed.phone || ''
        }
      } catch {}

      try {
        const raw = localStorage.getItem('tempBooking')
        if (raw) tempBooking.value = JSON.parse(raw)
      } catch {}
    })

    const handleSubmit = (e: Event) => {
      e.preventDefault()
      submitted.value = true

      if (!isFormValid.value) return

      localStorage.setItem(
        'customerData',
        JSON.stringify({ fullName: fullName.value, email: email.value, phone: phone.value, customerType: 'casual' })
      )

      window.location.assign('/thanh-toan')
    }

    const errorStyle = {
      color: '#dc3545',
      fontSize: '12px',
      marginTop: '4px',
      display: 'flex',
      alignItems: 'center',
      gap: '4px',
    } as any

    return () => (
      <div class="personal-info-page">
        {/* Scoped styles for button hover effect */}
        <style>{`
          .pi-submit-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
          }
          .pi-submit-btn:not(:disabled)::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100%;
            background: linear-gradient(
              120deg,
              transparent 0%,
              rgba(255, 255, 255, 0.2) 30%,
              rgba(255, 255, 255, 0.55) 50%,
              rgba(255, 255, 255, 0.2) 70%,
              transparent 100%
            );
            transition: left 0.7s ease;
            z-index: 1;
            pointer-events: none;
          }
          .pi-submit-btn:not(:disabled):hover {
            transform: translateY(-3px) scale(1.03) !important;
            box-shadow: 0 10px 28px rgba(6, 95, 70, 0.4), 0 0 16px rgba(5, 150, 105, 0.2) !important;
            filter: brightness(1.1);
          }
          .pi-submit-btn:not(:disabled):hover::before {
            left: 160%;
          }
          .pi-submit-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            filter: grayscale(0.3);
          }
          .pi-field-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.15) !important;
          }
          .pi-field-valid {
            border-color: #059669 !important;
            box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1) !important;
          }
        `}</style>
        <div class="container" style={{maxWidth: '1000px', margin: '0 auto'}}>
          <div class="card" style={{marginTop: '24px'}}>
            <div class="card-header"><strong>Thông tin liên hệ</strong></div>
            <div class="card-body">
              <form onSubmit={handleSubmit} novalidate>
                {/* Họ và tên */}
                <div class="mb-3">
                  <label class="form-label">Họ và tên <span style={{color: '#dc3545'}}>*</span></label>
                  <input
                    class={`form-control ${submitted.value ? (nameError.value ? 'pi-field-error' : 'pi-field-valid') : ''}`}
                    type="text"
                    value={fullName.value}
                    onInput={handleNameInput}
                    placeholder="Nguyễn Văn A"
                  />
                  {submitted.value && nameError.value && (
                    <div style={errorStyle}>
                      <span>⚠</span> {nameError.value}
                    </div>
                  )}
                </div>

                {/* Email */}
                <div class="mb-3">
                  <label class="form-label">Email <span style={{color: '#dc3545'}}>*</span></label>
                  <input
                    class={`form-control ${submitted.value ? (emailError.value ? 'pi-field-error' : 'pi-field-valid') : ''}`}
                    type="email"
                    value={email.value}
                    onInput={(e: any) => email.value = e.target.value}
                    placeholder="email@domain.com"
                  />
                  {submitted.value && emailError.value && (
                    <div style={errorStyle}>
                      <span>⚠</span> {emailError.value}
                    </div>
                  )}
                </div>

                {/* Số điện thoại */}
                <div class="mb-3">
                  <label class="form-label">Số điện thoại <span style={{color: '#dc3545'}}>*</span></label>
                  <input
                    class={`form-control ${submitted.value ? (phoneError.value ? 'pi-field-error' : 'pi-field-valid') : ''}`}
                    type="tel"
                    value={phone.value}
                    onInput={handlePhoneInput}
                    placeholder="0912345678"
                    maxlength={12}
                    inputmode="numeric"
                  />
                  {submitted.value && phoneError.value && (
                    <div style={errorStyle}>
                      <span>⚠</span> {phoneError.value}
                    </div>
                  )}
                  {!phoneError.value && phone.value && (
                    <div style={{color: '#6b7280', fontSize: '12px', marginTop: '4px'}}>
                      {phone.value.length}/12 số
                    </div>
                  )}
                </div>

                <button
                  type="submit"
                  class="btn btn-primary pi-submit-btn"
                  disabled={submitted.value && !isFormValid.value}
                  style={{ position: 'relative' }}
                >
                  <span style={{ position: 'relative', zIndex: 2 }}>Tiếp tục thanh toán</span>
                </button>
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
