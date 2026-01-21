"use client"

import type React from "react"
import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState, useEffect } from "react"
import { ChevronRight, User, Mail, Phone, Calendar, Clock, MapPin, CreditCard, CheckCircle2 } from "lucide-react"

export default function PersonalInfoPage() {
  const [formData, setFormData] = useState({
    fullName: "",
    email: "",
    phone: "",
  })
  const [bookingData, setBookingData] = useState<any>(null)
  const [currentStep] = useState(2)

  useEffect(() => {
    const booking = localStorage.getItem("tempBooking")
    if (booking) {
      setBookingData(JSON.parse(booking))
    }
  }, [])

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }))
  }

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    localStorage.setItem("personalInfo", JSON.stringify(formData))
    window.location.href = "/thanh-toan"
  }

  const isFormComplete = formData.fullName && formData.email && formData.phone

  const steps = [
    { id: 1, name: "Chọn sân", icon: MapPin, completed: true },
    { id: 2, name: "Thông tin", icon: User, completed: false, current: true },
    { id: 3, name: "Thanh toán", icon: CreditCard, completed: false },
  ]

  return (
    <div className="min-h-screen flex flex-col bg-[#f8f9fa]">
      <Navigation />

      <main className="flex-1">
        <section className="bg-white border-b border-gray-100 py-8">
          <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {/* Step Progress */}
            <div className="flex items-center justify-center gap-4 mb-8">
              {steps.map((step, index) => (
                <div key={step.id} className="flex items-center">
                  <div className="flex items-center gap-2">
                    <div
                      className={`w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-all ${
                        step.completed
                          ? "bg-emerald-500 text-white"
                          : step.current
                            ? "bg-emerald-600 text-white ring-4 ring-emerald-100"
                            : "bg-gray-100 text-gray-400"
                      }`}
                    >
                      {step.completed ? <CheckCircle2 className="w-5 h-5" /> : step.id}
                    </div>
                    <span
                      className={`text-sm font-medium hidden sm:block ${
                        step.current ? "text-emerald-700" : step.completed ? "text-emerald-600" : "text-gray-400"
                      }`}
                    >
                      {step.name}
                    </span>
                  </div>
                  {index < steps.length - 1 && (
                    <div className={`w-12 sm:w-20 h-0.5 mx-3 ${step.completed ? "bg-emerald-500" : "bg-gray-200"}`} />
                  )}
                </div>
              ))}
            </div>

            <h1 className="text-2xl md:text-3xl font-bold text-gray-900 text-center">Thông Tin Cá Nhân</h1>
            <p className="text-gray-500 text-center mt-2">Vui lòng điền thông tin để hoàn tất đặt sân</p>
          </div>
        </section>

        <section className="py-10 max-w-5xl mx-auto px-4">
          <div className="grid lg:grid-cols-5 gap-8">
            {/* Form Column - 3/5 */}
            <div className="lg:col-span-3">
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                  <h2 className="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <div className="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                      <User className="w-4 h-4 text-emerald-600" />
                    </div>
                    Thông tin liên hệ
                  </h2>

                  <div className="space-y-5">
                    {/* Full Name */}
                    <div>
                      <label htmlFor="fullName" className="block text-sm font-medium text-gray-700 mb-2">
                        Họ và Tên <span className="text-red-500">*</span>
                      </label>
                      <div className="relative">
                        <User className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input
                          id="fullName"
                          type="text"
                          name="fullName"
                          value={formData.fullName}
                          onChange={handleInputChange}
                          placeholder="Nguyễn Văn A"
                          required
                          className="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all text-gray-900 bg-white placeholder:text-gray-400"
                        />
                      </div>
                    </div>

                    {/* Email */}
                    <div>
                      <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                        Email <span className="text-red-500">*</span>
                      </label>
                      <div className="relative">
                        <Mail className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input
                          id="email"
                          type="email"
                          name="email"
                          value={formData.email}
                          onChange={handleInputChange}
                          placeholder="email@example.com"
                          required
                          className="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all text-gray-900 bg-white placeholder:text-gray-400"
                        />
                      </div>
                    </div>

                    {/* Phone */}
                    <div>
                      <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-2">
                        Số Điện Thoại <span className="text-red-500">*</span>
                      </label>
                      <div className="relative">
                        <Phone className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input
                          id="phone"
                          type="tel"
                          name="phone"
                          value={formData.phone}
                          onChange={handleInputChange}
                          placeholder="0123 456 789"
                          required
                          className="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all text-gray-900 bg-white placeholder:text-gray-400"
                        />
                      </div>
                    </div>
                  </div>
                </div>

                {/* Submit Button */}
                <button
                  type="submit"
                  disabled={!isFormComplete}
                  className={`w-full flex items-center justify-center gap-2 py-4 rounded-xl font-semibold transition-all text-base ${
                    isFormComplete
                      ? "bg-emerald-600 text-white hover:bg-emerald-700 active:scale-[0.98] shadow-lg shadow-emerald-600/25"
                      : "bg-gray-100 text-gray-400 cursor-not-allowed"
                  }`}
                >
                  Tiếp Tục Thanh Toán
                  <ChevronRight className="w-5 h-5" />
                </button>
              </form>
            </div>

            {/* Summary Column - 2/5 */}
            <div className="lg:col-span-2">
              <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
                <h3 className="text-lg font-semibold text-gray-900 mb-5">Tóm tắt đặt sân</h3>

                {bookingData && bookingData.length > 0 ? (
                  <div className="space-y-4">
                    {/* Court Info */}
                    <div className="flex items-start gap-3 pb-4 border-b border-gray-100">
                      <div className="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <MapPin className="w-5 h-5 text-emerald-600" />
                      </div>
                      <div>
                        <p className="text-sm text-gray-500">Sân</p>
                        <p className="font-semibold text-gray-900">{bookingData[0]?.court}</p>
                      </div>
                    </div>

                    {/* Date */}
                    <div className="flex items-start gap-3 pb-4 border-b border-gray-100">
                      <div className="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <Calendar className="w-5 h-5 text-blue-600" />
                      </div>
                      <div>
                        <p className="text-sm text-gray-500">Ngày</p>
                        <p className="font-semibold text-gray-900">{bookingData[0]?.date}</p>
                      </div>
                    </div>

                    {/* Time Slots */}
                    <div className="flex items-start gap-3 pb-4 border-b border-gray-100">
                      <div className="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <Clock className="w-5 h-5 text-amber-600" />
                      </div>
                      <div>
                        <p className="text-sm text-gray-500">Khung giờ</p>
                        <p className="font-semibold text-gray-900">{bookingData.length} khung</p>
                      </div>
                    </div>

                    {/* Total */}
                    <div className="pt-2">
                      <div className="flex justify-between items-center">
                        <span className="text-gray-600">Tạm tính</span>
                        <span className="text-xl font-bold text-emerald-600">
                          {(bookingData.length * 150000).toLocaleString("vi-VN")}đ
                        </span>
                      </div>
                    </div>
                  </div>
                ) : (
                  <div className="text-center py-8">
                    <div className="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                      <Calendar className="w-8 h-8 text-gray-400" />
                    </div>
                    <p className="text-gray-500">Chưa có thông tin đặt sân</p>
                    <a
                      href="/dat-san"
                      className="text-emerald-600 font-medium text-sm mt-2 inline-block hover:underline"
                    >
                      Đặt sân ngay
                    </a>
                  </div>
                )}
              </div>

              {/* Security Note */}
              <div className="mt-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <div className="flex gap-3">
                  <CheckCircle2 className="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" />
                  <div>
                    <p className="text-sm font-medium text-emerald-800">Thông tin được bảo mật</p>
                    <p className="text-xs text-emerald-600 mt-1">
                      Dữ liệu của bạn được mã hóa và bảo vệ an toàn theo tiêu chuẩn bảo mật cao nhất.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
