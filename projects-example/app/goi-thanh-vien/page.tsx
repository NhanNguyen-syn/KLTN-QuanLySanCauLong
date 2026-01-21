import { AppLayout } from "@/components/app-layout"
import { CACHE_CONFIG } from "@/lib/cache-config"
import { Check, ArrowRight, Plus } from "lucide-react"

export const revalidate = CACHE_CONFIG.DAILY.revalidate

export const metadata = {
  title: "Gói Thành Viên - BadmintonPro",
  description:
    "Các gói thành viên với ưu đãi đặc biệt và quyền lợi hấp dẫn. Khách vãng lai 150K/giờ, thành viên 120K/giờ",
}

export default function MembershipPage() {
  const memberships = [
    {
      id: 1,
      name: "Khách Vãng Lai",
      price: "150.000đ",
      savePercent: null,
      subtitle: "Đặt Sân Linh Hoạt",
      features: [
        "Đặt sân theo nhu cầu, không ràng buộc",
        "Giá tiêu chuẩn 150.000đ mỗi giờ",
        "Đặt sân online 24/7 qua website",
        "Sân gỗ tiêu chuẩn quốc tế",
        "Chiếu sáng LED chuyên nghiệp",
        "Điều hòa không khí",
        "Phòng thay đồ tiện nghi",
      ],
      recommended: false,
    },
    {
      id: 2,
      name: "Khách Cố Định",
      price: "120.000đ",
      savePercent: "20%",
      subtitle: "Ưu Đãi Đặc Biệt",
      features: [
        "Giá ưu đãi chỉ 120.000đ/giờ (tiết kiệm 30.000đ)",
        "Tất cả quyền lợi khách vãng lai",
        "Ưu tiên đặt sân giờ đẹp",
        "Nước uống & ăn nhẹ miễn phí",
        "Hỗ trợ huấn luyện cá nhân",
        "Miễn phí hủy sân trước 1 giờ",
        "Tích điểm đổi quà & khuyến mãi độc quyền",
      ],
      recommended: true,
    },
  ]

  const faqs = [
    {
      question: "Tôi có cần đăng ký thành viên không?",
      answer:
        "Không bắt buộc. Bạn có thể đặt sân bất cứ lúc nào mà không cần đăng ký. Tuy nhiên, nếu đặt sân thường xuyên, gói thành viên mang lại nhiều lợi ích như giá ưu đãi 120.000đ/giờ thay vì 150.000đ/giờ.",
    },
    {
      question: "Tôi có thể đổi gói thành viên bất cứ lúc nào không?",
      answer:
        "Có, bạn có thể hủy đăng ký hoặc quay lại gói khách vãng lai bất cứ lúc nào. Hủy có hiệu lực từ kỳ thanh toán tiếp theo.",
    },
    {
      question: "Sân có cho thuê vợt và cầu không?",
      answer:
        "Có. Chúng tôi có dịch vụ cho thuê vợt và cầu tại quầy lễ tân. Bạn cũng có thể mua cầu lông chính hãng ngay tại sân.",
    },
    {
      question: "Giá sân có khác nhau giữa các gói không?",
      answer:
        "Có. Khách vãng lai trả 150.000đ/giờ, trong khi khách hàng cố định chỉ trả 120.000đ/giờ. Sự khác biệt này phản ánh giá trị các quyền lợi thành viên.",
    },
  ]

  return (
    <AppLayout>
      <section className="py-16 md:py-24 bg-[#f8faf9]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Intro Section */}
          <div className="max-w-3xl mx-auto text-center mb-16">
            <h1 className="text-4xl md:text-5xl font-bold text-[#065f46] mb-6 font-serif">
              Chọn Gói Thành Viên Phù Hợp
            </h1>
            <p className="text-lg text-gray-600 leading-relaxed">
              Hai lựa chọn linh hoạt cho mọi nhu cầu: Vãng Lai dành cho người chơi tự do, Cố Định mang đến ưu đãi và sự
              ổn định. Tất cả được thiết kế để tối ưu trải nghiệm của bạn.
            </p>
          </div>

          <div className="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            {memberships.map((membership) => (
              <div
                key={membership.id}
                className={`bg-white rounded-[2rem] overflow-hidden transition-all duration-300 flex flex-col relative group ${
                  membership.recommended
                    ? "border-2 border-[#065f46] shadow-xl scale-105 md:scale-105 z-10"
                    : "border border-gray-200 shadow-lg hover:shadow-xl hover:border-[#065f46]/50"
                }`}
              >
                {membership.recommended && (
                  <div className="absolute top-0 inset-x-0 bg-[#065f46] text-white text-center py-2 text-sm font-bold uppercase tracking-wider">
                    Phổ Biến Nhất
                  </div>
                )}

                {/* Header với giá */}
                <div className={`p-8 text-center ${membership.recommended ? "pt-12" : ""}`}>
                  <div className="flex items-center justify-center gap-3 mb-4">
                    <h2 className="text-5xl md:text-6xl font-bold text-gray-900 tracking-tight">{membership.price}</h2>
                  </div>
                  <h3 className="text-2xl font-bold text-[#065f46] mb-2">{membership.name}</h3>
                  <p className="text-gray-500 font-medium">{membership.subtitle}</p>
                  {membership.savePercent && (
                    <div className="mt-3">
                      <span className="bg-[#dcfce7] text-[#166534] text-xs font-bold px-3 py-1.5 rounded-full border border-[#166534]/20 inline-block">
                        Tiết kiệm {membership.savePercent}
                      </span>
                    </div>
                  )}
                </div>

                {/* Features list */}
                <div className="px-8 pb-8 flex-1">
                  <div className="w-full h-px bg-gray-100 mb-8"></div>
                  <ul className="space-y-4">
                    {membership.features.map((feature, idx) => (
                      <li key={idx} className="flex items-start gap-3">
                        <div className="mt-1 bg-[#dcfce7] rounded-full p-1">
                          <Check className="w-3.5 h-3.5 text-[#166534]" strokeWidth={3} />
                        </div>
                        <span className="text-gray-700 font-medium">{feature}</span>
                      </li>
                    ))}
                  </ul>
                </div>

                {/* Footer button */}
                <div className="p-8 pt-0">
                  <button
                    className={`w-full py-4 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-300 ${
                      membership.recommended
                        ? "bg-[#065f46] text-white hover:bg-[#044e3a] shadow-lg hover:shadow-[#065f46]/30"
                        : "bg-white text-[#065f46] border-2 border-[#065f46] hover:bg-[#f0fdf4]"
                    }`}
                  >
                    {membership.id === 2 ? "Đăng Ký Ngay" : "Đặt Sân Ngay"}
                    <ArrowRight className="w-5 h-5" />
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-20 md:py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl md:text-4xl font-serif font-bold text-center mb-12 text-[#065f46]">
            Câu Hỏi Thường Gặp
          </h2>
          <div className="grid md:grid-cols-2 gap-4">
            {faqs.map((faq, idx) => (
              <details
                key={idx}
                className="group bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md open:shadow-md open:border-[#065f46]/50"
              >
                <summary className="flex items-center justify-between p-6 cursor-pointer list-none select-none">
                  <span className="font-medium text-gray-900 pr-4">{faq.question}</span>
                  <span className="text-[#065f46] transition-transform duration-300 group-open:rotate-45 shrink-0">
                    <Plus className="w-5 h-5" strokeWidth={3} />
                  </span>
                </summary>
                <div className="px-6 pb-6 text-gray-600 leading-relaxed animate-in fade-in slide-in-from-top-2 duration-300">
                  {faq.answer}
                </div>
              </details>
            ))}
          </div>
        </div>
      </section>
    </AppLayout>
  )
}
