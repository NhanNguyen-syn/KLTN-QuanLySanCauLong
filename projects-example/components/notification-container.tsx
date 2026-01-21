"use client"
import { Notification } from "./notification-system"

interface NotificationItem {
  id: string
  message: string
  type: "success" | "error" | "info" | "warning"
  duration?: number
}

interface NotificationContainerProps {
  notifications: NotificationItem[]
  onRemove: (id: string) => void
}

export function NotificationContainer({ notifications, onRemove }: NotificationContainerProps) {
  return (
    <div className="fixed top-0 right-0 z-50 pointer-events-none">
      {notifications.map((notification) => (
        <div key={notification.id} className="pointer-events-auto">
          <Notification
            message={notification.message}
            type={notification.type}
            duration={notification.duration}
            onClose={() => onRemove(notification.id)}
          />
        </div>
      ))}
    </div>
  )
}
