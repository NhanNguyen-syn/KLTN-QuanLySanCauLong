"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState, useEffect } from "react"
import {
  CreditCard,
  Shield,
  CheckCircle2,
  Building2,
  Smartphone,
  MapPin,
  Calendar,
  Clock,
  User,
  Phone,
  Mail,
} from "lucide-react"

export default function CheckoutPage() {
  const [personalInfo, setPersonalInfo] = useState<any>(null)
  const [bookingData, setBookingData] = useState<any>(null)
  const [customerData, setCustomerData] = useState<any>(null)
  const [formData, setFormData] = useState({
    paymentMethod: "bank-transfer",
    paymentType: "full",
  })

  useEffect(() => {
    const personal = localStorage.getItem("personalInfo")
    const booking = localStorage.getItem("tempBooking")
    const customer = localStorage.getItem("customerData")

    if (personal) setPersonalInfo(JSON.parse(personal))
    if (booking) setBookingData(JSON.parse(booking))
    if (customer) setCustomerData(JSON.parse(customer))
  }, [])

  const handleInputChange = (e: any) => {
    const { name, value } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }))
  }

  const handleSubmit = (e: any) => {
    e.preventDefault()
    window.location.href = "/xac-nhan"
  }

  const isCasualCustomer = customerData?.customerType === "casual"

  const calculateTotal = () => {
    if (!bookingData || bookingData.length === 0) return 0
    const total = bookingData.reduce((sum: number, item: any) => sum + (item.price || 0), 0)
    return total
  }

  const calculateDuration = () => {
    if (!bookingData || bookingData.length === 0) return "0h"
    const hours = bookingData.length * 0.5
    return `${hours}h`
  }

  const getTimeRange = () => {
    if (!bookingData || bookingData.length === 0) return ""
    const times = bookingData.map((item: any) => item.time).sort()
    if (times.length === 1) return times[0]
    return `${times[0]} - ${times[times.length - 1]}`
  }

  const getCustomerTypeName = () => {
    if (!customerData) return ""
    return customerData.customerType === "casual" ? "Khách vãng lai" : "Khách cố định"
  }

  const total = calculateTotal()
  const depositAmount = Math.round(total * 0.3)
  const paymentAmount = formData.paymentType === "deposit" ? depositAmount : total

  return (
    <div className="min-h-screen flex flex-col bg-gradient-to-br from-gray-50 to-emerald-50">
      <Navigation />

      <main className="flex-1">
        {/* Header */}
        <section className="bg-gradient-to-r from-[#065f46] via-[#059669] to-[#14b8a6] text-white py-12 md:py-14">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex items-center gap-3 mb-3">
              <CreditCard className="w-8 h-8" />
              <h1 className="text-3xl md:text-4xl font-bold">Thanh Toán</h1>
            </div>
            <p className="text-lg text-white/90">Xác nhận thông tin và hoàn tất thanh toán</p>
          </div>
        </section>

        {/* Form */}
        <section className="py-12 max-w-7xl mx-auto px-4">
          <div className="grid lg:grid-cols-3 gap-8">
            {/* Left: Payment Options */}
            <div className="lg:col-span-2 space-y-6">
              <form onSubmit={handleSubmit} className="space-y-6">
                {/* Payment Method Selection */}
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                  <h3 className="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                      <CreditCard className="w-5 h-5 text-emerald-600" />
                    </div>
                    Phương Thức Thanh Toán
                  </h3>
                  <div className="space-y-3">
                    <label
                      className={`p-5 rounded-xl border-2 cursor-pointer transition-all block ${
                        formData.paymentMethod === "bank-transfer"
                          ? "bg-emerald-50 border-emerald-500 shadow-sm"
                          : "border-gray-200 hover:border-emerald-300 hover:bg-gray-50"
                      }`}
                    >
                      <div className="flex items-start gap-4">
                        <input
                          type="radio"
                          name="paymentMethod"
                          value="bank-transfer"
                          checked={formData.paymentMethod === "bank-transfer"}
                          onChange={handleInputChange}
                          className="mt-1 w-5 h-5 text-emerald-600 focus:ring-emerald-500"
                        />
                        <div className="flex-1">
                          <div className="flex items-center gap-2 mb-1">
                            <Building2 className="w-5 h-5 text-emerald-600" />
                            <span className="font-semibold text-gray-900 text-lg">Chuyển Khoản Ngân Hàng</span>
                          </div>
                          <p className="text-sm text-gray-600">
                            Chuyển khoản trực tiếp qua ngân hàng (Vietcombank, VCB)
                          </p>
                        </div>
                      </div>
                    </label>
                    <label
                      className={`p-5 rounded-xl border-2 cursor-pointer transition-all block ${
                        formData.paymentMethod === "vnpay"
                          ? "bg-emerald-50 border-emerald-500 shadow-sm"
                          : "border-gray-200 hover:border-emerald-300 hover:bg-gray-50"
                      }`}
                    >
                      <div className="flex items-start gap-4">
                        <input
                          type="radio"
                          name="paymentMethod"
                          value="vnpay"
                          checked={formData.paymentMethod === "vnpay"}
                          onChange={handleInputChange}
                          className="mt-1 w-5 h-5 text-emerald-600 focus:ring-emerald-500"
                        />
                        <div className="flex-1">
                          <div className="flex items-center gap-2 mb-1">
                            <Smartphone className="w-5 h-5 text-emerald-600" />
                            <span className="font-semibold text-gray-900 text-lg">VNPay</span>
                          </div>
                          <p className="text-sm text-gray-600">Thanh toán qua ví điện tử VNPay, ứng dụng ngân hàng</p>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>

                {isCasualCustomer && (
                  <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 className="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <CreditCard className="w-5 h-5 text-emerald-600" />
                      </div>
                      Hình Thức Thanh Toán
                    </h3>
                    <div className="space-y-3">
                      <label
                        className={`p-4 rounded-xl border-2 cursor-pointer transition-all block ${
                          formData.paymentType === "full"
                            ? "bg-emerald-50 border-emerald-500 shadow-sm"
                            : "border-gray-200 hover:border-emerald-300 hover:bg-gray-50"
                        }`}
                      >
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentType"
                            value="full"
                            checked={formData.paymentType === "full"}
                            onChange={handleInputChange}
                            className="w-5 h-5 text-emerald-600 focus:ring-emerald-500"
                          />
                          <div>
                            <span className="font-semibold text-gray-900 block">Thanh Toán Toàn Bộ</span>
                            <p className="text-xs text-gray-600 mt-1">Thanh toán 100% giá sân</p>
                          </div>
                        </div>
                      </label>
                      <label
                        className={`p-4 rounded-xl border-2 cursor-pointer transition-all block ${
                          formData.paymentType === "deposit"
                            ? "bg-emerald-50 border-emerald-500 shadow-sm"
                            : "border-gray-200 hover:border-emerald-300 hover:bg-gray-50"
                        }`}
                      >
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentType"
                            value="deposit"
                            checked={formData.paymentType === "deposit"}
                            onChange={handleInputChange}
                            className="w-5 h-5 text-emerald-600 focus:ring-emerald-500"
                          />
                          <div>
                            <span className="font-semibold text-gray-900 block">Đặt Cọc 30%</span>
                            <p className="text-xs text-gray-600 mt-1">Thanh toán 30%, phần còn lại khi sử dụng</p>
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>
                )}

                {/* Transfer Details */}
                {formData.paymentMethod === "bank-transfer" && (
                  <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 className="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <Shield className="w-5 h-5 text-emerald-600" />
                      </div>
                      Chi Tiết Chuyển Khoản
                    </h3>
                    <div className="space-y-4 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-100">
                      <div>
                        <p className="text-xs text-gray-600 uppercase font-bold mb-1">Ngân Hàng</p>
                        <p className="font-bold text-lg text-gray-900">Vietcombank (VCB)</p>
                      </div>
                      <div>
                        <p className="text-xs text-gray-600 uppercase font-bold mb-1">Số Tài Khoản</p>
                        <p className="font-bold text-xl text-emerald-700 font-mono">0123456789</p>
                      </div>
                      <div>
                        <p className="text-xs text-gray-600 uppercase font-bold mb-1">Chủ Tài Khoản</p>
                        <p className="font-bold text-gray-900">BADMINTON PRO CENTER</p>
                      </div>
                      <div>
                        <p className="text-xs text-gray-600 uppercase font-bold mb-1">Nội Dung Chuyển Khoản</p>
                        <div className="bg-white p-3 rounded-lg border border-emerald-200 mt-2">
                          <p className="font-mono font-bold text-gray-900 text-sm break-all">
                            {personalInfo?.fullName || "[TÊN BẠN]"} DATSAN
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                )}

                {/* VNPay Payment Button */}
                {formData.paymentMethod === "vnpay" && (
                  <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 className="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <Shield className="w-5 h-5 text-emerald-600" />
                      </div>
                      Thanh Toán VNPay
                    </h3>
                    <div className="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-200">
                      <p className="text-sm text-gray-700 mb-4">
                        Bạn sẽ được chuyển đến cổng thanh toán VNPay để hoàn tất giao dịch một cách an toàn.
                      </p>
                      <div className="flex items-center gap-2 text-sm text-gray-700">
                        <CheckCircle2 className="w-4 h-4 text-green-600" />
                        <span>Bảo mật cao với mã hóa SSL</span>
                      </div>
                    </div>
                  </div>
                )}

                <button
                  type="submit"
                  className="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-4 rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all text-lg flex items-center justify-center gap-2"
                >
                  {formData.paymentMethod === "vnpay" ? "Thanh Toán Với VNPay" : "Xác Nhận Thanh Toán"}
                  <CheckCircle2 className="w-5 h-5" />
                </button>
              </form>
            </div>

            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 h-fit sticky top-24">
              <h3 className="text-xl font-bold text-gray-900 mb-6">Tóm Tắt Đơn Hàng</h3>

              {/* Personal Information */}
              {personalInfo && (
                <div className="space-y-4 mb-6 pb-6 border-b border-gray-200">
                  <h4 className="font-bold text-gray-900 text-sm uppercase tracking-wide text-emerald-700">
                    Thông Tin Khách Hàng
                  </h4>
                  <div className="space-y-3">
                    <div className="flex items-start gap-3">
                      <div className="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <User className="w-4 h-4 text-emerald-600" />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-xs text-gray-500 mb-0.5">Họ và tên</p>
                        <p className="font-semibold text-gray-900 truncate">{personalInfo.fullName}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <div className="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <Phone className="w-4 h-4 text-emerald-600" />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-xs text-gray-500 mb-0.5">Số điện thoại</p>
                        <p className="font-semibold text-gray-900">{personalInfo.phone}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <div className="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <Mail className="w-4 h-4 text-emerald-600" />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-xs text-gray-500 mb-0.5">Email</p>
                        <p className="font-semibold text-gray-900 truncate text-sm">{personalInfo.email}</p>
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Booking Details - Multiple Courts */}
              {bookingData && bookingData.length > 0 && (
                <div className="space-y-4 mb-6 pb-6 border-b border-gray-200">
                  <h4 className="font-bold text-gray-900 text-sm uppercase tracking-wide text-emerald-700">
                    Chi Tiết Đặt Sân
                  </h4>

                  {/* Group bookings by court */}
                  {(() => {
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
                        className="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-4 border border-emerald-100"
                      >
                        <div className="flex items-start gap-3 mb-3">
                          <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            <MapPin className="w-5 h-5 text-emerald-600" />
                          </div>
                          <div className="flex-1">
                            <p className="font-bold text-gray-900">{group.court}</p>
                            <div className="flex items-center gap-1.5 text-xs text-gray-600 mt-1">
                              <Calendar className="w-3.5 h-3.5" />
                              <span>{new Date(group.date).toLocaleDateString("vi-VN")}</span>
                            </div>
                          </div>
                        </div>
                        <div className="bg-white rounded-lg p-3 space-y-2">
                          <div className="flex items-center gap-2 text-sm">
                            <Clock className="w-4 h-4 text-gray-400" />
                            <span className="text-gray-700 font-medium">{group.times.length} khung giờ</span>
                          </div>
                          <p className="text-xs text-gray-600 pl-6">{group.times.join(", ")}</p>
                          <div className="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span className="text-xs text-gray-600">Thành tiền:</span>
                            <span className="font-bold text-emerald-700">{group.price.toLocaleString()}đ</span>
                          </div>
                        </div>
                      </div>
                    ))
                  })()}
                </div>
              )}

              {/* Payment Amount */}
              <div className="space-y-3 mb-6">
                <div className="flex justify-between items-center text-sm">
                  <span className="text-gray-600">Tổng tiền sân:</span>
                  <span className="font-bold text-gray-900">{total.toLocaleString()}đ</span>
                </div>
                {formData.paymentType === "deposit" && isCasualCustomer && (
                  <>
                    <div className="flex justify-between items-center text-sm">
                      <span className="text-gray-600">Đặt cọc (30%):</span>
                      <span className="font-bold text-emerald-600">{depositAmount.toLocaleString()}đ</span>
                    </div>
                    <div className="flex justify-between items-center text-xs text-gray-500">
                      <span>Còn lại khi đến sân:</span>
                      <span>{(total - depositAmount).toLocaleString()}đ</span>
                    </div>
                  </>
                )}
              </div>

              <div className="flex justify-between items-center pt-4 border-t-2 border-gray-200 mb-6">
                <span className="font-bold text-lg text-gray-900">Cần Thanh Toán:</span>
                <span className="text-2xl font-bold text-emerald-600">{paymentAmount.toLocaleString()}đ</span>
              </div>

              {/* Benefits */}
              <div className="space-y-2.5 text-xs bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                <div className="flex items-start gap-2">
                  <CheckCircle2 className="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" />
                  <p className="text-gray-700">Thanh toán an toàn, bảo mật</p>
                </div>
                <div className="flex items-start gap-2">
                  <CheckCircle2 className="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" />
                  <p className="text-gray-700">Hoàn tiền nếu hủy trước 2 giờ</p>
                </div>
                <div className="flex items-start gap-2">
                  <CheckCircle2 className="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" />
                  <p className="text-gray-700">Xác nhận qua email ngay lập tức</p>
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
