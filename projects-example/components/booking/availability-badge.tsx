import type { FC } from "react"

interface AvailabilityBadgeProps {
  status: "available" | "booked" | "closed" | "selected"
  count?: number
}

export const AvailabilityBadge: FC<AvailabilityBadgeProps> = ({ status, count }) => {
  const statusConfig = {
    available: {
      label: "Trống",
      bgColor: "bg-accent/10",
      textColor: "text-accent",
      borderColor: "border-accent/30",
    },
    booked: {
      label: "Đã đặt",
      bgColor: "bg-secondary/10",
      textColor: "text-secondary",
      borderColor: "border-secondary/30",
    },
    closed: {
      label: "Đóng cửa",
      bgColor: "bg-muted/10",
      textColor: "text-muted-foreground",
      borderColor: "border-muted/30",
    },
    selected: {
      label: "Đã chọn",
      bgColor: "bg-primary/10",
      textColor: "text-primary",
      borderColor: "border-primary/30",
    },
  }

  const config = statusConfig[status]

  return (
    <div
      className={`inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border ${config.bgColor} ${config.textColor} ${config.borderColor}`}
    >
      <div className={`w-2 h-2 rounded-full ${config.textColor.replace("text-", "bg-")}`}></div>
      <span>
        {config.label}
        {count !== undefined && ` (${count})`}
      </span>
    </div>
  )
}
