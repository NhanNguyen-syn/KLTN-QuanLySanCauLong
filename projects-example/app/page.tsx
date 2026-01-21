import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import Link from "next/link"
import { CheckCircle2, ArrowRight, Star, Shield, Zap, Users } from 'lucide-react'

export const metadata = {
  title: "BadmintonPro - Đặt Sân Cầu Lông Chuyên Nghiệp",
  description: "Hệ thống quản lý sân cầu lông chuyên nghiệp với 10 sân chuẩn quốc tế",
}

const courts = [
  {
    id: 1,
    name: "Sân 1-3",
    price: "150.000",
    period: "giờ",
    tag: "Khách Vãng Lai",
    features: ["Sân gỗ chuẩn", "Chiếu sáng LED", "Điều hòa"],
  },
  {
    id: 2,
    name: "Sân 4-7",
    price: "150.000",
    period: "giờ",
    tag: "Khách Vãng Lai",
    features: ["Sân gỗ chuẩn", "Chiếu sáng LED", "Khu vực chờ"],
  },
  {
    id: 3,
    name: "Sân 8-10",
    price: "150.000",
    period: "giờ",
    tag: "Khách Vãng Lai",
    features: ["Sân gỗ chuẩn", "Chiếu sáng LED", "Phòng thay đồ"],
  },
]

const features = [
  {
    title: "Đặt Sân Thông Minh",
    description: "Online hiện đại, thanh toán linh hoạt, xác nhận tức thì",
  },
  {
    title: "Sân Chuẩn Quốc Tế",
    description: "Sân cầu lông chuẩn BWF, sàn gỗ cao cấp, ánh sáng chuyên nghiệp",
  },
  {
    title: "Dịch Vụ Cao Cấp",
    description: "Phòng thay đồ sang trọng, nước miễn phí, WiFi tốc độ cao",
  },
  {
    title: "HLV Chuyên Nghiệp",
    description: "Đội HLV giàu kinh nghiệm, chương trình tập toàn diện",
  },
  {
    title: "Giá Chuẩn Rõ Ràng",
    description: "Bảng giá minh bạch, gói ưu đãi cho khách hàng thường",
  },
  {
    title: "An Ninh 24/7",
    description: "Camera giám sát toàn bộ, nhân viên hỗ trợ không ngừng",
  },
]

const stats = [
  { value: "5000+", label: "Khách Hàng Tin Tưởng" },
  { value: "10", label: "Sân Chuẩn Quốc Tế" },
  { value: "100%", label: "Hài Lòng Về Dịch Vụ" },
  { value: "4.9/5", label: "Đánh Giá Trung Bình" },
]

const testimonials = [
  {
    name: "Nguyễn Văn A",
    role: "Vận Động Viên",
    content: "Sân đẹp, dịch vụ tuyệt vời. Hệ thống đặt sân rất tiện lợi!",
  },
  {
    name: "Trần Thị B",
    role: "Giáo Viên Thể Dục",
    content: "Tôi đã sử dụng 2 năm. Chất lượng luôn được duy trì tốt.",
  },
  {
    name: "Lê Minh C",
    role: "Sinh Viên",
    content: "Giá cạnh tranh, gói ưu đãi rất hấp dẫn. Tuyệt vời!",
  },
  {
    name: "Phạm Thu D",
    role: "Vận Động Viên",
    content: "Sân sạch, ánh sáng tốt và nhân viên rất nhiệt tình. Dịch vụ đánh giá cao. Rất khuyến nghị!",
  },
  {
    name: "Hoàng Minh E",
    role: "Vận Động Viên",
    content:
      "Tôi luôn đặt sân vào khung giờ 7 giờ tối tại đây — không khí tuyệt vời, đám đông dễ chịu, dễ dàng tìm được chỗ vào lúc 7 giờ tối.",
  },
  {
    name: "Vũ Thị F",
    role: "Vận Động Viên",
    content: "Sân sạch, phòng thay đồ có sẵn và tôi luôn có thể tìm thấy chỗ vào lúc 7 giờ tối. Tuyệt vời!",
  },
]

