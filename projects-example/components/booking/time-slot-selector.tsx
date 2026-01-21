"use client"

import type { FC } from "react"

interface TimePeriod {
  period: string
  range: string
  times: string[]
  discount: number
}

interface TimeSlotsProps {
  periods: TimePeriod[]
  selectedCourt: string
  selectedSlots: string[]
  getSlotStatus: (courtId: string, time: string) => string
  onToggleSlot: (courtId: string, time: string) => void
}

export const TimeSlotSelector: FC<TimeSlotsProps> = ({
  periods,
  selectedCourt,
  selectedSlots,
  getSlotStatus,
  onToggleSlot,
}) => {
  return (
    <section className="py-10 md:py-14 pb-32">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 className="text-2xl font-serif font-bold mb-2">Chọn Khung Giờ</h2>
        <p className="text-muted-foreground text-sm mb-8">Nhấp vào các khung giờ trống để thêm vào đơn đặt sân</p>

        <div className="space-y-8">
          {periods.map((period, periodIdx) => (
            <div key={periodIdx}>
              <div className="flex items-center gap-3 mb-4 flex-wrap">
                <span className="w-5 h-5 text-primary">⏱</span>
                <h3 className="text-lg font-bold text-foreground">{period.period}</h3>
                <span className="text-xs text-muted-foreground bg-muted px-2 py-1 rounded-full">{period.range}</span>
                {period.discount > 0 && (
                  <span className="text-xs font-bold text-secondary bg-secondary/10 px-2 py-1 rounded-full">
                    Giảm {Math.round(period.discount * 100)}%
                  </span>
                )}
              </div>

              <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                {period.times.map((time) => {
                  const status = getSlotStatus(selectedCourt, time)
                  const isBooked = status === "booked"
                  const isClosed = status === "closed"
                  const isSelected = status === "selected"

                  return (
                    <button
                      key={`${selectedCourt}-${time}`}
                      onClick={() => onToggleSlot(selectedCourt, time)}
                      disabled={isBooked || isClosed}
                      className={`h-16 rounded-lg border-2 flex items-center justify-center font-semibold text-sm transition-all duration-200 ${
                        isBooked
                          ? "bg-secondary/80 border-secondary text-secondary-foreground cursor-not-allowed opacity-60"
                          : isClosed
                            ? "bg-muted border-muted text-muted-foreground cursor-not-allowed opacity-50"
                            : isSelected
                              ? "bg-primary border-primary text-primary-foreground shadow-lg transform scale-105"
                              : "bg-card border-border text-foreground hover:border-primary hover:bg-muted/50 cursor-pointer"
                      }`}
                      aria-label={`${time} - ${status}`}
                      aria-pressed={isSelected}
                    >
                      {isSelected ? "✓" : time}
                    </button>
                  )
                })}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
