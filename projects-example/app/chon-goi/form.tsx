"use client"

import { useState } from "react"
import { Users, Star } from "lucide-react"

export function SelectionForm() {
  const [formData, setFormData] = useState({
    customerType: "",
  })

  const handleSelectOption = (customerType: string) => {
    const bookingData = {
      customerType,
      bookingType: "fixed-daily",
    }
    localStorage.setItem("customerData", JSON.stringify(bookingData))
    window.location.href = "/dat-san"
  }

  return (
    <>
      <section className="py-16 md:py-20 max-w-5xl mx-auto px-4">
        <div className="space-y-10 animate-fadeIn">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-5xl font-serif font-bold mb-4 text-balance">Đối Tượng Khách Hàng</h2>
            <p className="text-base md:text-xl text-muted-foreground text-pretty max-w-2xl mx-auto">
              Chọn loại hình phù hợp với nhu cầu sử dụng sân của bạn
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {[
              {
                id: "casual",
                title: "Khách Vãng Lai",
                description: "Đặt sân linh hoạt theo nhu cầu sử dụng",
                subtitle: "Đặt khung giờ cố định và theo ngày",
                icon: <Users className="w-10 h-10" />,
                benefits: [
                  "Nước uống 10L miễn phí",
                  "Khăn ướt cao cấp",
                  "Ưu tiên đặt sân trước 1 giờ",
                  "Quà tặng hàng tháng",
                ],
                color: "from-secondary to-accent",
              },
              {
                id: "fixed",
                title: "Khách Cố Định",
                description: "Đặt sân cố định với ưu đãi đặc biệt",
                subtitle: "Đặt khung giờ cố định và theo ngày",
                icon: <Star className="w-10 h-10" />,
                benefits: [
                  "Nước ion không giới hạn",
                  "Khăn khô cao cấp",
                  "Ăn nhẹ 4-6 người/tuần",
                  "Giá ưu đãi 120k/giờ",
                  "Hỗ trợ VIP 24/7",
                  "Huấn luyện 1-1 mỗi tháng",
                ],
                color: "from-primary to-secondary",
              },
            ].map((type) => (
              <button
                key={type.id}
                type="button"
                onClick={() => handleSelectOption(type.id)}
                className="group relative p-8 rounded-3xl border-2 border-border hover:border-primary/50 hover:shadow-2xl bg-card transition-all duration-300 text-left overflow-hidden hover:scale-105 active:scale-95"
              >
                <div
                  className={`absolute inset-0 bg-gradient-to-br ${type.color} opacity-0 group-hover:opacity-10 transition-opacity`}
                ></div>
                <div className="relative">
                  <div
                    className={`w-20 h-20 rounded-2xl flex items-center justify-center mb-6 bg-gradient-to-br ${type.color} text-white shadow-lg transition-all group-hover:scale-110`}
                  >
                    {type.icon}
                  </div>
                  <h3 className="font-bold text-2xl mb-2 text-foreground">{type.title}</h3>
                  <p className="text-sm text-muted-foreground mb-1 leading-relaxed">{type.description}</p>
                  <p className="text-xs text-primary font-semibold mb-6 italic">{type.subtitle}</p>
                  <ul className="space-y-3">
                    {type.benefits.map((benefit, idx) => (
                      <li key={idx} className="flex items-center gap-3 text-sm text-foreground">
                        <div className="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 bg-muted group-hover:bg-primary/20 transition-colors">
                          <span className="text-xs text-muted-foreground group-hover:text-primary transition-colors">
                            ✓
                          </span>
                        </div>
                        {benefit}
                      </li>
                    ))}
                  </ul>
                </div>
              </button>
            ))}
          </div>

          <div className="text-center mt-12">
            <p className="text-sm text-muted-foreground">Nhấn vào loại khách hàng để bắt đầu đặt sân</p>
          </div>
        </div>
      </section>
    </>
  )
}
