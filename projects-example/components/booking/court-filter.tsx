"use client"

import { type FC, useMemo } from "react"
import { Search, X } from "lucide-react"

interface CourtFilterProps {
  courts: Array<{ id: string; name: string; features: string[] }>
  selectedCourt: string
  searchQuery: string
  priceRange: [number, number]
  onSearchChange: (query: string) => void
  onPriceChange: (range: [number, number]) => void
  onClearFilters: () => void
}

export const CourtFilter: FC<CourtFilterProps> = ({
  courts,
  selectedCourt,
  searchQuery,
  priceRange,
  onSearchChange,
  onPriceChange,
  onClearFilters,
}) => {
  const filteredCourts = useMemo(() => {
    return courts.filter((court) => {
      const matchesSearch =
        court.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
        court.features.some((f) => f.toLowerCase().includes(searchQuery.toLowerCase()))
      return matchesSearch
    })
  }, [courts, searchQuery])

  const hasActiveFilters = searchQuery.length > 0 || priceRange[0] !== 100000 || priceRange[1] !== 200000

  return (
    <div className="bg-card border border-border rounded-lg p-6 space-y-6">
      <div>
        <h3 className="text-sm font-semibold text-foreground mb-3">Tìm Kiếm Sân</h3>
        <div className="relative">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-muted-foreground" />
          <input
            type="text"
            placeholder="Tìm sân theo tên hoặc tính năng..."
            value={searchQuery}
            onChange={(e) => onSearchChange(e.target.value)}
            className="w-full pl-10 pr-4 py-2 bg-background border border-border rounded-lg text-sm focus:border-primary outline-none transition-colors"
            aria-label="Search courts"
          />
          {searchQuery && (
            <button
              onClick={() => onSearchChange("")}
              className="absolute right-3 top-1/2 transform -translate-y-1/2 text-muted-foreground hover:text-foreground"
              aria-label="Clear search"
            >
              <X className="w-4 h-4" />
            </button>
          )}
        </div>
        {filteredCourts.length > 0 && (
          <p className="text-xs text-muted-foreground mt-2">Tìm thấy {filteredCourts.length} sân</p>
        )}
      </div>

      <div>
        <h3 className="text-sm font-semibold text-foreground mb-3">Khoảng Giá</h3>
        <div className="space-y-3">
          <input
            type="range"
            min="100000"
            max="200000"
            step="10000"
            value={priceRange[0]}
            onChange={(e) => onPriceChange([Number.parseInt(e.target.value), priceRange[1]])}
            className="w-full h-2 bg-border rounded-lg appearance-none cursor-pointer"
            aria-label="Minimum price"
          />
          <input
            type="range"
            min="100000"
            max="200000"
            step="10000"
            value={priceRange[1]}
            onChange={(e) => onPriceChange([priceRange[0], Number.parseInt(e.target.value)])}
            className="w-full h-2 bg-border rounded-lg appearance-none cursor-pointer"
            aria-label="Maximum price"
          />
          <div className="flex justify-between text-xs text-muted-foreground">
            <span>{priceRange[0].toLocaleString("vi-VN")}đ</span>
            <span>{priceRange[1].toLocaleString("vi-VN")}đ</span>
          </div>
        </div>
      </div>

      {hasActiveFilters && (
        <button
          onClick={onClearFilters}
          className="w-full px-4 py-2 bg-secondary text-secondary-foreground text-sm font-semibold rounded-lg hover:bg-secondary/90 transition-colors"
        >
          Xóa Bộ Lọc
        </button>
      )}
    </div>
  )
}