export default function Home() {
  return (
    <div className="min-h-screen flex flex-col">
      <Navigation />

      <main className="flex-1">
        {/* Hero Section */}
        <section className="relative bg-gradient-to-br from-primary via-primary/95 to-primary/90 text-white overflow-hidden pt-16 pb-20 md:pt-24 md:pb-32">
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 right-0 w-[500px] h-[500px] bg-accent rounded-full blur-3xl animate-pulse-slow"></div>
            <div className="absolute bottom-0 left-0 w-[500px] h-[500px] bg-secondary rounded-full blur-3xl animate-pulse-slow" style={{ animationDelay: "1s" }}></div>
          </div>

          <div className="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="max-w-4xl mx-auto text-center space-y-8 animate-slideInUp">
              <div className="space-y-4">
                <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm font-medium text-white/90 mb-4">
                  <Star className="w-4 h-4 text-yellow-400 fill-yellow-400" />
                  <span>Hệ thống sân cầu lông số 1 tại khu vực</span>
                </div>
                <h1 className="text-4xl md:text-6xl lg:text-7xl font-extrabold leading-tight text-balance font-serif tracking-tight">
                  Nâng Tầm Đam Mê <br />
                  <span className="text-transparent bg-clip-text bg-gradient-to-r from-white via-white to-white/80">Cầu Lông Của Bạn</span>
                </h1>
                <p className="text-lg md:text-xl text-white/80 max-w-2xl mx-auto leading-relaxed font-medium">
                  Trải nghiệm sân đấu chuẩn quốc tế với mức giá hợp lý. 
                  Phù hợp cho cả người chơi vãng lai và thành viên cố định.
                </p>
              </div>

              <div className="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                <Link
                  href="/chon-goi"
                  className="group inline-flex items-center justify-center bg-white text-primary px-8 py-4 rounded-full font-bold text-lg hover:bg-secondary hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1"
                >
                  Đặt Sân Ngay
                  <ArrowRight className="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" />
                </Link>
                <Link
                  href="/goi-thanh-vien"
                  className="inline-flex items-center justify-center px-8 py-4 rounded-full font-bold text-lg border-2 border-white/30 text-white hover:bg-white/10 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1"
                >
                  Xem Gói Thành Viên
                </Link>
              </div>

              <div className="grid grid-cols-2 md:grid-cols-4 gap-8 pt-12 border-t border-white/10 mt-12">
                {stats.map((stat, idx) => (
                  <div key={idx} className="text-center group hover:scale-105 transition-transform duration-300">
                    <div className="text-3xl md:text-4xl font-extrabold text-white mb-1">{stat.value}</div>
                    <div className="text-sm text-white/60 font-medium uppercase tracking-wider">{stat.label}</div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </section>

        {/* Customer Types Selection */}
        <section className="py-20 bg-background relative z-10 -mt-10">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid md:grid-cols-2 gap-8">
              {/* Walk-in Customer Card */}
              <div className="group bg-white rounded-2xl p-8 shadow-lg border border-border hover:border-primary/50 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                <div className="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div className="relative">
                  <div className="w-14 h-14 rounded-xl bg-secondary/10 flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:text-white transition-colors">
                    <Zap className="w-7 h-7 text-secondary group-hover:text-white" />
                  </div>
                  <h3 className="text-2xl font-bold text-foreground mb-3">Khách Vãng Lai</h3>
                  <p className="text-muted-foreground mb-6 leading-relaxed">
                    Linh hoạt đặt sân theo giờ, không cần cam kết dài hạn. Phù hợp cho những trận đấu ngẫu hứng hoặc người mới chơi.
                  </p>
                  <ul className="space-y-3 mb-8">
                    <li className="flex items-center gap-3 text-sm font-medium text-foreground/80">
                      <CheckCircle2 className="w-5 h-5 text-secondary flex-shrink-0" />
                      Đặt sân nhanh chóng trong 30 giây
                    </li>
                    <li className="flex items-center gap-3 text-sm font-medium text-foreground/80">
                      <CheckCircle2 className="w-5 h-5 text-secondary flex-shrink-0" />
                      Giá chỉ 150.000đ/giờ
                    </li>
                    <li className="flex items-center gap-3 text-sm font-medium text-foreground/80">
                      <CheckCircle2 className="w-5 h-5 text-secondary flex-shrink-0" />
                      Thanh toán linh hoạt
                    </li>
                  </ul>
                  <Link href="/chon-goi" className="inline-flex items-center font-bold text-secondary hover:text-primary transition-colors">
                    Đặt Ngay <ArrowRight className="w-4 h-4 ml-2" />
                  </Link>
                </div>
              </div>

              {/* Fixed Customer Card */}
              <div className="group bg-primary rounded-2xl p-8 shadow-lg border border-primary hover:shadow-xl transition-all duration-300 relative overflow-hidden text-white">
                <div className="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div className="relative">
                  <div className="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center mb-6 backdrop-blur-sm">
                    <Users className="w-7 h-7 text-white" />
                  </div>
                  <h3 className="text-2xl font-bold mb-3">Khách Cố Định</h3>
                  <p className="text-white/80 mb-6 leading-relaxed">
                    Đăng ký lịch cố định hàng tháng, nhận ưu đãi đặc biệt và đảm bảo luôn có sân vào khung giờ yêu thích.
                  </p>
                  <ul className="space-y-3 mb-8">
                    <li className="flex items-center gap-3 text-sm font-medium text-white/90">
                      <CheckCircle2 className="w-5 h-5 text-accent flex-shrink-0" />
                      Tiết kiệm 20% chi phí (120.000đ/giờ)
                    </li>
                    <li className="flex items-center gap-3 text-sm font-medium text-white/90">
                      <CheckCircle2 className="w-5 h-5 text-accent flex-shrink-0" />
                      Ưu tiên giữ sân giờ vàng
                    </li>
                    <li className="flex items-center gap-3 text-sm font-medium text-white/90">
                      <CheckCircle2 className="w-5 h-5 text-accent flex-shrink-0" />
                      Nước uống & tiện ích miễn phí
                    </li>
                  </ul>
                  <Link href="/goi-thanh-vien" className="inline-flex items-center justify-center w-full bg-white text-primary py-3 rounded-lg font-bold hover:bg-accent hover:text-white transition-all">
                    Đăng Ký Thành Viên
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* Featured Courts */}
        <section className="py-20 bg-muted/30">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12 space-y-4">
              <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                Hệ Thống Sân Đẳng Cấp
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                10 sân cầu lông tiêu chuẩn quốc tế với sàn gỗ cao cấp, hệ thống chiếu sáng chống lóa và không gian thoáng mát.
              </p>
            </div>

            <div className="grid md:grid-cols-3 gap-8 mb-10">
              {courts.map((court) => (
                <div
                  key={court.id}
                  className="group bg-white rounded-2xl overflow-hidden shadow-sm border border-border hover:shadow-xl hover:border-primary/30 transition-all duration-500 hover:-translate-y-2"
                >
                  <div className="relative h-48 bg-gray-200 overflow-hidden">
                    {/* Placeholder for court image - using gradient for now */}
                    <div className="absolute inset-0 bg-gradient-to-br from-primary/80 to-secondary/80 group-hover:scale-110 transition-transform duration-700"></div>
                    <div className="absolute inset-0 flex items-center justify-center">
                       <Shield className="w-12 h-12 text-white/30" />
                    </div>
                    <div className="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                      <h3 className="text-xl font-bold text-white">{court.name}</h3>
                      <span className="bg-white/20 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-medium border border-white/30">
                        Sẵn sàng
                      </span>
                    </div>
                  </div>

                  <div className="p-6 space-y-6">
                    <div className="flex items-baseline gap-1 text-primary">
                      <span className="text-3xl font-extrabold">{court.price}</span>
                      <span className="text-sm font-medium text-muted-foreground">đ/{court.period}</span>
                    </div>

                    <div className="space-y-3">
                      {court.features.map((feature, idx) => (
                        <div key={idx} className="flex items-center gap-3">
                          <div className="w-1.5 h-1.5 rounded-full bg-secondary flex-shrink-0"></div>
                          <span className="text-sm text-foreground/80 font-medium">{feature}</span>
                        </div>
                      ))}
                    </div>

                    <Link
                      href="/chon-goi"
                      className="block w-full bg-muted text-foreground py-3 rounded-xl font-bold text-center hover:bg-primary hover:text-white transition-all duration-300"
                    >
                      Đặt Sân Này
                    </Link>
                  </div>
                </div>
              ))}
            </div>

            <div className="text-center">
              <Link
                href="/san-va-gia"
                className="inline-flex items-center gap-2 text-primary font-bold text-lg hover:text-secondary transition-all group"
              >
                Xem Chi Tiết Tất Cả Sân 
                <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
              </Link>
            </div>
          </div>
        </section>

        {/* Why Choose Us */}
        <section className="py-20 bg-white">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16 space-y-4">
              <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                Tại Sao Chọn BadmintonPro?
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Chúng tôi không chỉ cung cấp sân chơi, mà còn mang đến trải nghiệm thể thao trọn vẹn nhất.
              </p>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {features.map((feature, idx) => (
                <div
                  key={idx}
                  className="group bg-background rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-lg transition-all duration-300"
                >
                  <div className="w-12 h-12 rounded-lg bg-primary/5 flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                    <CheckCircle2 className="w-6 h-6 text-primary group-hover:text-white transition-colors" />
                  </div>
                  <h3 className="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-colors">{feature.title}</h3>
                  <p className="text-muted-foreground leading-relaxed">{feature.description}</p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Testimonials */}
        <section className="py-20 bg-muted/30">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16 space-y-4">
              <div className="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-2">
                Testimonials
              </div>
              <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                Khách Hàng Nói Gì Về Chúng Tôi
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Hơn 5000+ khách hàng đã tin tưởng và lựa chọn BadmintonPro cho niềm đam mê của mình.
              </p>
            </div>

            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {testimonials.map((testimonial, idx) => (
                <div key={idx} className="bg-white rounded-2xl p-8 border border-border shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full">
                  <div className="mb-6">
                    <svg className="w-10 h-10 text-primary/20" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z" />
                    </svg>
                  </div>
                  <p className="text-muted-foreground mb-6 leading-relaxed flex-1 italic">
                    "{testimonial.content}"
                  </p>
                  <div className="flex items-center gap-4 pt-6 border-t border-border">
                    <div className={`w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg bg-gradient-to-br ${idx % 2 === 0 ? 'from-primary to-secondary' : 'from-secondary to-accent'}`}>
                      {testimonial.name.charAt(0)}
                    </div>
                    <div>
                      <div className="font-bold text-foreground">{testimonial.name}</div>
                      <div className="text-xs text-muted-foreground font-medium uppercase tracking-wide">{testimonial.role}</div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* CTA */}
        <section className="py-24 bg-primary text-white relative overflow-hidden">
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-1/2 left-1/4 w-[600px] h-[600px] bg-secondary rounded-full blur-3xl animate-pulse-slow"></div>
            <div className="absolute bottom-0 right-0 w-[400px] h-[400px] bg-accent rounded-full blur-3xl animate-pulse-slow" style={{ animationDelay: "1.5s" }}></div>
          </div>

          <div className="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <div className="space-y-4">
              <h2 className="text-4xl md:text-5xl font-extrabold font-serif leading-tight">Sẵn Sàng Ra Sân?</h2>
              <p className="text-xl text-white/90 max-w-2xl mx-auto font-medium">
                Đừng để niềm đam mê chờ đợi. Đặt sân ngay hôm nay chỉ với vài thao tác đơn giản!
              </p>
            </div>

            <div className="flex flex-col sm:flex-row gap-4 justify-center pt-4">
              <Link
                href="/chon-goi"
                className="inline-flex items-center justify-center bg-white text-primary px-10 py-4 rounded-full font-bold text-lg hover:bg-secondary hover:text-white transition-all duration-300 shadow-xl hover:scale-105"
              >
                Đặt Sân Ngay
              </Link>
              <Link
                href="/lien-he"
                className="inline-flex items-center justify-center border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primary transition-all duration-300"
              >
                Liên Hệ Hỗ Trợ
              </Link>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
