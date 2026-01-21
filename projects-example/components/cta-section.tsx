import Link from "next/link"

interface CTASectionProps {
  title: string
  description: string
  primaryCTA: { label: string; href: string }
  secondaryCTA?: { label: string; href: string }
}

export function CTASection({ title, description, primaryCTA, secondaryCTA }: CTASectionProps) {
  return (
    <section className="py-12 md:py-14 bg-primary text-white relative overflow-hidden">
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-1/2 left-1/4 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
      </div>

      <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-5">
        <div className="space-y-2">
          <h2 className="text-3xl md:text-4xl font-extrabold font-serif">{title}</h2>
          <p className="text-base md:text-lg text-white/90 max-w-2xl mx-auto">{description}</p>
        </div>

        <div className="flex flex-col sm:flex-row gap-3 justify-center pt-1">
          <Link
            href={primaryCTA.href}
            className="inline-flex items-center justify-center bg-white text-primary px-8 py-3 rounded-lg font-bold text-base hover:bg-secondary hover:text-white transition-all duration-300 shadow-lg hover:scale-105"
          >
            {primaryCTA.label}
          </Link>
          {secondaryCTA && (
            <Link
              href={secondaryCTA.href}
              className="inline-flex items-center justify-center border-2 border-white text-white px-8 py-3 rounded-lg font-bold text-base hover:bg-white hover:text-primary transition-all"
            >
              {secondaryCTA.label}
            </Link>
          )}
        </div>
      </div>
    </section>
  )
}
