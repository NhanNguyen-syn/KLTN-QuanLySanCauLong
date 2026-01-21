import type React from "react"
interface FeatureCardProps {
  title: string
  description: string
  icon?: React.ReactNode
}

export function FeatureCard({ title, description, icon }: FeatureCardProps) {
  return (
    <div className="bg-white rounded-lg p-6 border border-border hover:border-primary hover:shadow-md transition-all">
      {icon && <div className="mb-4">{icon}</div>}
      <h3 className="text-lg font-bold text-foreground mb-2">{title}</h3>
      <p className="text-sm text-muted-foreground">{description}</p>
    </div>
  )
}
