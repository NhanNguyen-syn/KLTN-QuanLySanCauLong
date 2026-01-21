"use client"

import React, { useEffect } from "react"

interface NotificationProps {
  message: string
  type?: "success" | "error" | "info" | "warning"
  duration?: number
  onClose?: () => void
}

const notificationTypeStyles = {
  success: {
    bg: "bg-green-50",
    border: "border-green-200",
    icon: "✓",
    text: "text-green-800",
    iconBg: "bg-green-100",
  },
  error: {
    bg: "bg-red-50",
    border: "border-red-200",
    icon: "✕",
    text: "text-red-800",
    iconBg: "bg-red-100",
  },
  info: {
    bg: "bg-blue-50",
    border: "border-blue-200",
    icon: "ℹ",
    text: "text-blue-800",
    iconBg: "bg-blue-100",
  },
  warning: {
    bg: "bg-yellow-50",
    border: "border-yellow-200",
    icon: "⚠",
    text: "text-yellow-800",
    iconBg: "bg-yellow-100",
  },
}

export function Notification({ message, type = "success", duration = 3000, onClose }: NotificationProps) {
  const [isVisible, setIsVisible] = React.useState(true)
  const styles = notificationTypeStyles[type]

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsVisible(false)
      onClose?.()
    }, duration)

    return () => clearTimeout(timer)
  }, [duration, onClose])

  if (!isVisible) return null

  return (
    <div
      className={`fixed top-4 right-4 z-50 transition-all duration-300 ${
        isVisible ? "opacity-100 translate-x-0" : "opacity-0 translate-x-full"
      }`}
    >
      <div className={`${styles.bg} border ${styles.border} rounded-lg px-4 py-3 shadow-md flex items-center gap-3`}>
        <div className={`${styles.iconBg} w-8 h-8 rounded-full flex items-center justify-center`}>
          <span className={`${styles.text} font-bold text-sm`}>{styles.icon}</span>
        </div>
        <span className={`${styles.text} font-medium text-sm`}>{message}</span>
      </div>
    </div>
  )
}

export function useNotification() {
  const [notifications, setNotifications] = React.useState<(NotificationProps & { id: string })[]>([])

  const show = (message: string, type: "success" | "error" | "info" | "warning" = "success") => {
    const id = Math.random().toString(36).substr(2, 9)
    const newNotification = { id, message, type, duration: 3000 }
    setNotifications((prev) => [...prev, newNotification])

    return () => {
      setNotifications((prev) => prev.filter((n) => n.id !== id))
    }
  }

  return { notifications, show, setNotifications }
}
