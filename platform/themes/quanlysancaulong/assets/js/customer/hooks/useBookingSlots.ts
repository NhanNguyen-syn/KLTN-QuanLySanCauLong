import { ref, Ref } from 'vue'

export type SlotStatus = 'available' | 'selected' | 'booked' | 'closed'

export function useBookingSlots(bookedSlots: Ref<string[]>, selectedDate: Ref<string>) {
  const selectedSlots = ref<string[]>([])
  // Chuẩn hóa định dạng HH:mm để đồng nhất (luôn 2 chữ số giờ, phút)
  const normalizeTime = (time: string): string => {
    const [h = '', m = ''] = time.split(':')
    return `${Number(h).toString().padStart(2, '0')}:${m.padStart(2, '0')}`
  }

  const getSlotStatus = (courtId: string, time: string): SlotStatus => {
    const normalized = normalizeTime(time)
    const slotId = `${courtId}-${normalized}`

    // ƯU TIÊN #1: Nếu slot đã được đặt hoặc đã được chọn bởi người dùng hiện tại.
    if (bookedSlots.value.includes(slotId)) {
      // Debug: only log booked hits when needed
      // console.log('[getSlotStatus] HIT booked', slotId)
      return 'booked'
    }
    if (selectedSlots.value.includes(slotId)) return 'selected'

    // ƯU TIÊN #2: Xử lý các trạng thái đóng cửa (khung giờ không hợp lệ hoặc đã qua)
    const [hourStr, minuteStr] = time.split(':')
    const hour = Number.parseInt(hourStr)
    const minute = Number.parseInt(minuteStr)

    // Chặn các khung giờ trước 5h sáng
    if (hour < 5) return 'closed'

    // Xác định ngày hiện tại & ngày đang được chọn (giữ nguyên múi giờ LOCAL)
    const now = new Date()
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate()) // 00:00:00 LOCAL

    // selectedDate.value có định dạng ISO (YYYY-MM-DD). Chuyển sang Date LOCAL để so sánh tin cậy
    const [y, m, d] = selectedDate.value.split('-').map(Number)
    const selectedDay = new Date(y, (m || 1) - 1, d || 1)

    // Nếu ngày đang chọn đã ở trong quá khứ → khóa tất cả slot
    if (selectedDay < today) {
      return 'closed'
    }

    // Nếu là ngày hôm nay và khung giờ đã qua → "closed"
    if (selectedDay.getTime() === today.getTime()) {
      const slotTime = new Date(y, (m || 1) - 1, d || 1, hour, minute)
      if (slotTime <= now) {
        return 'closed'
      }
    }

    return 'available'
  }

  const toggleSlot = (courtId: string, time: string) => {
    // Bảo đảm slotId luôn ở định dạng chuẩn để so sánh chính xác
    const normalized = normalizeTime(time)
    const slotId = `${courtId}-${normalized}`
    const status = getSlotStatus(courtId, time)

    if (status === 'booked' || status === 'closed') {
      return
    }

    const index = selectedSlots.value.indexOf(slotId)
    if (index > -1) {
      selectedSlots.value.splice(index, 1)
    } else {
      selectedSlots.value.push(slotId)
    }
  }

  const clearSlots = () => {
    selectedSlots.value = []
  }

  return {
    selectedSlots,
    getSlotStatus,
    toggleSlot,
    clearSlots,
  }
}

export function useBookingDates() {
  const selectedDates = ref<string[]>([])

  const toggleDate = (date: string) => {
    const index = selectedDates.value.indexOf(date)
    if (index > -1) {
      selectedDates.value.splice(index, 1)
    } else {
      selectedDates.value.push(date)
    }
  }

  const clearDates = () => {
    selectedDates.value = []
  }

  return {
    selectedDates,
    toggleDate,
    clearDates,
  }
}

