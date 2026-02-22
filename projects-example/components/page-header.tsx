interface PageHeaderProps {
  title: string
  description: string
  subtitle?: string
}

export function PageHeader({ title, description, subtitle }: PageHeaderProps) {
  return (
    <section className="relative bg-gradient-to-br from-primary via-primary to-primary/85 text-primary-foreground py-14 md:py-16 overflow-hidden">
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-0 right-0 w-96 h-96 bg-secondary rounded-full -mr-48 -mt-48"></div>
        <div className="absolute bottom-0 left-0 w-80 h-80 bg-accent rounded-full -ml-40 -mb-40"></div>
      </div>

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-4xl md:text-5xl font-serif font-bold mb-3 text-balance">{title}</h1>
        <p className="text-lg text-primary-foreground/90 max-w-2xl text-pretty">{description}</p>
        {subtitle && <p className="text-sm text-primary-foreground/75 mt-4">{subtitle}</p>}
      </div>
    </section>
  )
}
