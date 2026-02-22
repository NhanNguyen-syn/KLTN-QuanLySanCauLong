import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { CheckCircle2, Users, Trophy, Target, Heart, Shield } from 'lucide-react'
import Image from "next/image"

export const metadata = {
  title: "Về Chúng Tôi - BadmintonPro",
  description: "Câu chuyện và sứ mệnh của BadmintonPro - Hệ thống sân cầu lông hàng đầu",
}

export default function AboutPage() {
  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        {/* Hero Section */}
        <section className="relative bg-primary text-white py-20 md:py-28 overflow-hidden">
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 right-0 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
            <div className="absolute bottom-0 left-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
          </div>
          
          <div className="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 className="text-4xl md:text-6xl font-extrabold font-serif mb-6">Về Chúng Tôi</h1>
            <p className="text-lg md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
              BadmintonPro không chỉ là nơi cho thuê sân cầu lông. Chúng tôi kiến tạo không gian để đam mê thể thao được thăng hoa, nơi cộng đồng cầu lông gắn kết và phát triển.
            </p>
          </div>
        </section>

        {/* Mission & Vision */}
        <section className="py-20 bg-white">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid md:grid-cols-2 gap-12 items-center">
              <div className="space-y-6">
                <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-bold uppercase tracking-wide">
                  Câu Chuyện Của Chúng Tôi
                </div>
                <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                  Nâng Tầm Trải Nghiệm Cầu Lông Việt
                </h2>
                <p className="text-muted-foreground text-lg leading-relaxed">
                  Được thành lập vào năm 2023, BadmintonPro ra đời với mong muốn giải quyết bài toán thiếu hụt sân chơi chất lượng cao cho cộng đồng yêu cầu lông.
                </p>
                <p className="text-muted-foreground text-lg leading-relaxed">
                  Chúng tôi tin rằng một sân đấu tốt không chỉ cần mặt sàn chuẩn, ánh sáng tốt mà còn cần một hệ thống dịch vụ chuyên nghiệp, tận tâm và tiện lợi. Đó là lý do BadmintonPro đầu tư mạnh mẽ vào cơ sở vật chất và công nghệ quản lý ngay từ những ngày đầu.
                </p>
                
                <div className="grid grid-cols-2 gap-6 pt-4">
                  <div className="bg-muted/30 p-4 rounded-xl border border-border">
                    <div className="text-3xl font-extrabold text-primary mb-1">10+</div>
                    <div className="text-sm text-muted-foreground font-medium">Sân Chuẩn Quốc Tế</div>
                  </div>
                  <div className="bg-muted/30 p-4 rounded-xl border border-border">
                    <div className="text-3xl font-extrabold text-primary mb-1">5000+</div>
                    <div className="text-sm text-muted-foreground font-medium">Thành Viên Tin Cậy</div>
                  </div>
                </div>
              </div>
              
              <div className="relative h-[500px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                {/* Placeholder for About Image */}
                <div className="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 z-10"></div>
                <div className="absolute inset-0 bg-gray-200 flex items-center justify-center">
                   <Users className="w-24 h-24 text-muted-foreground/20" />
                </div>
                {/* In a real project, use <Image /> here */}
              </div>
            </div>
          </div>
        </section>

        {/* Core Values */}
        <section className="py-20 bg-muted/30">
          <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16 space-y-4">
              <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
                Giá Trị Cốt Lõi
              </h2>
              <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                Những nguyên tắc định hình mọi hoạt động và quyết định của chúng tôi
              </p>
            </div>

            <div className="grid md:grid-cols-3 gap-8">
              <div className="bg-white p-8 rounded-2xl shadow-sm border border-border hover:shadow-md transition-all">
                <div className="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-6 text-primary">
                  <Target className="w-7 h-7" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Chất Lượng Hàng Đầu</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Không thỏa hiệp về chất lượng sân bãi và trang thiết bị. Mọi chi tiết đều được chăm chút để đảm bảo trải nghiệm thi đấu tốt nhất.
                </p>
              </div>

              <div className="bg-white p-8 rounded-2xl shadow-sm border border-border hover:shadow-md transition-all">
                <div className="w-14 h-14 rounded-xl bg-secondary/10 flex items-center justify-center mb-6 text-secondary">
                  <Heart className="w-7 h-7" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Tận Tâm Phục Vụ</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Khách hàng là trung tâm. Chúng tôi lắng nghe, thấu hiểu và nỗ lực vượt qua sự mong đợi của người chơi mỗi ngày.
                </p>
              </div>

              <div className="bg-white p-8 rounded-2xl shadow-sm border border-border hover:shadow-md transition-all">
                <div className="w-14 h-14 rounded-xl bg-accent/10 flex items-center justify-center mb-6 text-accent">
                  <Shield className="w-7 h-7" />
                </div>
                <h3 className="text-xl font-bold text-foreground mb-3">Minh Bạch & Uy Tín</h3>
                <p className="text-muted-foreground leading-relaxed">
                  Rõ ràng trong giá cả, chính sách và quy trình. Xây dựng niềm tin bền vững với cộng đồng người chơi.
                </p>
              </div>
            </div>
          </div>
        </section>

        {/* Team CTA */}
        <section className="py-20 bg-white">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <h2 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">
              Gia Nhập Cộng Đồng BadmintonPro
            </h2>
            <p className="text-lg text-muted-foreground">
              Dù bạn là người mới bắt đầu hay vận động viên chuyên nghiệp, chúng tôi luôn có chỗ dành cho bạn.
            </p>
            <div className="flex justify-center gap-4">
               <a href="/lien-he" className="inline-flex items-center justify-center bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-primary/90 transition-all">
                 Liên Hệ Hợp Tác
               </a>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
