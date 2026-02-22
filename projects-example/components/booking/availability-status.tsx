import type { FC } from "react"

interface AvailabilityStatusProps {
  totalCourts: number
  availableCourts: number
  bookedCourts: number
}

export const AvailabilityStatus: FC<AvailabilityStatusProps> = ({ totalCourts, availableCourts, bookedCourts }) => {
  const occupancyRate = Math.round((bookedCourts / totalCourts) * 100)

  return (
    <div className="bg-gradient-to-br from-primary/10 to-secondary/10 border border-primary/20 rounded-lg p-6">
      <h3 className="font-semibold text-foreground mb-4">Tình Trạng Sân Hôm Nay</h3>

      <div className="grid grid-cols-3 gap-4 mb-4">
        <div className="bg-card rounded-lg p-4 border border-border text-center">
          <div className="text-2xl font-bold text-primary">{totalCourts}</div>
          <div className="text-xs text-muted-foreground">Tổng sân</div>
        </div>
        <div className="bg-card rounded-lg p-4 border border-border text-center">
          <div className="text-2xl font-bold text-secondary">{bookedCourts}</div>
          <div className="text-xs text-muted-foreground">Đã đặt</div>
        </div>
        <div className="bg-card rounded-lg p-4 border border-border text-center">
          <div className="text-2xl font-bold text-accent">{availableCourts}</div>
          <div className="text-xs text-muted-foreground">Trống</div>
        </div>
      </div>

      <div className="space-y-2">
        <div className="flex items-center justify-between text-xs mb-1">
          <span className="text-muted-foreground">Tỷ lệ sử dụng</span>
          <span className="font-semibold text-foreground">{occupancyRate}%</span>
        </div>
        <div className="w-full h-2 bg-border rounded-full overflow-hidden">
          <div
            className="h-full bg-gradient-to-r from-secondary to-accent transition-all duration-300"
            style={{ width: `${occupancyRate}%` }}
          ></div>
        </div>
      </div>
    </div>
  )
}
