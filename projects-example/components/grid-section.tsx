import type React from "react"
interface GridSectionProps {
  title: string
  subtitle?: string
  children: React.ReactNode
  columns?: "2" | "3" | "4" | "5"
  background?: "primary" | "secondary" | "muted"
}

export function GridSection({ title, subtitle, children, columns = "3", background = "secondary" }: GridSectionProps) {
  const bgClasses = {
    primary: "bg-primary text-white",
    secondary: "bg-background",
    muted: "bg-muted/20",
  }

  const gridClasses = {
    "2": "grid-cols-1 sm:grid-cols-2",
    "3": "grid-cols-1 md:grid-cols-2 lg:grid-cols-3",
    "4": "grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4",
    "5": "grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5",
  }

  return (
    <section className={`py-12 md:py-14 ${bgClasses[background]}`}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {(title || subtitle) && (
          <div className="text-center mb-10 space-y-2">
            <h2 className="text-3xl md:text-4xl font-extrabold font-serif">{title}</h2>
            {subtitle && <p className="text-muted-foreground">{subtitle}</p>}
          </div>
        )}
        <div className={`grid ${gridClasses[columns]} gap-6`}>{children}</div>
      </div>
    </section>
  )
}
