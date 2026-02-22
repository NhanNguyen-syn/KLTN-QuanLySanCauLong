"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState } from "react"
import { Send, CheckCircle, Clock, Shield, Heart, Sparkles } from 'lucide-react'

export default function ContactPage() {
  const [formData, setFormData] = useState({
    name: "",
    phone: "",
    message: "",
  })

  const [submitted, setSubmitted] = useState(false)

  const handleInputChange = (e) => {
    const { name, value } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }))
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    setSubmitted(true)
    setTimeout(() => {
      setFormData({ name: "", phone: "", message: "" })
      setSubmitted(false)
    }, 3000)
  }

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        <section className="py-20 md:py-28 bg-gray-50">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid lg:grid-cols-2 gap-12 items-center">
              {/* Left Column - Form */}
              <div>
                <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold text-foreground mb-12 leading-tight">
                  Hãy liên hệ
                  <br />
                  với chúng tôi
                </h1>

                {submitted && (
                  <div className="mb-6 bg-emerald-50 border-2 border-emerald-200 rounded-xl p-4 flex items-start gap-3">
                    <CheckCircle className="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" />
                    <p className="text-emerald-700 font-medium">Tin nhắn đã được gửi thành công!</p>
                  </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-8">
                  <div>
                    <label className="block text-sm font-medium text-foreground mb-2">
                      Họ và Tên <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="text"
                      name="name"
                      value={formData.name}
                      onChange={handleInputChange}
                      required
                      className="w-full bg-transparent border-b-2 border-gray-300 py-3 focus:outline-none focus:border-[#059669] transition-colors text-foreground"
                      placeholder=""
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-foreground mb-2">
                      Số Điện Thoại <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="tel"
                      name="phone"
                      value={formData.phone}
                      onChange={handleInputChange}
                      required
                      className="w-full bg-transparent border-b-2 border-gray-300 py-3 focus:outline-none focus:border-[#059669] transition-colors text-foreground"
                      placeholder=""
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-foreground mb-2">
                      Tin Nhắn <span className="text-red-500">*</span>
                    </label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleInputChange}
                      required
                      rows={4}
                      className="w-full bg-transparent border-b-2 border-gray-300 py-3 focus:outline-none focus:border-[#059669] transition-colors resize-none text-foreground"
                      placeholder=""
                    />
                  </div>

                  <button
                    type="submit"
                    className="bg-gradient-to-r from-[#065f46] to-[#059669] text-white px-12 py-4 rounded-full font-bold hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2"
                  >
                    <Send className="w-5 h-5" />
                    GỬI TIN NHẮN
                  </button>
                </form>
              </div>

              {/* Right Column - Image */}
              <div className="relative h-[500px] lg:h-[600px] rounded-3xl overflow-hidden shadow-2xl">
                <img
                  src="/badminton-court-facility-modern.jpg"
                  alt="Sân cầu lông hiện đại"
                  className="w-full h-full object-cover"
                />
              </div>
            </div>
          </div>
        </section>

        <section className="py-16 md:py-20 bg-white">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                Tại Sao Nên Chọn Chúng Tôi?
              </h2>
              <p className="text-muted-foreground text-lg max-w-2xl mx-auto">
                Chúng tôi cam kết mang đến trải nghiệm đặt sân tuyệt vời nhất cho bạn
              </p>
            </div>

            <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
              {/* Phản hồi nhanh */}
              <div className="text-center group">
                <div className="w-16 h-16 bg-gradient-to-br from-[#065f46] to-[#059669] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                  <Clock className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Phản Hồi Nhanh</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Đội ngũ hỗ trợ 24/7 sẵn sàng giải đáp mọi thắc mắc của bạn trong vòng 30 phút
                </p>
              </div>

              {/* Đáng tin cậy */}
              <div className="text-center group">
                <div className="w-16 h-16 bg-gradient-to-br from-[#065f46] to-[#059669] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                  <Shield className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Đáng Tin Cậy</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Hệ thống đặt sân minh bạch, bảo mật thông tin khách hàng tuyệt đối
                </p>
              </div>

              {/* Dịch vụ tận tâm */}
              <div className="text-center group">
                <div className="w-16 h-16 bg-gradient-to-br from-[#065f46] to-[#059669] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                  <Heart className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Dịch Vụ Tận Tâm</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Đội ngũ nhân viên chuyên nghiệp, nhiệt tình luôn đặt khách hàng lên hàng đầu
                </p>
              </div>

              {/* Ưu đãi hấp dẫn */}
              <div className="text-center group">
                <div className="w-16 h-16 bg-gradient-to-br from-[#065f46] to-[#059669] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                  <Sparkles className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Ưu Đãi Hấp Dẫn</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Nhiều chương trình khuyến mãi và ưu đãi đặc biệt dành cho khách hàng thân thiết
                </p>
              </div>
            </div>
          </div>
        </section>
        {/* </CHANGE> */}
      </main>

      <Footer />
    </div>
  )
}
