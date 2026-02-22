"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { Droplets, Shirt, Clock, Gift, UtensilsCrossed, Headphones, DollarSign, Award } from "lucide-react"

export default function BenefitsPage() {
  const casualBenefits = [
    {
      title: "Nước Uống 10L",
      description: "Nước uống miễn phí 10 lít cho mỗi buổi chơi",
      icon: <Droplets className="w-7 h-7" />,
    },
    {
      title: "Khăn Ướt",
      description: "Khăn lau mặt ướt chất lượng cao cấp",
      icon: <Shirt className="w-7 h-7" />,
    },
    {
      title: "Ưu Tiên Đặt Sân",
      description: "Được ưu tiên đặt sân trước 1 giờ",
      icon: <Clock className="w-7 h-7" />,
    },
    {
      title: "Quà Tặng Hàng Tháng",
      description: "Nhận voucher ưu đãi đặc biệt mỗi tháng",
      icon: <Gift className="w-7 h-7" />,
    },
  ]

  const fixedBenefits = [
    {
      title: "Nước Ion Cao Cấp",
      description: "Nước ion miễn phí không giới hạn",
      icon: <Droplets className="w-6 h-6" />,
      highlight: true,
    },
    {
      title: "Khăn Khô Cao Cấp",
      description: "Khăn lau khô cao cấp thấm hút tốt",
      icon: <Shirt className="w-6 h-6" />,
    },
    {
      title: "Ăn Nhẹ 4-6 Người",
      description: "Buffet ăn nhẹ dành cho nhóm mỗi tuần",
      icon: <UtensilsCrossed className="w-6 h-6" />,
      highlight: true,
    },
    {
      title: "Ưu Tiên Giờ Vàng",
      description: "Ưu tiên đặt sân vào khung giờ cao điểm",
      icon: <Clock className="w-6 h-6" />,
    },
    {
      title: "Hỗ Trợ VIP 24/7",
      description: "Chăm sóc khách hàng VIP 24/7",
      icon: <Headphones className="w-6 h-6" />,
      highlight: true,
    },
    {
      title: "Quà Tặng Đặc Biệt",
      description: "Quà tặng cao cấp và voucher độc quyền",
      icon: <Gift className="w-6 h-6" />,
    },
    {
      title: "Giá Ưu Đãi",
      description: "Chỉ 120.000đ/giờ, tiết kiệm 30.000đ",
      icon: <DollarSign className="w-6 h-6" />,
      highlight: true,
    },
    {
      title: "Huấn Luyện 1-1",
      description: "Tư vấn và huấn luyện 1 lần/tháng",
      icon: <Award className="w-6 h-6" />,
      highlight: true,
    },
  ]

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        <section className="relative bg-gradient-to-br from-[#065f46] via-[#065f46]/95 to-[#065f46]/90 text-white overflow-hidden pt-12 pb-16 md:pt-14 md:pb-18">
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 right-0 w-96 h-96 bg-[#14b8a6] rounded-full blur-3xl"></div>
            <div className="absolute bottom-0 left-0 w-96 h-96 bg-[#059669] rounded-full blur-3xl"></div>
          </div>

          <div className="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="max-w-3xl mx-auto text-center space-y-5">
              <div className="inline-block mb-4 px-5 py-2 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                <span className="text-sm font-bold">Dịch Vụ Chất Lượng Cao</span>
              </div>
              <h1 className="text-4xl md:text-5xl font-extrabold font-serif mb-4 text-balance leading-tight">
                Tiêu Chuẩn Dịch Vụ
              </h1>
              <p className="text-base md:text-lg text-white/90 max-w-2xl mx-auto leading-relaxed text-pretty">
                Khám phá quyền lợi và dịch vụ cao cấp dành riêng cho từng loại khách hàng
              </p>
            </div>
          </div>
        </section>

        <section className="py-12 md:py-14 bg-background">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {/* Khách Vãng Lai */}
            <div className="mb-16">
              <div className="mb-10 text-center">
                <div className="inline-block mb-4 px-4 py-1.5 rounded-full bg-[#059669]/10 border border-[#059669]/30">
                  <span className="text-sm font-bold text-[#059669]">Linh Hoạt & Tiện Lợi</span>
                </div>
                <h2 className="text-3xl md:text-4xl font-extrabold font-serif text-foreground mb-3 text-balance">
                  Khách Vãng Lai
                </h2>
                <p className="text-base md:text-lg text-muted-foreground text-pretty">
                  Đặt sân theo nhu cầu với giá chuẩn <span className="font-bold text-foreground">150.000đ/giờ</span>
                </p>
              </div>

              <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {casualBenefits.map((benefit, idx) => (
                  <div
                    key={idx}
                    className="group bg-white rounded-xl border border-border p-6 hover:shadow-lg hover:border-[#059669] transition-all duration-300 hover:-translate-y-1"
                  >
                    <div className="w-14 h-14 rounded-xl bg-gradient-to-br from-[#059669] to-[#14b8a6] text-white flex items-center justify-center mb-5 group-hover:scale-110 transition-transform shadow-sm">
                      {benefit.icon}
                    </div>
                    <h3 className="text-lg font-bold text-foreground mb-2">{benefit.title}</h3>
                    <p className="text-sm text-muted-foreground leading-relaxed">{benefit.description}</p>
                  </div>
                ))}
              </div>
            </div>

            <div className="my-12 flex items-center gap-4">
              <div className="flex-1 h-px bg-gradient-to-r from-transparent via-border to-border"></div>
              <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[#059669] to-[#14b8a6] flex items-center justify-center shadow-sm">
                <span className="text-lg font-bold text-white">VS</span>
              </div>
              <div className="flex-1 h-px bg-gradient-to-l from-transparent via-border to-border"></div>
            </div>

            <div>
              <div className="mb-10 text-center bg-gradient-to-br from-[#065f46]/5 to-[#059669]/5 rounded-2xl border border-[#065f46]/20 p-8 relative overflow-hidden">
                <div className="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-[#065f46]/10 to-[#059669]/10 rounded-full blur-3xl"></div>
                <div className="relative">
                  <div className="inline-block mb-4 px-4 py-1.5 rounded-full bg-[#065f46]/20 border border-[#065f46]/30">
                    <span className="text-sm font-bold text-[#065f46]">Premium & Ưu Đãi</span>
                  </div>
                  <h2 className="text-3xl md:text-4xl font-extrabold font-serif text-foreground mb-3 text-balance">
                    Khách Hàng Cố Định
                  </h2>
                  <p className="text-base md:text-lg text-muted-foreground text-pretty">
                    Đặt sân cố định với giá ưu đãi chỉ <span className="font-bold text-[#065f46]">120.000đ/giờ</span> và
                    hàng loạt quyền lợi cao cấp
                  </p>
                </div>
              </div>

              <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {fixedBenefits.map((benefit, idx) => (
                  <div
                    key={idx}
                    className={`group relative bg-white rounded-xl border p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 ${
                      benefit.highlight
                        ? "border-[#065f46]/40 hover:border-[#065f46]"
                        : "border-border hover:border-[#065f46]/30"
                    }`}
                  >
                    {benefit.highlight && (
                      <div className="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-gradient-to-br from-[#065f46] to-[#059669] flex items-center justify-center shadow-md">
                        <Award className="w-4 h-4 text-white" />
                      </div>
                    )}
                    <div
                      className={`w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm ${
                        benefit.highlight
                          ? "bg-gradient-to-br from-[#065f46] to-[#059669] text-white"
                          : "bg-muted text-muted-foreground"
                      }`}
                    >
                      {benefit.icon}
                    </div>
                    <h3 className="text-base font-bold text-foreground mb-2">{benefit.title}</h3>
                    <p className="text-sm text-muted-foreground leading-relaxed">{benefit.description}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
