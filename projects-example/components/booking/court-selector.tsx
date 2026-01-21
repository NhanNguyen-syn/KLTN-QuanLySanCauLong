"use client"

import type { FC } from "react"

interface Court {
  id: string
  name: string
  price: number
  memberPrice: number
  icon: string
  features: string[]
  capacity: number
}

interface CourtSelectorProps {
  courts: Court[]
  selectedCourt: string
  onSelectCourt: (courtId: string) => void
}

export const CourtSelector: FC<CourtSelectorProps> = ({ courts, selectedCourt, onSelectCourt }) => {
  return (
    <section className="py-8 md:py-10">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 className="text-2xl font-serif font-bold mb-6">Chọn Sân Cầu Lông</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          {courts.map((court) => (
            <button
              key={court.id}
              onClick={() => onSelectCourt(court.id)}
              className={`p-4 rounded-xl border-2 transition-all text-left flex flex-col h-full ${
                selectedCourt === court.id
                  ? "bg-gradient-to-br from-primary to-accent border-primary text-primary-foreground shadow-lg transform scale-105"
                  : "bg-card border-border text-foreground hover:border-primary hover:shadow-md"
              }`}
              aria-pressed={selectedCourt === court.id}
              aria-label={`Select court ${court.name}`}
            >
              <div className="text-3xl mb-3">{court.icon}</div>
              <div className="font-bold text-base mb-1">{court.name}</div>

              <div
                className={`mb-4 pb-4 border-b ${selectedCourt === court.id ? "border-primary-foreground/30" : "border-border"}`}
              >
                <div className="text-lg font-bold">{court.price.toLocaleString("vi-VN")}đ</div>
                <div className="text-xs opacity-75">/1 giờ</div>
              </div>

              <ul className="text-xs space-y-1">
                {court.features.map((feature, idx) => (
                  <li key={idx} className="flex items-start gap-2">
                    <span className={selectedCourt === court.id ? "text-primary-foreground/90" : "text-secondary"}>
                      ✓
                    </span>
                    <span className="opacity-75">{feature}</span>
                  </li>
                ))}
              </ul>

              <div className="mt-auto pt-3 border-t border-current border-opacity-20 text-xs">
                Sức chứa: {court.capacity} người
              </div>
            </button>
          ))}
        </div>
      </div>
    </section>
  )
}
