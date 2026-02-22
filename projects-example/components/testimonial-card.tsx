interface TestimonialCardProps {
  name: string
  role: string
  content: string
  rating?: number
}

export function TestimonialCard({ name, role, content, rating = 5 }: TestimonialCardProps) {
  return (
    <div className="bg-white rounded-lg p-6 border border-border shadow-sm hover:shadow-md transition-all flex flex-col">
      {rating > 0 && (
        <div className="flex justify-center gap-1 mb-4">
          {[...Array(rating)].map((_, i) => (
            <span key={i} className="text-xl text-yellow-400">
              ★
            </span>
          ))}
        </div>
      )}
      <p className="mb-4 text-foreground text-sm italic text-center flex-1">"{content}"</p>
      <div className="pt-4 border-t border-border text-center">
        <div className="font-bold text-sm text-foreground">{name}</div>
        <div className="text-xs text-muted-foreground">{role}</div>
      </div>
    </div>
  )
}
