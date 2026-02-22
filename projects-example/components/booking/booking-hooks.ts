"use client"

import { useState, useCallback } from "react"
import { BOOKED_SLOTS } from "./booking-constants"

export const useBookingSlots = () => {
  const [selectedSlots, setSelectedSlots] = useState<string[]>([])

  const getSlotStatus = useCallback(
    (courtId: string, time: string) => {
      const slotId = `${courtId}-${time}`
      const hour = Number.parseInt(time.split(":")[0])
      if (hour < 5) return "closed"
      if (BOOKED_SLOTS.includes(slotId)) return "booked"
      if (selectedSlots.includes(slotId)) return "selected"
      return "available"
    },
    [selectedSlots],
  )

  const toggleSlot = useCallback((courtId: string, time: string) => {
    const slotId = `${courtId}-${time}`
    setSelectedSlots((prev) => {
      const status = BOOKED_SLOTS.includes(slotId) ? "booked" : prev.includes(slotId) ? "selected" : "available"
      if (status === "booked") return prev
      if (prev.includes(slotId)) {
        return prev.filter((s) => s !== slotId)
      }
      return [...prev, slotId]
    })
  }, [])

  const clearSlots = useCallback(() => {
    setSelectedSlots([])
  }, [])

  return {
    selectedSlots,
    setSelectedSlots,
    getSlotStatus,
    toggleSlot,
    clearSlots,
  }
}

export const useBookingDates = () => {
  const [selectedDates, setSelectedDates] = useState<string[]>([])

  const toggleDate = useCallback((date: string) => {
    setSelectedDates((prev) => {
      if (prev.includes(date)) {
        return prev.filter((d) => d !== date)
      }
      return [...prev, date]
    })
  }, [])

  const clearDates = useCallback(() => {
    setSelectedDates([])
  }, [])

  return {
    selectedDates,
    setSelectedDates,
    toggleDate,
    clearDates,
  }
}
