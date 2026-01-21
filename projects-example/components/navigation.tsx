"use client"

import type React from "react"
import Link from "next/link"
import { useState } from "react"
import { Search, Phone, FileSearch } from "lucide-react"

export function Navigation() {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false)
  const [isSearchOpen, setIsSearchOpen] = useState(false)
  const [searchQuery, setSearchQuery] = useState("")

  const navItems = [
    { label: "TRANG CHỦ", href: "/" },
    { label: "CHỌN GÓI", href: "/chon-goi" },
    { label: "SÂN & GIÁ", href: "/san-va-gia" },
    { label: "GÓI THÀNH VIÊN", href: "/goi-thanh-vien" },
    { label: "TIN TỨC", href: "/tin-tuc" },
    { label: "ĐÁNH GIÁ", href: "/danh-gia" },
    { label: "LIÊN HỆ", href: "/lien-he" },
  ]

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault()
    // Handle search implementation
  }

  return (
    <nav className="sticky top-0 z-50 bg-[#faf8f5] border-b border-[#e5e3df] shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-20">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2">
            <div className="w-12 h-12 bg-gradient-to-br from-[#065f46] to-[#059669] rounded-xl flex items-center justify-center text-white text-lg font-extrabold shadow-md">
              B
            </div>
            <div className="hidden sm:flex flex-col leading-tight">
              <span className="text-xl font-bold text-[#065f46]">BadmintonPro</span>
              <span className="text-xs text-[#059669] font-medium">Sân Cầu Lông Chuyên Nghiệp</span>
            </div>
          </Link>

          {/* Center Navigation - Desktop */}
          <div className="hidden lg:flex items-center gap-6">
            {navItems.map((item) => (
              <Link
                key={item.href}
                href={item.href}
                className="text-sm font-semibold text-[#065f46] hover:text-[#059669] transition-colors tracking-wide"
              >
                {item.label}
              </Link>
            ))}
          </div>

          {/* Right Actions */}
          <div className="flex items-center gap-3">
            {/* Search Icon */}
            <button
              onClick={() => setIsSearchOpen(!isSearchOpen)}
              className="p-2.5 text-[#065f46] hover:text-[#059669] hover:bg-white/50 rounded-lg transition-all"
              aria-label="Tìm kiếm"
            >
              <Search className="w-5 h-5" />
            </button>

            {/* Tra cứu đơn hàng */}
            <Link
              href="/tra-cuu"
              className="p-2.5 text-[#065f46] hover:text-[#059669] hover:bg-white/50 rounded-lg transition-all"
              aria-label="Tra cứu đơn hàng"
            >
              <FileSearch className="w-5 h-5" />
            </Link>

            {/* Phone Number */}
            <a
              href="tel:0886264644"
              className="hidden md:flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#065f46] to-[#059669] text-white rounded-lg font-semibold text-sm hover:shadow-lg transition-all"
            >
              <Phone className="w-4 h-4" />
              <span>0886 264 644</span>
            </a>

            {/* Mobile Menu Button */}
            <button
              className="lg:hidden p-2 text-[#065f46]"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              aria-label="Menu"
            >
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d={isMobileMenuOpen ? "M6 18L18 6M6 6l12 12M6 12h12" : "M4 6h16M4 12h16M4 18h16"}
                />
              </svg>
            </button>
          </div>
        </div>

        {/* Search Bar Dropdown */}
        {isSearchOpen && (
          <div className="pb-4 border-t border-[#e5e3df] pt-4 bg-white/50 rounded-b-lg">
            <form onSubmit={handleSearch} className="flex gap-2">
              <input
                type="text"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                placeholder="Tìm kiếm sân, dịch vụ, tin tức..."
                className="flex-1 px-4 py-3 border border-[#e5e3df] rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#059669] text-sm"
                autoFocus
              />
              <button
                type="submit"
                className="px-6 py-3 bg-gradient-to-r from-[#065f46] to-[#059669] text-white rounded-lg font-semibold hover:shadow-lg transition-all text-sm"
              >
                Tìm kiếm
              </button>
            </form>
          </div>
        )}

        {/* Mobile Menu */}
        {isMobileMenuOpen && (
          <div className="lg:hidden pb-4 border-t border-[#e5e3df] pt-2 bg-white/50 rounded-b-lg">
            {navItems.map((item) => (
              <Link
                key={item.href}
                href={item.href}
                className="block px-4 py-3 text-sm font-semibold text-[#065f46] hover:text-[#059669] hover:bg-white/70 rounded-lg"
                onClick={() => setIsMobileMenuOpen(false)}
              >
                {item.label}
              </Link>
            ))}
            <a
              href="tel:0886264644"
              className="flex items-center gap-2 mx-4 mt-3 px-4 py-3 bg-gradient-to-r from-[#065f46] to-[#059669] text-white rounded-lg font-semibold text-sm justify-center"
            >
              <Phone className="w-4 h-4" />
              <span>0886 264 644</span>
            </a>
            <Link
              href="/tra-cuu"
              className="block px-4 py-3 text-sm font-semibold text-[#065f46] hover:text-[#059669] hover:bg-white/70 rounded-lg mt-3"
              aria-label="Tra cứu đơn hàng"
            >
              <FileSearch className="w-5 h-5 mr-2" />
              Tra cứu đơn hàng
            </Link>
          </div>
        )}
      </div>
    </nav>
  )
}
