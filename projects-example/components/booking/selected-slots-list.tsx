"use client"

import type { FC } from "react"
import { X } from "lucide-react"

interface SelectedSlotsListProps {
  selectedSlots: string[]
  courts: Array<{ id: string; name: string }>
  onRemoveSlot: (slot: string) => void
}

export const SelectedSlotsList: FC<SelectedSlotsListProps> = ({ selectedSlots, courts, onRemoveSlot }) => {
  if (selectedSlots.length === 0) return null

  return (
    <div className="bg-card border border-border rounded-lg p-4">
      <h3 className="font-semibold text-foreground mb-3">Các khung giờ đã chọn ({selectedSlots.length})</h3>

      <div className="space-y-2 max-h-40 overflow-y-auto">
        {selectedSlots.map((slot) => {
          const lastDashIndex = slot.lastIndexOf("-")
          const courtId = slot.substring(0, lastDashIndex)
          const time = slot.substring(lastDashIndex + 1)
          const court = courts.find((c) => c.id === courtId)

          return (
            <div
              key={slot}
              className="flex items-center justify-between bg-muted/50 p-2 rounded border border-border text-sm"
            >
              <div className="flex items-center gap-2">
                <span className="font-semibold text-foreground">{court?.name}</span>
                <span className="text-muted-foreground">-</span>
                <span className="text-muted-foreground">{time}</span>
              </div>
              <button
                onClick={() => onRemoveSlot(slot)}
                className="p-1 hover:bg-destructive/10 rounded transition-colors"
                aria-label={`Remove ${court?.name} at ${time}`}
              >
                <X className="w-4 h-4 text-destructive" />
              </button>
            </div>
          )
        })}
      </div>
    </div>
  )
}
