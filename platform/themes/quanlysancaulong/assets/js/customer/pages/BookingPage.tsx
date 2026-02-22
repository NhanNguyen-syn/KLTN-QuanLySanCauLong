import { defineComponent, ref, onMounted, watch } from 'vue'
import { TIME_PERIODS, ALL_TIME_SLOTS } from '../components/booking/constants'
import CourtBookingTable from '../components/booking/CourtBookingTable'
import BookingSummary from '../components/booking/BookingSummary'
import { useBookingSlots } from '../hooks/useBookingSlots'
import axios from 'axios'

export default defineComponent({
  name: 'BookingPage',
  props: {
    title: {
      type: String,
      default: 'Bảng Đặt Sân',
    },
    subtitle: {
      type: String,
      default: 'Chọn khung giờ phù hợp trên bảng bên dưới. Bạn có thể chọn nhiều khung giờ liên tiếp hoặc trên nhiều sân khác nhau.',
    },
  },
  setup(props) {
    const selectedDate = ref<string>(new Date().toISOString().split('T')[0])
    const customerData = ref<any>(null)
    const courts = ref<any[]>([])
    const bookedSlots = ref<string[]>([])
    const isLoading = ref(true)

    const { selectedSlots, getSlotStatus, toggleSlot } = useBookingSlots(bookedSlots, selectedDate)
    // Dùng axios trực tiếp với đường dẫn tương đối (tránh lỗi CORS khi deploy)
    const api = axios

    // Helper: read courts injected from server-side rendering (fallback)
    const readInjectedCourts = () => {
      const el = document.getElementById('booking-page-app') as HTMLElement | null
      const raw = el?.getAttribute('data-courts')
      if (!raw) return []
      try {
        const parsed = JSON.parse(raw)
        return Array.isArray(parsed) ? parsed : []
      } catch {
        return []
      }
    }

    const fetchData = async () => {
      isLoading.value = true
      try {
        // 1) Try to use injected courts immediately (for first paint)
        if (courts.value.length === 0) {
          courts.value = readInjectedCourts()
        }

        // 2) Fetch latest data from API (auto-detect base path)
        const [courtsResponse, availabilityResponse] = await Promise.all([
          api.get('/api/court-booking/courts'),
          api.get('/api/court-booking/availability', { params: { date: selectedDate.value } })
        ]);

        if (courtsResponse?.data?.data) {
          courts.value = courtsResponse.data.data
        }

        const slotsArr = availabilityResponse?.data?.data ?? []

        /*
         * Lấy đúng danh sách slot "booked" mà API đã trả về.
         * API đã đảm bảo mỗi item là 1 slot 30-phút đầy đủ thông tin.
         * Chúng ta chỉ cần chuyển về định dạng `${courtId}-${HH:mm}` thống nhất.
         */
        // Chuẩn hóa theo định dạng HH:mm (luôn đủ 2 chữ số) – KHÔNG loại bỏ số 0 ở đầu
        const normalizeHHmm = (t: string): string => {
          const [h = '', m = ''] = t.split(':')
          return `${Number(h).toString().padStart(2, '0')}:${m.padStart(2, '0')}`
        }

        bookedSlots.value = (slotsArr as any[])
          .filter((s) => s.status === 'booked')
          .map((s) => {
            const courtId = s.court_id ?? s.court?.id
            const timeRaw = s.start_time || (String(s.start_at).split(' ')[1]?.substring(0, 5)) || ''
            return `${courtId}-${normalizeHHmm(timeRaw)}`
          })
          .filter(Boolean)
          .filter((v, idx, arr) => arr.indexOf(v) === idx) // unique
        // Debug (temporary): booking availability mapping
        console.log('[BookingPage] selectedDate', selectedDate.value)
        console.log('[BookingPage] availability slots count', slotsArr.length)
        console.log('[BookingPage] bookedSlots', bookedSlots.value.slice(0, 50))
      } catch (error) {
        console.error('Failed to fetch booking data:', error)
        // Fallback: at least show injected courts and keep all slots available
        if (courts.value.length === 0) {
          courts.value = readInjectedCourts()
        }
        bookedSlots.value = []
      } finally {
        isLoading.value = false
      }
    }

    onMounted(() => {
      try {
        const data = localStorage.getItem('customerData')
        if (data) customerData.value = JSON.parse(data)
      } catch { }
      // Preload injected courts for immediate render
      const injected = readInjectedCourts()
      if (injected.length) courts.value = injected
      fetchData()
    })

    watch(selectedDate, fetchData)

    const handleCheckout = () => {
      if (!selectedSlots.value.length) {
        alert('Vui lòng chọn ít nhất một khung giờ')
        return
      }
      const bookingData = selectedSlots.value.map((slot) => {
        const lastDashIndex = slot.lastIndexOf('-')
        const courtId = slot.substring(0, lastDashIndex)
        const time = slot.substring(lastDashIndex + 1)
        const court = courts.value.find((c) => c.id === courtId)
        return {
          court: court?.name,
          courtId,
          type: court?.type,
          date: selectedDate.value,
          time,
          price: (court?.price || 0) / 2,
        }
      })
      // Clear old booking flags so the checkout page treats this as a fresh booking
      localStorage.removeItem('booking_created')
      localStorage.removeItem('order_code')
      localStorage.removeItem('paymentDetails')
      localStorage.setItem('tempBooking', JSON.stringify(bookingData))
      window.location.href = '/thong-tin-ca-nhan'
    }

    // Format date as YYYY-MM-DD in the LOCAL timezone (avoids UTC offset issues)
    const formatDate = (d: Date) => {
      const year = d.getFullYear()
      const month = String(d.getMonth() + 1).padStart(2, '0')
      const day = String(d.getDate()).padStart(2, '0')
      return `${year}-${month}-${day}`
    }

    const getMinDate = () => formatDate(new Date())

    const getMaxDate = () => {
      const max = new Date()
      max.setDate(max.getDate() + 30)
      return formatDate(max)
    }

    return () => (
      <div class="page-booking">
        <section class="sticky-controls-section">
          <div class="container">
            <div class="controls-wrapper">
              <div class="date-picker-control">
                <label class="date-picker-label">
                  <i class="far fa-calendar-alt"></i>
                  Chọn ngày đặt sân
                </label>
                <input
                  type="date"
                  class="date-picker-input"
                  value={selectedDate.value}
                  onInput={(e: any) => (selectedDate.value = e.target.value)}
                  min={getMinDate()}
                  max={getMaxDate()}
                  aria-label="Select booking date"
                />
                <p class="date-picker-helper-text">Có thể đặt trước tối đa 30 ngày</p>
              </div>

              <div class="status-indicators">
                {selectedSlots.value.length > 0 && (
                  <div class="selected-slots-indicator">
                    <div class="selected-slots-icon">{selectedSlots.value.length}</div>
                    <div>
                      <span class="indicator-label">Đã chọn</span>
                      <div class="indicator-value">Khung giờ</div>
                    </div>
                  </div>
                )}

                <div class="info-indicator">
                  <i class="fas fa-info-circle"></i>
                  <p>Nhấp vào ô trống để chọn</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <div class="booking-table-section">
          <div class="container-fluid" style={{ maxWidth: '1600px', margin: '0 auto', padding: '0 1rem' }}>
            <div class="table-header">
              <h2 class="table-title">{props.title}</h2>
              <p class="table-subtitle">{props.subtitle}</p>
            </div>

            {isLoading.value ? (
              <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Đang tải dữ liệu sân...</p>
              </div>
            ) : (
              <CourtBookingTable
                courts={courts.value}
                periods={TIME_PERIODS}
                allTimeSlots={ALL_TIME_SLOTS}
                getSlotStatus={getSlotStatus}
                onToggleSlot={toggleSlot}
              />
            )}
          </div>
        </div>

        <BookingSummary
          courts={courts.value}
          selectedSlots={selectedSlots.value}
          onCheckout={handleCheckout}
        />
      </div>
    )
  },
})
