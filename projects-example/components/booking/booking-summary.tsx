"use client"

import type { FC } from "react"
import { ChevronRight, ShoppingBag } from "lucide-react"

interface BookingSummaryProps {
  selectedSlots: string[]
  courts: Array<{ id: string; name: string; price: number }>
  onCheckout: () => void
}

export const BookingSummary: FC<BookingSummaryProps> = ({ selectedSlots, courts, onCheckout }) => {
  const calculateTotal = () => {
    let total = 0
    selectedSlots.forEach((slot) => {
      const courtId = slot.substring(0, slot.lastIndexOf("-"))
      const court = courts.find((c) => c.id === courtId)
      if (court) total += court.price
    })
    return total
  }

  const total = calculateTotal()

  return (
    <>
      {selectedSlots.length > 0 && (
        <>
          <div className="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-primary via-primary to-accent text-primary-foreground shadow-2xl border-t-4 border-secondary z-50 backdrop-blur-lg">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
              <div className="flex flex-col md:flex-row items-center justify-between gap-5">
                <div className="flex flex-col sm:flex-row items-start sm:items-center gap-6 w-full md:w-auto">
                  <div className="flex items-center gap-3">
                    <div className="w-12 h-12 rounded-xl bg-primary-foreground/20 backdrop-blur-sm flex items-center justify-center">
                      <ShoppingBag className="w-6 h-6 text-primary-foreground" />
                    </div>
                    <div>
                      <div className="text-xs text-primary-foreground/80 uppercase font-bold tracking-wide">
                        Đã chọn
                      </div>
                      <div className="text-2xl font-bold">{selectedSlots.length} khung giờ</div>
                    </div>
                  </div>
                  <div className="hidden md:block w-px h-14 bg-primary-foreground/30"></div>
                  <div className="hidden md:block">
                    <div className="text-xs text-primary-foreground/80 uppercase font-bold tracking-wide">
                      Tổng tiền
                    </div>
                    <div className="text-3xl font-bold">{total.toLocaleString("vi-VN")}đ</div>
                  </div>
                </div>
                <button
                  onClick={onCheckout}
                  className="w-full md:w-auto flex items-center justify-center gap-3 bg-secondary text-secondary-foreground px-10 py-4 rounded-xl font-bold hover:bg-secondary/90 transition-all duration-200 uppercase text-base shadow-lg hover:shadow-xl hover:scale-105 active:scale-95"
                >
                  Tiếp Tục
                  <ChevronRight className="w-5 h-5" />
                </button>
              </div>
            </div>
          </div>
          <div className="h-32"></div>
        </>
      )}
    </>
  )
}
