"use client"

import type { FC } from "react"
import { useState } from "react"

interface Court {
  id: string
  name: string
  price: number
  memberPrice: number
  type: string
  icon: string
}

interface TimePeriod {
  period: string
  range: string
  times: string[]
  discount: number
}

interface CourtBookingTableProps {
  courts: Court[]
  periods: TimePeriod[]
  selectedSlots: string[]
  getSlotStatus: (courtId: string, time: string) => string
  onToggleSlot: (courtId: string, time: string) => void
}

export const CourtBookingTable: FC<CourtBookingTableProps> = ({
  courts,
  periods,
  selectedSlots,
  getSlotStatus,
  onToggleSlot,
}) => {
  const [hoveredSlot, setHoveredSlot] = useState<string | null>(null)

  // Generate all time slots in 30-minute intervals
  const allTimeSlots = periods.flatMap((p) => p.times)

  // Get period for a specific time
  const getPeriodForTime = (time: string) => {
    return periods.find((p) => p.times.includes(time))
  }

  return (
    <div className="w-full">
      <div className="overflow-x-auto rounded-2xl border-2 border-border bg-card shadow-xl">
        <table className="w-full border-collapse">
          <thead>
            <tr className="bg-gradient-to-r from-primary via-primary/95 to-accent">
              <th className="sticky left-0 z-20 bg-primary px-6 py-5 text-left font-bold text-primary-foreground border-r-2 border-primary-foreground/30 min-w-[140px]">
                <div className="text-base">Sân</div>
              </th>
              {allTimeSlots.map((time, idx) => {
                const period = getPeriodForTime(time)
                return (
                  <th
                    key={idx}
                    className="px-4 py-4 text-center font-semibold text-primary-foreground border-r border-primary-foreground/10 min-w-[110px]"
                  >
                    <div className="text-base font-bold whitespace-nowrap">{time}</div>
                    {period && (
                      <div className="text-[10px] opacity-80 mt-1 whitespace-nowrap font-medium">{period.period}</div>
                    )}
                  </th>
                )
              })}
            </tr>
          </thead>
          <tbody>
            {courts.map((court, courtIdx) => (
              <tr
                key={court.id}
                className={`${
                  courtIdx % 2 === 0 ? "bg-background" : "bg-muted/40"
                } hover:bg-muted/60 transition-colors`}
              >
                <td className="sticky left-0 z-10 px-6 py-4 font-bold text-foreground border-r-2 border-border bg-inherit shadow-sm">
                  <div className="flex items-center gap-3">
                    <span className="text-2xl">{court.icon}</span>
                    <div>
                      <div className="text-sm font-bold">{court.name}</div>
                      <div className="text-xs text-muted-foreground font-normal mt-0.5">
                        {court.price.toLocaleString()}đ/h
                      </div>
                    </div>
                  </div>
                </td>
                {allTimeSlots.map((time, timeIdx) => {
                  const slotKey = `${court.id}-${time}`
                  const status = getSlotStatus(court.id, time)
                  const isBooked = status === "booked"
                  const isClosed = status === "closed"
                  const isSelected = status === "selected"
                  const isHovered = hoveredSlot === slotKey

                  return (
                    <td key={slotKey} className="p-1.5 border-r border-border/50">
                      <button
                        onClick={() => onToggleSlot(court.id, time)}
                        onMouseEnter={() => setHoveredSlot(slotKey)}
                        onMouseLeave={() => setHoveredSlot(null)}
                        disabled={isBooked || isClosed}
                        className={`w-full h-14 rounded-lg transition-all duration-200 font-semibold text-xs relative overflow-hidden ${
                          isBooked
                            ? "bg-gradient-to-br from-destructive/90 to-destructive text-destructive-foreground cursor-not-allowed shadow-inner"
                            : isClosed
                              ? "bg-muted/60 text-muted-foreground cursor-not-allowed opacity-50"
                              : isSelected
                                ? "bg-gradient-to-br from-secondary via-secondary to-accent text-secondary-foreground shadow-lg transform scale-[0.97] border-2 border-secondary/50 ring-2 ring-secondary/30"
                                : "bg-gradient-to-br from-card to-background hover:from-accent hover:to-accent/90 hover:text-accent-foreground hover:shadow-md hover:scale-[1.02] border-2 border-border/50 hover:border-accent cursor-pointer"
                        }`}
                        aria-label={`${court.name} at ${time} - ${status}`}
                        aria-pressed={isSelected}
                      >
                        {isSelected && (
                          <span className="text-xl absolute inset-0 flex items-center justify-center">✓</span>
                        )}
                        {isBooked && (
                          <span className="text-[10px] absolute inset-0 flex items-center justify-center font-bold">
                            Đã đặt
                          </span>
                        )}
                        {isClosed && (
                          <span className="text-[10px] absolute inset-0 flex items-center justify-center">Đóng</span>
                        )}
                        {!isBooked && !isClosed && !isSelected && isHovered && (
                          <span className="absolute inset-0 flex items-center justify-center text-lg">+</span>
                        )}
                      </button>
                    </td>
                  )
                })}
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <div className="mt-8 flex flex-wrap items-center justify-center gap-8 p-6 bg-gradient-to-br from-card to-muted/30 rounded-2xl border border-border shadow-sm">
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-lg bg-gradient-to-br from-card to-background border-2 border-border/50 shadow-sm"></div>
          <span className="text-sm text-foreground font-semibold">Trống</span>
        </div>
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-lg bg-gradient-to-br from-destructive/90 to-destructive shadow-sm"></div>
          <span className="text-sm text-foreground font-semibold">Đã đặt</span>
        </div>
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-lg bg-gradient-to-br from-secondary via-secondary to-accent border-2 border-secondary/50 shadow-lg"></div>
          <span className="text-sm text-foreground font-semibold">Đã chọn</span>
        </div>
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-lg bg-muted/60 opacity-50 shadow-sm"></div>
          <span className="text-sm text-foreground font-semibold">Đóng cửa</span>
        </div>
      </div>
    </div>
  )
}
