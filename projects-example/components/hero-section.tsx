import Link from "next/link"

interface HeroSectionProps {
  title: string
  description: string
  primaryCTA: { label: string; href: string }
  secondaryCTA?: { label: string; href: string }
  stats?: Array<{ value: string; label: string }>
}

export function HeroSection({ title, description, primaryCTA, secondaryCTA, stats }: HeroSectionProps) {
  return (
    <section className="relative bg-gradient-to-br from-primary via-primary/95 to-primary/90 text-white overflow-hidden pt-12 pb-16 md:pt-14 md:pb-18">
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-0 right-0 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
        <div className="absolute bottom-0 left-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
      </div>

      <div className="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="max-w-3xl mx-auto text-center space-y-5 animate-slideInUp">
          <div className="space-y-3">
            <h1 className="text-4xl md:text-5xl font-extrabold leading-tight text-balance font-serif">{title}</h1>
            <p className="text-base md:text-lg text-white/90 max-w-2xl mx-auto leading-relaxed">{description}</p>
          </div>

          <div className="flex flex-col sm:flex-row gap-3 justify-center pt-1">
            <Link
              href={primaryCTA.href}
              className="inline-flex items-center justify-center bg-white text-primary px-8 py-3 rounded-lg font-bold text-base hover:bg-secondary hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
            >
              {primaryCTA.label}
            </Link>
            {secondaryCTA && (
              <Link
                href={secondaryCTA.href}
                className="inline-flex items-center justify-center border-2 border-white text-white px-8 py-3 rounded-lg font-bold text-base hover:bg-white hover:text-primary transition-all duration-300"
              >
                {secondaryCTA.label}
              </Link>
            )}
          </div>

          {stats && (
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6">
              {stats.map((stat, idx) => (
                <div key={idx} className="text-center">
                  <div className="text-3xl md:text-3xl font-extrabold">{stat.value}</div>
                  <div className="text-xs md:text-sm text-white/75 mt-1">{stat.label}</div>
                </div>
              ))}
            </div>
          )}
        </div>
      </div>
    </section>
  )
}
