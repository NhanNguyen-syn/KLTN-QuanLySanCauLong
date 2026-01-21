"use client"

import Link from "next/link"
import { MapPin, Phone, Mail, Clock, Facebook, Instagram, Youtube, ArrowRight } from "lucide-react"

export function Footer() {
  return (
    <footer className="bg-[#0f172a] text-white">
      

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
          {/* Company Info - Enhanced */}
          <div className="lg:col-span-1">
            <Link href="/" className="flex items-center gap-3 mb-6">
              <div className="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center text-lg font-black shadow-lg shadow-emerald-500/20">
                B
              </div>
              <div>
                <span className="text-xl font-bold block">BadmintonPro</span>
                <span className="text-xs text-gray-400">Sân cầu lông chuyên nghiệp</span>
              </div>
            </Link>
            <p className="text-gray-400 text-sm leading-relaxed mb-6">
              Hệ thống sân cầu lông đạt tiêu chuẩn quốc tế, trang bị đầy đủ tiện nghi hiện đại phục vụ mọi nhu cầu luyện
              tập và thi đấu.
            </p>
            {/* Social Links */}
            <div className="flex gap-3">
              <a
                href="#"
                className="w-10 h-10 bg-white/5 hover:bg-emerald-500 rounded-lg flex items-center justify-center transition-colors group"
              >
                <Facebook className="w-5 h-5 text-gray-400 group-hover:text-white" />
              </a>
              <a
                href="#"
                className="w-10 h-10 bg-white/5 hover:bg-emerald-500 rounded-lg flex items-center justify-center transition-colors group"
              >
                <Instagram className="w-5 h-5 text-gray-400 group-hover:text-white" />
              </a>
              <a
                href="#"
                className="w-10 h-10 bg-white/5 hover:bg-emerald-500 rounded-lg flex items-center justify-center transition-colors group"
              >
                <Youtube className="w-5 h-5 text-gray-400 group-hover:text-white" />
              </a>
            </div>
          </div>

          {/* Quick Links - Enhanced */}
          <div>
            <h4 className="font-semibold mb-6 text-white flex items-center gap-2">
              <div className="w-1 h-5 bg-emerald-500 rounded-full"></div>
              Khám phá
            </h4>
            <ul className="space-y-3">
              {[
                { href: "/", label: "Trang chủ" },
                { href: "/dat-san", label: "Đặt sân" },
                { href: "/san-va-gia", label: "Sân & Bảng giá" },
                { href: "/goi-thanh-vien", label: "Gói thành viên" },
                { href: "/ve-chung-toi", label: "Về chúng tôi" },
              ].map((link) => (
                <li key={link.href}>
                  <Link
                    href={link.href}
                    className="text-gray-400 hover:text-emerald-400 transition-colors text-sm flex items-center gap-2 group"
                  >
                    <ArrowRight className="w-3 h-3 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Support Links - Enhanced */}
          <div>
            <h4 className="font-semibold mb-6 text-white flex items-center gap-2">
              <div className="w-1 h-5 bg-emerald-500 rounded-full"></div>
              Hỗ trợ
            </h4>
            <ul className="space-y-3">
              {[
                { href: "/tieu-chuan-dich-vu", label: "Tiêu chuẩn dịch vụ" },
                { href: "/chinh-sach-huy-doi-hoan", label: "Chính sách hủy/đổi/hoàn" },
                { href: "/lien-he", label: "Liên hệ hỗ trợ" },
                { href: "/tra-cuu", label: "Tra cứu đơn hàng" },
                { href: "#", label: "Câu hỏi thường gặp" },
              ].map((link) => (
                <li key={link.href}>
                  <Link
                    href={link.href}
                    className="text-gray-400 hover:text-emerald-400 transition-colors text-sm flex items-center gap-2 group"
                  >
                    <ArrowRight className="w-3 h-3 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact Info - Enhanced */}
          <div>
            <h4 className="font-semibold mb-6 text-white flex items-center gap-2">
              <div className="w-1 h-5 bg-emerald-500 rounded-full"></div>
              Liên hệ
            </h4>
            <ul className="space-y-4">
              <li className="flex items-start gap-3">
                <div className="w-9 h-9 bg-emerald-500/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                  <MapPin className="w-4 h-4 text-emerald-400" />
                </div>
                <div>
                  <p className="text-sm text-gray-400">123 Đường Badminton, Quận Cầu Giấy, Hà Nội</p>
                </div>
              </li>
              <li className="flex items-center gap-3">
                <div className="w-9 h-9 bg-emerald-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Phone className="w-4 h-4 text-emerald-400" />
                </div>
                <div>
                  <a href="tel:1800123456" className="text-sm text-gray-400 hover:text-emerald-400 transition-colors">
                    1800 123 456 (Miễn phí)
                  </a>
                </div>
              </li>
              <li className="flex items-center gap-3">
                <div className="w-9 h-9 bg-emerald-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Mail className="w-4 h-4 text-emerald-400" />
                </div>
                <div>
                  <a
                    href="mailto:info@badmintonpro.vn"
                    className="text-sm text-gray-400 hover:text-emerald-400 transition-colors"
                  >
                    info@badmintonpro.vn
                  </a>
                </div>
              </li>
              <li className="flex items-center gap-3">
                <div className="w-9 h-9 bg-emerald-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Clock className="w-4 h-4 text-emerald-400" />
                </div>
                <div>
                  <p className="text-sm text-gray-400">06:00 - 22:00 (Hàng ngày)</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div className="border-t border-white/5 bg-[#0a101f]">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div className="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
            <p>&copy; 2025 BadmintonPro. Tất cả quyền được bảo lưu.</p>
            <div className="flex flex-wrap justify-center gap-6">
              <Link href="/chinh-sach-huy-doi-hoan" className="hover:text-emerald-400 transition-colors">
                Chính sách bảo mật
              </Link>
              <Link href="#" className="hover:text-emerald-400 transition-colors">
                Điều khoản sử dụng
              </Link>
              <Link href="#" className="hover:text-emerald-400 transition-colors">
                Cookie
              </Link>
            </div>
          </div>
        </div>
      </div>
    </footer>
  )
}
