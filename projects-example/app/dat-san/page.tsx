"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState, useEffect } from "react"
import { BookingSummary } from "@/components/booking/booking-summary"
import { CourtBookingTable } from "@/components/booking/court-booking-table"
import { COURTS_DATA, TIME_PERIODS } from "@/components/booking/booking-constants"
import { useBookingSlots } from "@/components/booking/booking-hooks"
import { Calendar, Info } from "lucide-react"

export default function BookingPage() {
  const [selectedDate, setSelectedDate] = useState(new Date().toISOString().split("T")[0])
  const [customerData, setCustomerData] = useState<any>(null)

  const { selectedSlots, getSlotStatus, toggleSlot } = useBookingSlots()

  useEffect(() => {
    const data = localStorage.getItem("customerData")
    if (data) {
      setCustomerData(JSON.parse(data))
    }
  }, [])

  const handleCheckout = () => {
    if (selectedSlots.length === 0) {
      alert("Vui lòng chọn ít nhất một khung giờ")
      return
    }

    const bookingData = selectedSlots.map((slot) => {
      const lastDashIndex = slot.lastIndexOf("-")
      const courtId = slot.substring(0, lastDashIndex)
      const time = slot.substring(lastDashIndex + 1)
      const court = COURTS_DATA.find((c) => c.id === courtId)
      return {
        court: court?.name,
        courtId: courtId,
        type: court?.type,
        date: selectedDate,
        time: time,
        price: customerData?.customerType === "casual" ? court?.price : court?.memberPrice || 0,
      }
    })
    localStorage.setItem("tempBooking", JSON.stringify(bookingData))
    window.location.href = "/thong-tin-ca-nhan"
  }

  const getMinDate = () => {
    const today = new Date()
    return today.toISOString().split("T")[0]
  }

  const getMaxDate = () => {
    const today = new Date()
    const maxDate = new Date(today)
    maxDate.setDate(maxDate.getDate() + 30)
    return maxDate.toISOString().split("T")[0]
  }

  return (
    <div className="min-h-screen flex flex-col bg-gradient-to-b from-background to-muted/20">
      <Navigation />

      <main className="flex-1">
        <section className="relative bg-gradient-to-br from-primary via-primary/95 to-accent text-primary-foreground py-16 md:py-20 overflow-hidden">
          <div className="absolute inset-0 bg-[url('/grid.svg')] opacity-10"></div>
          <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="max-w-3xl">
              <h1 className="text-4xl md:text-5xl lg:text-6xl font-serif font-bold mb-4 text-balance leading-tight">
                Đặt Sân Cầu Lông
              </h1>
              <p className="text-lg md:text-xl text-primary-foreground/90 max-w-2xl text-pretty leading-relaxed">
                Chọn sân và khung giờ phù hợp. Hệ thống đặt sân linh hoạt với khung giờ 30 phút.
              </p>
            </div>
          </div>
        </section>

        <section className="bg-card/80 backdrop-blur-sm border-y border-border py-6 sticky top-16 z-40 shadow-md">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
              <div className="flex-1 max-w-md">
                <label className="flex items-center gap-2 text-sm font-semibold text-foreground mb-3">
                  <Calendar className="w-4 h-4 text-primary" />
                  Chọn ngày đặt sân
                </label>
                <input
                  type="date"
                  value={selectedDate}
                  onChange={(e) => setSelectedDate(e.target.value)}
                  min={getMinDate()}
                  max={getMaxDate()}
                  className="w-full px-5 py-3.5 rounded-xl text-foreground font-semibold bg-background border-2 border-border focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all shadow-sm"
                  aria-label="Select booking date"
                />
                <p className="text-xs text-muted-foreground mt-2 font-medium">Có thể đặt trước tối đa 30 ngày</p>
              </div>

              <div className="flex items-center gap-6">
                {selectedSlots.length > 0 && (
                  <div className="flex items-center gap-3 px-5 py-3 bg-gradient-to-br from-secondary/20 to-accent/20 rounded-xl border-2 border-secondary/40 shadow-sm">
                    <div className="w-10 h-10 rounded-full bg-secondary flex items-center justify-center">
                      <span className="text-secondary-foreground font-bold text-lg">{selectedSlots.length}</span>
                    </div>
                    <div>
                      <span className="text-xs text-muted-foreground font-medium uppercase">Đã chọn</span>
                      <div className="text-sm font-bold text-foreground">Khung giờ</div>
                    </div>
                  </div>
                )}

                <div className="hidden md:flex items-center gap-2 px-4 py-3 bg-blue-50 dark:bg-blue-950/20 rounded-xl border border-blue-200 dark:border-blue-800">
                  <Info className="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                  <p className="text-xs text-blue-700 dark:text-blue-300 font-medium">Nhấp vào ô trống để chọn</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <div className="py-10 md:py-14 pb-32">
          <div className="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div className="mb-8">
              <h2 className="text-2xl md:text-3xl font-serif font-bold text-foreground mb-2">Bảng Đặt Sân</h2>
              <p className="text-sm md:text-base text-muted-foreground max-w-2xl text-pretty">
                Chọn khung giờ phù hợp trên bảng bên dưới. Bạn có thể chọn nhiều khung giờ liên tiếp hoặc trên nhiều sân
                khác nhau.
              </p>
            </div>

            <CourtBookingTable
              courts={COURTS_DATA}
              periods={TIME_PERIODS}
              selectedSlots={selectedSlots}
              getSlotStatus={getSlotStatus}
              onToggleSlot={toggleSlot}
            />
          </div>
        </div>
      </main>

      <BookingSummary courts={COURTS_DATA} selectedSlots={selectedSlots} onCheckout={handleCheckout} />

      <Footer />
    </div>
  )
}
