"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState } from "react"
import { Search, Calendar, Clock, User, Phone, CreditCard, CheckCircle, XCircle, AlertCircle } from "lucide-react"

export default function LookupPage() {
  const [bookingCode, setBookingCode] = useState("")
  const [result, setResult] = useState<any>(null)
  const [loading, setLoading] = useState(false)

  const handleSearch = () => {
    setLoading(true)
    setTimeout(() => {
      if (bookingCode === "BK001" || bookingCode === "BK002") {
        setResult({
          id: bookingCode,
          court: bookingCode === "BK001" ? "Sân 1" : "Sân 5",
          date: bookingCode === "BK001" ? "2025-11-15" : "2025-11-20",
          time: bookingCode === "BK001" ? "18:00 - 19:00" : "19:00 - 20:00",
          price: bookingCode === "BK001" ? 150000 : 150000,
          status: bookingCode === "BK001" ? "completed" : "upcoming",
          customerName: "Nguyễn Văn A",
          customerPhone: "0886 264 644",
          paymentMethod: "Chuyển khoản",
          bookingDate: "2025-11-10",
        })
      } else {
        setResult(null)
      }
      setLoading(false)
    }, 1000)
  }

  const getStatusBadge = (status: string) => {
    switch (status) {
      case "completed":
        return (
          <div className="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full">
            <CheckCircle className="w-4 h-4" />
            <span className="text-sm font-semibold">Đã hoàn thành</span>
          </div>
        )
      case "upcoming":
        return (
          <div className="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-full">
            <AlertCircle className="w-4 h-4" />
            <span className="text-sm font-semibold">Sắp tới</span>
          </div>
        )
      case "cancelled":
        return (
          <div className="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 rounded-full">
            <XCircle className="w-4 h-4" />
            <span className="text-sm font-semibold">Đã hủy</span>
          </div>
        )
      default:
        return null
    }
  }

  return (
    <div className="min-h-screen flex flex-col">
      <Navigation />

      <main className="flex-1 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">
        {/* Hero Section */}
        <section className="relative bg-gradient-to-r from-[#065f46] via-[#059669] to-[#14b8a6] text-white py-16 overflow-hidden">
          <div className="absolute inset-0 bg-[url('/grid.svg')] opacity-10"></div>
          <div className="relative max-w-4xl mx-auto px-4 text-center">
            <div className="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
              <Search className="w-8 h-8" />
            </div>
            <h1 className="text-4xl md:text-5xl font-bold mb-4">Tra Cứu Đặt Sân</h1>
            <p className="text-lg text-white/90 max-w-2xl mx-auto">
              Nhập mã đặt sân để xem chi tiết và quản lý lịch của bạn một cách nhanh chóng
            </p>
          </div>
        </section>

        <section className="py-12">
          <div className="max-w-4xl mx-auto px-4">
            {/* Search Box */}
            <div className="bg-white rounded-2xl shadow-xl border border-emerald-100 p-8 mb-8 -mt-16 relative">
              <label className="block text-sm font-semibold text-gray-700 mb-3">Mã đặt sân</label>
              <div className="flex flex-col sm:flex-row gap-3">
                <div className="relative flex-1">
                  <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                  <input
                    type="text"
                    value={bookingCode}
                    onChange={(e) => setBookingCode(e.target.value.toUpperCase())}
                    placeholder="Ví dụ: BK001"
                    className="w-full pl-12 pr-6 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 text-lg font-semibold transition-colors"
                    onKeyPress={(e) => e.key === "Enter" && handleSearch()}
                  />
                </div>
                <button
                  onClick={handleSearch}
                  disabled={!bookingCode || loading}
                  className="px-8 py-4 bg-gradient-to-r from-[#065f46] to-[#059669] text-white rounded-xl font-semibold hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                  <Search className="w-5 h-5" />
                  {loading ? "Đang tìm..." : "Tra cứu"}
                </button>
              </div>
              <p className="text-sm text-gray-500 mt-3 flex items-center gap-2">
                <AlertCircle className="w-4 h-4" />
                Mã đặt sân được gửi qua email hoặc SMS sau khi bạn hoàn tất đặt sân
              </p>
            </div>

            {/* Result */}
            {result && (
              <div className="bg-white rounded-2xl shadow-xl border border-emerald-100 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div className="bg-gradient-to-r from-[#065f46] via-[#059669] to-[#14b8a6] text-white p-8">
                  <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                      <h2 className="text-2xl font-bold mb-2">Mã đặt sân: {result.id}</h2>
                      <p className="text-white/90 flex items-center gap-2">
                        <Calendar className="w-4 h-4" />
                        Đặt ngày: {new Date(result.bookingDate).toLocaleDateString("vi-VN")}
                      </p>
                    </div>
                    {getStatusBadge(result.status)}
                  </div>
                </div>

                <div className="p-8">
                  <div className="grid md:grid-cols-2 gap-8 mb-8">
                    {/* Court Info */}
                    <div className="space-y-4">
                      <h3 className="text-sm font-bold text-emerald-700 uppercase tracking-wide mb-4 flex items-center gap-2">
                        <Calendar className="w-4 h-4" />
                        Thông tin sân
                      </h3>
                      <div className="space-y-4">
                        <div className="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                          <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span className="text-emerald-700 font-bold">S</span>
                          </div>
                          <div>
                            <p className="text-xs text-gray-600 mb-1">Sân</p>
                            <p className="text-lg font-bold text-gray-900">{result.court}</p>
                          </div>
                        </div>
                        <div className="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                          <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <Calendar className="w-5 h-5 text-emerald-700" />
                          </div>
                          <div>
                            <p className="text-xs text-gray-600 mb-1">Ngày chơi</p>
                            <p className="text-lg font-bold text-gray-900">
                              {new Date(result.date).toLocaleDateString("vi-VN")}
                            </p>
                          </div>
                        </div>
                        <div className="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                          <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <Clock className="w-5 h-5 text-emerald-700" />
                          </div>
                          <div>
                            <p className="text-xs text-gray-600 mb-1">Giờ chơi</p>
                            <p className="text-lg font-bold text-gray-900">{result.time}</p>
                          </div>
                        </div>
                      </div>
                    </div>

                    {/* Customer Info */}
                    <div className="space-y-4">
                      <h3 className="text-sm font-bold text-emerald-700 uppercase tracking-wide mb-4 flex items-center gap-2">
                        <User className="w-4 h-4" />
                        Thông tin khách hàng
                      </h3>
                      <div className="space-y-4">
                        <div className="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                          <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <User className="w-5 h-5 text-emerald-700" />
                          </div>
                          <div>
                            <p className="text-xs text-gray-600 mb-1">Họ tên</p>
                            <p className="text-lg font-bold text-gray-900">{result.customerName}</p>
                          </div>
                        </div>
                        <div className="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                          <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <Phone className="w-5 h-5 text-emerald-700" />
                          </div>
                          <div>
                            <p className="text-xs text-gray-600 mb-1">Số điện thoại</p>
                            <p className="text-lg font-bold text-gray-900">{result.customerPhone}</p>
                          </div>
                        </div>
                        <div className="flex items-start gap-3 p-3 bg-emerald-50 rounded-lg">
                          <div className="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <CreditCard className="w-5 h-5 text-emerald-700" />
                          </div>
                          <div>
                            <p className="text-xs text-gray-600 mb-1">Thanh toán</p>
                            <p className="text-lg font-bold text-gray-900">{result.paymentMethod}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div className="border-t border-gray-200 pt-6">
                    <div className="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl">
                      <span className="text-lg font-semibold text-gray-700">Tổng tiền</span>
                      <span className="text-3xl font-bold text-emerald-700">
                        {result.price.toLocaleString("vi-VN")}đ
                      </span>
                    </div>
                  </div>

                  {result.status === "upcoming" && (
                    <div className="mt-6 flex flex-col sm:flex-row gap-3">
                      <button className="flex-1 px-6 py-3 bg-red-50 text-red-700 rounded-xl font-semibold hover:bg-red-100 transition-colors border border-red-200">
                        Hủy đặt sân
                      </button>
                      <button className="flex-1 px-6 py-3 bg-gradient-to-r from-[#065f46] to-[#059669] text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        Liên hệ hỗ trợ
                      </button>
                    </div>
                  )}
                </div>
              </div>
            )}

            {result === null && bookingCode && !loading && (
              <div className="bg-white rounded-2xl shadow-xl border border-gray-200 p-12 text-center animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div className="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                  <XCircle className="w-10 h-10 text-gray-400" />
                </div>
                <h3 className="text-2xl font-bold text-gray-900 mb-3">Không tìm thấy</h3>
                <p className="text-gray-600 mb-6">
                  Mã đặt sân <strong className="text-emerald-700">{bookingCode}</strong> không tồn tại trong hệ thống
                </p>
                <div className="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm">
                  <Phone className="w-4 h-4" />
                  <span>
                    Liên hệ hotline: <strong>0886 264 644</strong>
                  </span>
                </div>
              </div>
            )}
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
