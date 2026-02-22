interface SectionTitleProps {
  title: string
  subtitle?: string
  centered?: boolean
}

export function SectionTitle({ title, subtitle, centered = true }: SectionTitleProps) {
  return (
    <div className={`space-y-2 ${centered ? "text-center" : ""}`}>
      <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">{title}</h2>
      {subtitle && <p className="text-base text-muted-foreground">{subtitle}</p>}
    </div>
  )
}
