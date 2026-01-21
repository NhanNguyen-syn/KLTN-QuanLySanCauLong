import Link from "next/link"

interface CourtCardProps {
  id: number
  name: string
  price: string
  period: string
  tag: string
  features: string[]
  href?: string
}

export function CourtCard({ id, name, price, period, tag, features, href = "/chon-goi" }: CourtCardProps) {
  return (
    <div className="group bg-white rounded-xl overflow-hidden shadow-sm border border-border hover:shadow-lg hover:border-primary transition-all duration-300 hover:scale-105 hover:-translate-y-1">
      <div className="bg-gradient-to-br from-primary to-primary/80 p-5 text-white">
        <div className="flex justify-between items-start mb-3">
          <h3 className="text-xl font-bold">{name}</h3>
          <span className="text-xs bg-white/20 px-2 py-1 rounded text-white/90">{tag}</span>
        </div>
        <div className="inline-block">
          <div className="flex items-baseline gap-1">
            <span className="text-3xl font-extrabold">{price}</span>
            <span className="text-xs">đ/{period}</span>
          </div>
        </div>
      </div>

      <div className="p-5 space-y-4">
        <div className="space-y-2">
          {features.map((feature, idx) => (
            <div key={idx} className="flex items-start gap-2">
              <div className="w-1 h-1 rounded-full bg-secondary mt-2 flex-shrink-0"></div>
              <span className="text-sm text-foreground font-medium">{feature}</span>
            </div>
          ))}
        </div>

        <Link
          href={href}
          className="block w-full bg-secondary text-white py-2.5 rounded-lg font-bold text-center hover:bg-secondary/90 transition-all text-sm"
        >
          Đặt Sân
        </Link>
      </div>
    </div>
  )
}
