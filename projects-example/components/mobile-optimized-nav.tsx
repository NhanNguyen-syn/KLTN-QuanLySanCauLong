"use client"

import Link from "next/link"

interface NavItem {
  label: string
  href: string
}

interface MobileOptimizedNavProps {
  items: NavItem[]
  onItemClick?: () => void
}

export function MobileOptimizedNav({ items, onItemClick }: MobileOptimizedNavProps) {
  return (
    <div className="lg:hidden pb-4 border-t border-border pt-2 space-y-1">
      {items.map((item) => (
        <Link
          key={item.href}
          href={item.href}
          className="block px-4 py-3 text-base font-medium text-foreground hover:text-primary hover:bg-muted rounded-lg transition-colors"
          onClick={onItemClick}
        >
          {item.label}
        </Link>
      ))}
    </div>
  )
}
