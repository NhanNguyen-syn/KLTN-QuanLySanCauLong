"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState } from "react"
import { Calendar, Clock, User, ArrowRight } from "lucide-react"

export default function News() {
  const [selectedCategory, setSelectedCategory] = useState("all")
  const [selectedArticle, setSelectedArticle] = useState(null)

  const articles = [
    {
      id: 1,
      title: "Giải Cầu Lông Quốc Gia 2024 - Chung Kết Hôm Nay",
      category: "tournament",
      date: "20/11/2024",
      image: "/badminton-tournament-final.jpg",
      excerpt: "Chung kết giải cầu lông quốc gia 2024 sẽ diễn ra hôm nay với sự tham gia của các đội mạnh nhất...",
      author: "Trần Thị B",
      readTime: "5 phút",
      content: `Giải cầu lông quốc gia 2024 sẽ đạt đến điểm cao nhất khi chung kết diễn ra hôm nay. Hai đội mạnh nhất của giải đầu này sẽ so tài trong một trận đấu căng thẳng và đầy kịch tính.

Giải đấu năm nay ghi dấu ấn với sự xuất hiện của các vận động viên tài năng từ khắp các vùng miền. Hơn 100 vận động viên đã tham gia các vòng đấu loại trước để có mặt ở trận chung kết này.

Các khán giả có thể tìm hiểu thêm về các luật thi đấu, cách tính điểm, và những kỳ vọng từ các đội tuyển. Đây là cơ hội tuyệt vời để thưởng thức tài năng cầu lông đẳng cấp cao của Việt Nam.`,
      location: "Sân Cầu Lông Center",
    },
    {
      id: 2,
      title: "Giải Cầu Lông Thành Phố 2024 - Đăng Ký Ngay",
      category: "tournament",
      date: "15/11/2024",
      image: "/badminton-city-tournament-registration.jpg",
      excerpt: "Đăng ký tham gia giải cầu lông thành phố 2024. Hạn cuối đăng ký: 30/11/2024...",
      author: "Nguyễn Văn A",
      readTime: "4 phút",
      content: `Giải cầu lông thành phố 2024 đang mở đơn đăng ký cho tất cả các vận động viên. Đây là giải đấu năm một sự kiện thể thao lớn của thành phố với nhiều phần thưởng hấp dẫn.

Thông tin đăng ký:
- Hạn cuối đăng ký: 30/11/2024
- Phí tham gia: 200.000đ/người
- Các bảng thi đấu: Nam đơn, Nữ đơn, Nam đôi, Nữ đôi, Hỗn hợp
- Địa điểm: Sân Cầu Lông Center

Các vận động viên cần chuẩn bị kỹ lưỡng, tuân thủ luật thi đấu, và đảm bảo sức khỏe tốt để có thể thi đấu hết mình.`,
      location: "Sân Cầu Lông Center",
    },
    {
      id: 3,
      title: "Lịch Sử Phát Triển Cầu Lông Tại Việt Nam",
      category: "news",
      date: "14/11/2024",
      image: "/badminton-history-vietnam.jpg",
      excerpt: "Khám phá hành trình phát triển của môn cầu lông từ xưa đến nay tại Việt Nam...",
      author: "Nguyễn Văn A",
      readTime: "8 phút",
      content: `Cầu lông là một trong những môn thể thao yêu thích nhất tại Việt Nam. Lịch sử phát triển của môn này tại đất nước ta đã trải qua nhiều giai đoạn phát triển đáng kể.

Từ những năm 1950s, cầu lông được giới thiệu và dần phổ biến tại các trường học, quân đội, và các câu lạc bộ thể thao. Môn thể thao này mang đến không chỉ sức khỏe mà còn giá trị tinh thần cao.

Trong những thập kỷ gần đây, cầu lông Việt Nam đã có những bước tiến vượt bậc, với nhiều vận động viên xuất sắc đạt thành tích cao trên đấu trường quốc tế. Các giải đấu cầu lông cấp quốc gia, khu vực, và quốc tế tại Việt Nam được tổ chức thường xuyên, tạo cơ hội cho các vận động viên phát triển kỹ năng và kinh nghiệm.`,
    },
    {
      id: 4,
      title: "5 Kỹ Thuật Cầu Lông Cơ Bản Cho Người Mới",
      category: "news",
      date: "13/11/2024",
      image: "/badminton-basics-techniques.jpg",
      excerpt: "Hướng dẫn chi tiết 5 kỹ thuật nền tảng để bắt đầu hành trình cầu lông...",
      author: "Lê Minh C",
      readTime: "6 phút",
      content: `Nếu bạn là người mới bắt đầu chơi cầu lông, hãy tập trung vào 5 kỹ thuật cơ bản này:

1. Cách cầm vợt: Cầm vợt đúng cách là nền tảng của mọi kỹ thuật. Cầm lỏng tại cán vợt để dễ điều khiển.

2. Tư thế đứng: Đứng cân bằng, chân mở rộng bằng vai, sẵn sàng di chuyển theo mọi hướng.

3. Cú phát bóng: Bắt đầu với phát bóng thấp. Ném bóng nhẹ, gõ bóng bằng tay cầm vợt ở phía dưới eo.

4. Cú clear: Đây là cú đánh cơ bản, dùng để đẩy bóng ra phía sau của sân đối phương.

5. Cú drop shot: Cú đánh nhẹ, khiến bóng rơi gần lưới. Đây là cách tốt để tạo nên sự không ngờ.

Luyện tập các kỹ thuật này một cách kiên trì sẽ giúp bạn phát triển nền tảng vững chắc cho hành trình chơi cầu lông.`,
    },
  ]

  const categories = [
    { id: "all", label: "Tất Cả" },
    { id: "tournament", label: "Giải Đấu" },
    { id: "news", label: "Tin Tức" },
  ]

  const filteredArticles =
    selectedCategory === "all" ? articles : articles.filter((a) => a.category === selectedCategory)

  if (selectedArticle) {
    const article = articles.find((a) => a.id === selectedArticle)
    return (
      <div className="min-h-screen flex flex-col">
        <Navigation />
        <main className="flex-1">
          <section className="relative bg-gradient-to-br from-[#065f46] via-[#059669] to-[#14b8a6] text-primary-foreground py-16 md:py-20 overflow-hidden">
            <div className="absolute inset-0 opacity-10">
              <div className="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -mr-48 -mt-48"></div>
            </div>

            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <button
                onClick={() => setSelectedArticle(null)}
                className="mb-6 inline-flex items-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/30 rounded-xl transition-all text-white font-bold backdrop-blur-sm"
              >
                ← Quay Lại
              </button>
              <h1 className="text-4xl md:text-5xl font-bold mb-4 text-balance">{article.title}</h1>
              <div className="flex flex-wrap items-center gap-4 text-primary-foreground/90">
                <span className="flex items-center gap-2">
                  <User className="w-4 h-4" />
                  {article.author}
                </span>
                <span className="flex items-center gap-2">
                  <Calendar className="w-4 h-4" />
                  {article.date}
                </span>
                <span className="flex items-center gap-2">
                  <Clock className="w-4 h-4" />
                  {article.readTime}
                </span>
              </div>
            </div>
          </section>

          <section className="py-16 md:py-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <img
              src={article.image || "/placeholder.svg"}
              alt={article.title}
              className="w-full h-96 object-cover rounded-2xl mb-12 shadow-2xl"
            />
            <div className="prose prose-lg max-w-none">
              {article.content.split("\n\n").map((paragraph, idx) => (
                <p key={idx} className="text-lg text-muted-foreground leading-relaxed mb-6">
                  {paragraph}
                </p>
              ))}
            </div>
          </section>
        </main>
        <Footer />
      </div>
    )
  }

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        <section className="relative bg-gradient-to-br from-[#065f46] via-[#059669] to-[#14b8a6] text-primary-foreground py-16 md:py-20 overflow-hidden">
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -mr-48 -mt-48"></div>
            <div className="absolute bottom-0 left-0 w-80 h-80 bg-white rounded-full -ml-40 -mb-40"></div>
          </div>

          <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 className="text-4xl md:text-5xl font-bold mb-4 text-balance">Tin Tức & Giải Đấu</h1>
            <p className="text-lg text-primary-foreground/90 max-w-2xl mx-auto text-pretty">
              Cập nhật tin tức, giải đấu cầu lông được tổ chức, và những bài viết thể thao hấp dẫn từ cộng đồng cầu lông
            </p>
          </div>
        </section>

        <section className="py-16 md:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex flex-wrap gap-3 mb-12 justify-center">
            {categories.map((cat) => (
              <button
                key={cat.id}
                onClick={() => setSelectedCategory(cat.id)}
                className={`px-8 py-3 rounded-xl font-bold transition-all ${
                  selectedCategory === cat.id
                    ? "bg-gradient-to-r from-[#065f46] to-[#059669] text-white shadow-lg scale-105"
                    : "bg-white text-foreground border-2 border-border hover:border-[#065f46] hover:shadow-md"
                }`}
              >
                {cat.label}
              </button>
            ))}
          </div>

          <div className="grid md:grid-cols-2 gap-8">
            {filteredArticles.map((article) => (
              <article
                key={article.id}
                onClick={() => setSelectedArticle(article.id)}
                className="bg-white rounded-2xl overflow-hidden border-2 border-border hover:shadow-2xl hover:border-[#065f46] transition-all cursor-pointer group"
              >
                <div className="relative overflow-hidden">
                  <img
                    src={article.image || "/placeholder.svg"}
                    alt={article.title}
                    className="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300"
                  />
                  <div className="absolute top-4 right-4">
                    <span className="inline-block px-4 py-2 bg-white/95 backdrop-blur-sm text-[#065f46] rounded-xl text-sm font-bold shadow-lg">
                      {categories.find((c) => c.id === article.category)?.label}
                    </span>
                  </div>
                </div>
                <div className="p-6">
                  <h3 className="text-2xl font-bold text-foreground mb-3 line-clamp-2 group-hover:text-[#065f46] transition-colors">
                    {article.title}
                  </h3>
                  <p className="text-muted-foreground mb-4 line-clamp-2 leading-relaxed">{article.excerpt}</p>
                  <div className="flex justify-between items-center pt-4 border-t-2 border-border">
                    <div className="space-y-1">
                      <p className="text-sm font-bold text-foreground flex items-center gap-2">
                        <User className="w-4 h-4 text-[#059669]" />
                        {article.author}
                      </p>
                      <p className="text-xs text-muted-foreground flex items-center gap-2">
                        <Calendar className="w-3 h-3" />
                        {article.date} • {article.readTime}
                      </p>
                    </div>
                    <ArrowRight className="w-6 h-6 text-[#059669] group-hover:translate-x-2 transition-transform" />
                  </div>
                </div>
              </article>
            ))}
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
