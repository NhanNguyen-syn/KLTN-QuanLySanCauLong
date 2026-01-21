"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import Link from "next/link"
import { useEffect, useState } from "react"
import { CheckCircle2, MapPin, Calendar, Clock, User, Phone, Mail, Download, Share2 } from "lucide-react"

export default function ConfirmationPage() {
  const [personalInfo, setPersonalInfo] = useState<any>(null)
  const [bookingData, setBookingData] = useState<any>(null)
  const [orderCode, setOrderCode] = useState("")

  useEffect(() => {
    const personal = localStorage.getItem("personalInfo")
    const booking = localStorage.getItem("tempBooking")

    if (personal) setPersonalInfo(JSON.parse(personal))
    if (booking) setBookingData(JSON.parse(booking))

    // Generate order code
    const code = `BD${Math.floor(Math.random() * 999999)
      .toString()
      .padStart(6, "0")}`
    setOrderCode(code)
  }, [])

  const calculateTotal = () => {
    if (!bookingData || bookingData.length === 0) return 0
    return bookingData.reduce((sum: number, item: any) => sum + (item.price || 150000), 0)
  }

  return (
    <div className="min-h-screen flex flex-col bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">
      <Navigation />

      <main className="flex-1 py-12 md:py-20">
        <div className="max-w-4xl mx-auto px-4">
          {/* Success Animation */}
          <div className="text-center mb-8">
            <div className="w-24 h-24 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl animate-in zoom-in duration-500">
              <CheckCircle2 className="w-12 h-12 text-white" />
            </div>
            <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-3 animate-in fade-in slide-in-from-bottom-4 duration-700">
              Đặt Sân Thành Công!
            </h1>
            <p className="text-gray-600 text-lg animate-in fade-in slide-in-from-bottom-4 duration-700 delay-100">
              Cảm ơn bạn đã tin tưởng BadmintonPro. Thông tin chi tiết đã được gửi qua email.
            </p>
          </div>

          {/* Invoice Card */}
          <div className="bg-white rounded-3xl shadow-2xl border border-emerald-100 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-700 delay-200">
            {/* Header */}
            <div className="bg-gradient-to-r from-[#065f46] via-[#059669] to-[#14b8a6] text-white p-8">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-white/80 mb-1">Mã Đơn Hàng</p>
                  <p className="text-3xl md:text-4xl font-bold">{orderCode}</p>
                </div>
                <div className="flex gap-2">
                  <button className="p-3 bg-white/20 hover:bg-white/30 rounded-xl transition-colors">
                    <Download className="w-5 h-5" />
                  </button>
                  <button className="p-3 bg-white/20 hover:bg-white/30 rounded-xl transition-colors">
                    <Share2 className="w-5 h-5" />
                  </button>
                </div>
              </div>
            </div>

            {/* Content */}
            <div className="p-8 md:p-10 space-y-8">
              {/* Customer Info */}
              {personalInfo && (
                <div>
                  <h2 className="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <div className="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                      <User className="w-4 h-4 text-emerald-700" />
                    </div>
                    Thông Tin Khách Hàng
                  </h2>
                  <div className="grid md:grid-cols-2 gap-4 bg-gray-50 rounded-2xl p-6">
                    <div className="flex items-start gap-3">
                      <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                        <User className="w-5 h-5 text-emerald-600" />
                      </div>
                      <div>
                        <p className="text-xs text-gray-500 mb-1">Họ và tên</p>
                        <p className="font-bold text-gray-900">{personalInfo.fullName}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                        <Phone className="w-5 h-5 text-emerald-600" />
                      </div>
                      <div>
                        <p className="text-xs text-gray-500 mb-1">Số điện thoại</p>
                        <p className="font-bold text-gray-900">{personalInfo.phone}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3 md:col-span-2">
                      <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                        <Mail className="w-5 h-5 text-emerald-600" />
                      </div>
                      <div>
                        <p className="text-xs text-gray-500 mb-1">Email</p>
                        <p className="font-bold text-gray-900 break-all">{personalInfo.email}</p>
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Booking Details */}
              {bookingData && bookingData.length > 0 && (
                <div>
                  <h2 className="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <div className="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                      <MapPin className="w-4 h-4 text-emerald-700" />
                    </div>
                    Thông Tin Đặt Sân
                  </h2>
                  <div className="space-y-4">
                    {(() => {
                      // Group by court and date
                      const grouped = bookingData.reduce((acc: any, item: any) => {
                        const key = `${item.court}-${item.date}`
                        if (!acc[key]) {
                          acc[key] = {
                            court: item.court,
                            date: item.date,
                            times: [],
                            price: 0,
                          }
                        }
                        acc[key].times.push(item.time)
                        acc[key].price += item.price || 150000
                        return acc
                      }, {})

                      return Object.values(grouped).map((group: any, index: number) => (
                        <div
                          key={index}
                          className="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 border-2 border-emerald-200"
                        >
                          <div className="flex items-start justify-between mb-4">
                            <div className="flex items-start gap-3">
                              <div className="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <MapPin className="w-6 h-6 text-white" />
                              </div>
                              <div>
                                <p className="font-bold text-gray-900 text-xl mb-1">{group.court}</p>
                                <div className="flex items-center gap-2 text-sm text-gray-600">
                                  <Calendar className="w-4 h-4" />
                                  <span>
                                    {new Date(group.date).toLocaleDateString("vi-VN", {
                                      weekday: "long",
                                      year: "numeric",
                                      month: "long",
                                      day: "numeric",
                                    })}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div className="text-right bg-white rounded-xl px-4 py-2 shadow-sm">
                              <p className="text-xs text-gray-500 mb-1">Thành tiền</p>
                              <p className="font-bold text-emerald-700 text-xl">{group.price.toLocaleString()}đ</p>
                            </div>
                          </div>
                          <div className="bg-white rounded-xl p-4">
                            <div className="flex items-start gap-2">
                              <Clock className="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" />
                              <div>
                                <p className="text-xs text-gray-500 mb-1">Khung giờ</p>
                                <p className="font-semibold text-gray-900">{group.times.join(", ")}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      ))
                    })()}
                  </div>
                </div>
              )}

              {/* Total */}
              <div className="border-t-2 border-gray-200 pt-6">
                <div className="flex items-center justify-between bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl p-6">
                  <span className="text-xl font-bold">Tổng Thanh Toán</span>
                  <span className="text-3xl font-bold">{calculateTotal().toLocaleString()}đ</span>
                </div>
              </div>

              {/* Status Badge */}
              <div className="text-center">
                <div className="inline-flex items-center gap-3 bg-green-50 border-2 border-green-500 rounded-full px-6 py-3">
                  <div className="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                  <p className="text-lg font-bold text-green-700">Đã Xác Nhận & Thanh Toán</p>
                </div>
              </div>
            </div>
          </div>

          {/* Action Buttons */}
          <div className="flex flex-col sm:flex-row gap-4 justify-center mt-8 animate-in fade-in slide-in-from-bottom-4 duration-700 delay-300">
            <Link
              href="/"
              className="inline-flex items-center justify-center bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-8 py-4 rounded-xl font-bold hover:shadow-xl transition-all hover:scale-105"
            >
              Về Trang Chủ
            </Link>
            <Link
              href="/tra-cuu"
              className="inline-flex items-center justify-center bg-white text-emerald-700 border-2 border-emerald-600 px-8 py-4 rounded-xl font-bold hover:bg-emerald-50 transition-all hover:scale-105"
            >
              Tra Cứu Đơn Hàng
            </Link>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  )
}
