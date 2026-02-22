"use client"

import { type FC, useMemo } from "react"

interface BookingItem {
  id: string
  court: string
  date: string
  time: string
  price: number
}

interface BookingComparisonProps {
  selectedSlots: string[]
  courts: Array<{ id: string; name: string; price: number }>
}

export const BookingComparison: FC<BookingComparisonProps> = ({ selectedSlots, courts }) => {
  const bookingItems = useMemo(() => {
    return selectedSlots.map((slot, idx) => {
      const lastDashIndex = slot.lastIndexOf("-")
      const courtId = slot.substring(0, lastDashIndex)
      const time = slot.substring(lastDashIndex + 1)
      const court = courts.find((c) => c.id === courtId)

      return {
        id: `${idx}-${slot}`,
        court: court?.name || "Unknown",
        time,
        price: court?.price || 0,
      }
    })
  }, [selectedSlots, courts])

  const groupedByTime = useMemo(() => {
    return bookingItems.reduce(
      (acc, item) => {
        if (!acc[item.time]) acc[item.time] = []
        acc[item.time].push(item)
        return acc
      },
      {} as Record<string, typeof bookingItems>,
    )
  }, [bookingItems])

  const totalPrice = bookingItems.reduce((sum, item) => sum + item.price, 0)
  const totalSlots = bookingItems.length

  return (
    <div className="bg-card rounded-xl border border-border p-6">
      <h3 className="text-lg font-semibold text-foreground mb-4">So sánh Đặt Sân</h3>

      <div className="space-y-4">
        {Object.entries(groupedByTime).map(([time, items]) => (
          <div key={time} className="bg-muted/30 rounded-lg p-4 border border-border">
            <div className="flex items-center gap-2 mb-3">
              <span className="text-sm font-semibold text-foreground">Khung giờ: {time}</span>
              <span className="text-xs font-semibold bg-primary text-primary-foreground px-2 py-1 rounded-full">
                {items.length} sân
              </span>
            </div>

            <div className="space-y-2">
              {items.map((item) => (
                <div key={item.id} className="flex items-center justify-between text-sm">
                  <span className="text-foreground font-medium">{item.court}</span>
                  <span className="text-muted-foreground">{item.price.toLocaleString("vi-VN")}đ</span>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>

      <div className="mt-6 pt-6 border-t border-border">
        <div className="grid grid-cols-2 gap-4">
          <div className="bg-primary/5 rounded-lg p-3 border border-primary/20">
            <p className="text-xs text-muted-foreground mb-1">Tổng khung giờ</p>
            <p className="text-2xl font-bold text-foreground">{totalSlots}</p>
          </div>
          <div className="bg-accent/5 rounded-lg p-3 border border-accent/20">
            <p className="text-xs text-muted-foreground mb-1">Tổng tiền</p>
            <p className="text-2xl font-bold text-foreground">{totalPrice.toLocaleString("vi-VN")}đ</p>
          </div>
        </div>
      </div>
    </div>
  )
}
