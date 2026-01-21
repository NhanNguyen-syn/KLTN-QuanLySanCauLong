import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import Link from "next/link"
import { Clock, Star, Shield, CheckCircle2, ArrowRight } from 'lucide-react'

export const metadata = {
  title: "Sân Cầu Lông & Bảng Giá - BadmintonPro",
  description: "10 sân cầu lông chất lượng quốc tế với giá chuẩn. Khách vãng lai 150K/giờ, khách thường 120K/giờ",
}

export default function CourtsAndPricing() {
  const courts = [
    { id: 1, name: "Sân 1", status: "available" },
    { id: 2, name: "Sân 2", status: "available" },
    { id: 3, name: "Sân 3", status: "available" },
    { id: 4, name: "Sân 4", status: "available" },
    { id: 5, name: "Sân 5", status: "available" },
    { id: 6, name: "Sân 6", status: "available" },
    { id: 7, name: "Sân 7", status: "available" },
    { id: 8, name: "Sân 8", status: "available" },
  ]

  const pricingPlans = [
    {
      type: "Khách Vãng Lai",
      duration: "Theo giờ",
      price: "150.000",
      description: "Đặt sân linh hoạt, phù hợp chơi thỉnh thoảng",
      features: [
        "Sân gỗ tiêu chuẩn quốc tế",
        "Chiếu sáng LED chuyên nghiệp",
        "Điều hòa không khí",
        "Phòng thay đồ tiện nghi",
      ],
      bgColor: "bg-gradient-to-br from-[#059669] via-[#14b8a6] to-[#2dd4bf]",
      popular: false,
    },
    {
      type: "Khách Cố Định",
      duration: "Thành viên",
      price: "120.000",
      description: "Tiết kiệm 20%, ưu đãi đặc biệt và dịch vụ VIP",
      features: [
        "Tất cả quyền lợi khách vãng lai",
        "Ưu tiên đặt sân giờ đẹp",
        "Nước uống & ăn nhẹ miễn phí",
        "Hỗ trợ huấn luyện cá nhân",
      ],
      bgColor: "bg-gradient-to-br from-[#065f46] via-[#047857] to-[#059669]",
      popular: true,
    },
  ]

  const facilities = [
    {
      icon: Star,
      title: "Sân Chuẩn Quốc Tế",
      description: "Sàn gỗ cao cấp, tiêu chuẩn BWF",
    },
    {
      icon: Clock,
      title: "Giờ Hoạt Động Linh Hoạt",
      description: "Mở cửa từ 5:00 - 23:00 hàng ngày",
    },
    {
      icon: Shield,
      title: "Bảo Hiểm & An Toàn",
      description: "Camera giám sát 24/7, bảo hiểm người chơi",
    },
  ]

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        {/* Hero Section */}
        <section className="relative text-white overflow-hidden pt-16 pb-20 md:pt-20 md:pb-24">
          {/* Background Image */}
          <div 
            className="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style={{
              backgroundImage: "url('/modern-badminton-court-interior-professional-light.jpg')",
            }}
          />
          
          {/* Decorative elements */}
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div className="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
          </div>

          <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div className="max-w-3xl mx-auto space-y-6">
              <h1 className="text-4xl md:text-5xl font-extrabold leading-tight font-serif">
                10 Sân Cầu Lông
                <br />
                <span className="text-white/90">Chất Lượng Quốc Tế</span>
              </h1>
              <p className="text-lg md:text-xl text-white/90 leading-relaxed">
                Giá chuẩn, minh bạch. Khách vãng lai 150.000đ/giờ, khách cố định 120.000đ/giờ
              </p>
              <Link
                href="/chon-goi"
                className="inline-flex items-center justify-center bg-white text-primary px-8 py-3.5 rounded-lg font-bold text-base hover:bg-white/95 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
              >
                Đặt Sân Ngay
              </Link>
            </div>
          </div>
        </section>

        {/* Pricing Plans */}
        <section className="py-16 md:py-20 bg-gradient-to-b from-muted/30 to-background">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12 space-y-3">
              <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">Bảng Giá Chi Tiết</h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Lựa chọn gói phù hợp với nhu cầu chơi cầu lông của bạn
              </p>
            </div>

            <div className="grid md:grid-cols-2 gap-6 max-w-5xl mx-auto">
              {/* Khách Vãng Lai Card */}
              <div className="relative rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-[1.02] bg-white">
                {/* Card Header with light gradient */}
                <div className="bg-gradient-to-br from-[#059669] via-[#14b8a6] to-[#2dd4bf] p-8 text-white relative overflow-hidden">
                  <div className="relative z-10">
                    <h3 className="text-2xl md:text-3xl font-extrabold mb-2">Khách Vãng Lai</h3>
                    <div className="inline-block bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold mb-4">
                      Theo giờ
                    </div>

                    <div className="flex items-baseline gap-1 mb-3">
                      <span className="text-5xl md:text-6xl font-extrabold tracking-tight">150</span>
                      <span className="text-xl font-bold">.000đ</span>
                      <span className="text-base font-medium text-white/90 ml-1">/giờ</span>
                    </div>

                    <p className="text-white/95 text-sm leading-relaxed">
                      Đặt sân linh hoạt, phù hợp chơi thỉnh thoảng
                    </p>
                  </div>
                </div>

                {/* Card Body - White background */}
                <div className="bg-white p-8 space-y-5">
                  <div className="space-y-3">
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Sân gỗ tiêu chuẩn quốc tế</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Chiếu sáng LED chuyên nghiệp</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Điều hòa không khí</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Phòng thay đồ tiện nghi</span>
                    </div>
                  </div>

                  <Link
                    href="/chon-goi"
                    className="group flex items-center justify-center gap-2 w-full bg-white text-foreground border-2 border-border hover:border-[#059669] py-3 rounded-xl font-bold text-base transition-all duration-300 hover:shadow-md mt-6"
                  >
                    Bắt Đầu Ngay
                    <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                  </Link>
                </div>
              </div>

              {/* Khách Cố Định Card */}
              <div className="relative rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 hover:scale-[1.02] md:scale-105 bg-gradient-to-br from-[#065f46] via-[#047857] to-[#059669]">
                <div className="absolute top-5 right-5 bg-black text-white text-xs font-bold px-3 py-1.5 rounded-full z-10 shadow-lg">
                  PHỔ BIẾN NHẤT
                </div>

                {/* Card Header with dark gradient */}
                <div className="p-8 text-white relative overflow-hidden">
                  {/* Decorative shuttlecock */}
                  <div className="absolute -right-6 -bottom-6 opacity-15 rotate-12">
                    <svg width="160" height="160" viewBox="0 0 200 200" fill="none">
                      <circle cx="100" cy="40" r="15" fill="white" />
                      <path d="M85 50 L100 40 L115 50 L110 120 L90 120 Z" fill="white" opacity="0.8" />
                      <path d="M90 120 L85 180 L100 170 L115 180 L110 120 Z" fill="white" opacity="0.6" />
                    </svg>
                  </div>

                  <div className="relative z-10">
                    <h3 className="text-2xl md:text-3xl font-extrabold mb-2">Khách Cố Định</h3>
                    <div className="inline-block bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold mb-4">
                      Thành viên
                    </div>

                    <div className="flex items-baseline gap-1 mb-3">
                      <span className="text-5xl md:text-6xl font-extrabold tracking-tight">120</span>
                      <span className="text-xl font-bold">.000đ</span>
                      <span className="text-base font-medium text-white/90 ml-1">/giờ</span>
                    </div>

                    <p className="text-white/95 text-sm leading-relaxed">
                      Tiết kiệm 20%, ưu đãi đặc biệt và dịch vụ VIP
                    </p>
                  </div>
                </div>

                {/* Card Body with white section at bottom */}
                <div className="bg-white p-8 space-y-5">
                  <div className="space-y-3">
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Tất cả quyền lợi khách vãng lai</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Ưu tiên đặt sân giờ đẹp</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Nước uống & ăn nhẹ miễn phí</span>
                    </div>
                    <div className="flex items-start gap-2.5">
                      <CheckCircle2 className="w-5 h-5 text-[#059669] flex-shrink-0 mt-0.5" />
                      <span className="text-foreground text-sm leading-relaxed">Hỗ trợ huấn luyện cá nhân</span>
                    </div>
                  </div>

                  <Link
                    href="/chon-goi"
                    className="group flex items-center justify-center gap-2 w-full bg-white text-foreground border-2 border-border hover:border-[#059669] py-3 rounded-xl font-bold text-base transition-all duration-300 hover:shadow-md mt-6"
                  >
                    Bắt Đầu Ngay
                    <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                  </Link>
                </div>
              </div>
            </div>

            <div className="text-center mt-10">
              
            </div>
          </div>
        </section>

        {/* Courts Grid */}
        <section className="py-16 md:py-20 bg-muted/30">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12 space-y-3">
              <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">Khám phá &amp; Đặt sân cầu lông    </h2>
              <p className="text-muted-foreground">Khám phá sân golf lý tưởng, phù hợp lịch trình và sở thích của bạn. Mỗi sân đều đạt chuẩn chuyên nghiệp để bạn tận hưởng trọn vẹn.</p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
              {courts.map((court, index) => (
                <div
                  key={court.id}
                  className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-border/50"
                >
                  {/* Image Container */}
                  <div className="relative h-64 overflow-hidden">
                    <div
                      className="absolute inset-0 bg-cover bg-center transform group-hover:scale-110 transition-transform duration-700"
                      style={{
                        backgroundImage: `url('/modern-badminton-court-interior-professional-light.jpg')`,
                      }}
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60" />
                    
                    {/* Time Slots Tags */}
                    <div className="absolute bottom-4 left-4 flex flex-wrap gap-2">
                      <span className="bg-white/90 backdrop-blur-sm text-xs font-bold px-2.5 py-1 rounded-md text-foreground shadow-sm">
                        08:00 - 09:00
                      </span>
                      <span className="bg-white/90 backdrop-blur-sm text-xs font-bold px-2.5 py-1 rounded-md text-foreground shadow-sm">
                        12:00 - 13:00
                      </span>
                    </div>
                  </div>

                  {/* Content */}
                  <div className="p-6 space-y-4">
                    <div>
                      <h3 className="text-xl font-bold text-foreground mb-1 group-hover:text-[#059669] transition-colors">
                        {court.name}
                      </h3>
                      <p className="text-sm text-muted-foreground">
                        123 Đường Badminton, Quận Cầu Giấy, Hà Nội
                      </p>
                    </div>

                    <div className="pt-4 border-t border-border flex items-center justify-between">
                      <div className="flex flex-col">
                        <span className="text-xs text-muted-foreground font-medium">Giá bắt đầu từ</span>
                        <span className="text-lg font-bold text-foreground">
                          150.000đ<span className="text-sm font-normal text-muted-foreground">/giờ</span>
                        </span>
                      </div>
                      
                      <Link 
                        href="/chon-goi"
                        className="w-10 h-10 rounded-full bg-[#059669]/10 flex items-center justify-center text-[#059669] group-hover:bg-[#059669] group-hover:text-white transition-all duration-300"
                      >
                        <ArrowRight className="w-5 h-5" />
                      </Link>
                    </div>
                  </div>
                </div>
              ))}
            </div>

            <div className="text-center mt-12">
              <Link
                href="/chon-goi"
                className="inline-flex items-center justify-center bg-[#065f46] text-white px-8 py-3.5 rounded-lg font-bold hover:bg-[#065f46]/90 transition-all shadow-lg hover:shadow-xl hover:scale-105"
              >
                Xem Tất Cả Sân
              </Link>
            </div>
          </div>
        </section>

        {/* Facilities */}
        

        {/* CTA Section */}
        
      </main>

      <Footer />
    </div>
  )
}
