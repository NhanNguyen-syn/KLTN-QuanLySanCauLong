import type { FC } from "react"
import { Lightbulb, Clock, MapPin, Zap } from "lucide-react"

interface BookingTipsProps {
  selectedSlots?: number
}

export const BookingTips: FC<BookingTipsProps> = ({ selectedSlots = 0 }) => {
  const tips = [
    {
      icon: Clock,
      title: "Đặt sân sớm",
      description: "Đặt sân vào buổi sáng để có nhiều lựa chọn khung giờ hơn",
    },
    {
      icon: Zap,
      title: "Giờ vàng",
      description: "Chiều tối (17:00-20:00) có giảm giá 10%, tối muộn giảm 15%",
    },
    {
      icon: MapPin,
      title: "Chọn sân gần",
      description: "Tất cả sân đều có cùng tiêu chuẩn, chọn sân gần nhất cho tiện",
    },
  ]

  return (
    <div className="bg-gradient-to-br from-secondary/10 to-accent/10 border border-secondary/20 rounded-xl p-6">
      <div className="flex items-center gap-2 mb-4">
        <Lightbulb className="w-5 h-5 text-secondary" />
        <h3 className="font-semibold text-foreground">Mẹo đặt sân</h3>
      </div>

      <div className="space-y-3">
        {tips.map((tip, idx) => {
          const Icon = tip.icon
          return (
            <div key={idx} className="flex gap-3">
              <Icon className="w-5 h-5 text-secondary flex-shrink-0 mt-0.5" />
              <div>
                <p className="text-sm font-semibold text-foreground">{tip.title}</p>
                <p className="text-xs text-muted-foreground">{tip.description}</p>
              </div>
            </div>
          )
        })}
      </div>

      {selectedSlots > 0 && (
        <div className="mt-4 pt-4 border-t border-secondary/20 text-xs text-muted-foreground">
          Bạn đã chọn <strong>{selectedSlots} khung giờ</strong> - tiếp tục để hoàn thành đặt sân
        </div>
      )}
    </div>
  )
}
