"use client"

import type React from "react"
import { useState, useRef, useEffect } from "react"
import { MessageCircle, X, Send } from "lucide-react"

interface Message {
  id: string
  role: "user" | "assistant"
  content: string
  timestamp: Date
}

// Định nghĩa các câu trả lời cho từng chủ đề cầu lông
const responses: { keywords: string[]; answer: string }[] = [
  {
    keywords: ["đặt sân", "book", "đặt lịch", "cách đặt", "làm sao đặt", "muốn đặt"],
    answer: `Để đặt sân tại BadmintonPro, bạn có thể thực hiện theo các bước sau:

1. Truy cập trang "Đặt Sân" trên website
2. Chọn ngày và khung giờ mong muốn
3. Chọn sân còn trống (màu xanh)
4. Điền thông tin liên hệ và xác nhận

Bạn cũng có thể gọi hotline (84) 0886 264 644 để được hỗ trợ đặt sân trực tiếp.`,
  },
  {
    keywords: ["giá", "bao nhiêu", "chi phí", "tiền", "phí", "thuê"],
    answer: `Bảng giá thuê sân tại BadmintonPro:

• Khách vãng lai: 150.000đ/giờ
• Khách cố định (thành viên): 120.000đ/giờ (tiết kiệm 20%)

Giá áp dụng cho tất cả các ngày trong tuần, không phân biệt giờ cao điểm hay cuối tuần. Tất cả các sân đều có sàn gỗ tiêu chuẩn quốc tế, chiếu sáng LED và điều hòa.`,
  },
  {
    keywords: ["khách cố định", "thành viên", "member", "ưu đãi", "quyền lợi", "đăng ký thành viên"],
    answer: `Quyền lợi Khách Cố Định (Thành viên):

• Giá ưu đãi chỉ 120.000đ/giờ (tiết kiệm 30.000đ/giờ)
• Ưu tiên đặt sân giờ đẹp
• Nước uống & ăn nhẹ miễn phí
• Hỗ trợ huấn luyện cá nhân
• Miễn phí hủy sân trước 1 giờ
• Tích điểm đổi quà & khuyến mãi độc quyền

Để đăng ký thành viên, vui lòng liên hệ hotline hoặc đến trực tiếp cơ sở.`,
  },
  {
    keywords: ["mấy sân", "bao nhiêu sân", "số sân", "có sân nào", "danh sách sân"],
    answer: `BadmintonPro hiện có 8 sân cầu lông tiêu chuẩn quốc tế:

• Sân 1-8: Đều được trang bị sàn gỗ cao cấp, hệ thống chiếu sáng LED chuyên nghiệp và điều hòa không khí.

Tất cả các sân đều có cùng chất lượng và tiện nghi. Bạn có thể xem chi tiết và đặt sân tại trang "Sân & Giá".`,
  },
  {
    keywords: ["giờ mở cửa", "thời gian", "hoạt động", "mấy giờ", "khi nào"],
    answer: `Thời gian hoạt động của BadmintonPro:

• Thứ 2 - Thứ 6: 6:00 - 22:00
• Thứ 7 - Chủ nhật: 6:00 - 23:00

Bạn có thể đặt sân online 24/7 qua website hoặc gọi hotline trong giờ hành chính.`,
  },
  {
    keywords: ["địa chỉ", "ở đâu", "chỗ nào", "location", "vị trí"],
    answer: `Địa chỉ BadmintonPro:

123 Đường Badminton, Quận Cầu Giấy, Hà Nội

Cơ sở nằm gần các tiện ích công cộng, có bãi đỗ xe rộng rãi cho cả ô tô và xe máy. Bạn có thể xem bản đồ chi tiết tại trang "Liên Hệ".`,
  },
  {
    keywords: ["hủy", "cancel", "đổi lịch", "thay đổi", "dời"],
    answer: `Chính sách hủy/đổi lịch đặt sân:

• Khách vãng lai: Hủy miễn phí trước 2 giờ
• Khách cố định: Hủy miễn phí trước 1 giờ

Để hủy hoặc đổi lịch, vui lòng:
1. Truy cập trang "Tra Cứu" và nhập mã đặt sân
2. Hoặc gọi hotline (84) 0886 264 644`,
  },
  {
    keywords: ["liên hệ", "hotline", "điện thoại", "gọi", "email", "zalo"],
    answer: `Thông tin liên hệ BadmintonPro:

• Hotline: (84) 0886 264 644
• Email: info@badmintonpro.vn
• Facebook: facebook.com/badmintonpro
• Zalo: 0886 264 644

Chúng tôi sẵn sàng hỗ trợ bạn từ 6:00 - 22:00 hàng ngày.`,
  },
  {
    keywords: ["dịch vụ", "tiện ích", "có gì", "trang bị", "cơ sở vật chất"],
    answer: `Dịch vụ & Tiện ích tại BadmintonPro:

• 8 sân cầu lông sàn gỗ tiêu chuẩn quốc tế
• Hệ thống chiếu sáng LED chuyên nghiệp
• Điều hòa không khí mát mẻ
• Phòng thay đồ tiện nghi
• Khu vực nghỉ ngơi & căng tin
• Cho thuê vợt và cầu lông
• Bãi đỗ xe rộng rãi
• WiFi miễn phí`,
  },
  {
    keywords: ["xin chào", "hello", "hi", "chào"],
    answer: `Xin chào! Tôi là trợ lý ảo của BadmintonPro. 

Tôi có thể giúp bạn với các thông tin về:
• Cách đặt sân cầu lông
• Bảng giá thuê sân
• Quyền lợi thành viên
• Thông tin cơ sở & dịch vụ

Bạn muốn hỏi về vấn đề gì?`,
  },
]

// Tìm câu trả lời phù hợp dựa trên keywords
function findResponse(input: string): string {
  const lowerInput = input.toLowerCase()

  for (const item of responses) {
    if (item.keywords.some((keyword) => lowerInput.includes(keyword))) {
      return item.answer
    }
  }

  // Nếu không khớp với chủ đề cầu lông
  return `Xin lỗi, tôi chỉ có thể hỗ trợ các câu hỏi liên quan đến đặt sân cầu lông tại BadmintonPro.

Bạn có thể hỏi tôi về:
• Cách đặt sân
• Giá thuê sân
• Quyền lợi thành viên
• Giờ hoạt động
• Địa chỉ & liên hệ

Vui lòng đặt câu hỏi khác hoặc gọi hotline (84) 0886 264 644 để được hỗ trợ trực tiếp.`
}

export function AIChatbot() {
  const [isOpen, setIsOpen] = useState(false)
  const [messages, setMessages] = useState<Message[]>([])
  const [inputValue, setInputValue] = useState("")
  const [isTyping, setIsTyping] = useState(false)
  const messagesEndRef = useRef<HTMLDivElement>(null)

  // Auto scroll to bottom
  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: "smooth" })
  }, [messages])

  const handleSendMessage = (text: string) => {
    if (!text.trim()) return

    const userMessage: Message = {
      id: Date.now().toString(),
      role: "user",
      content: text.trim(),
      timestamp: new Date(),
    }

    setMessages((prev) => [...prev, userMessage])
    setInputValue("")
    setIsTyping(true)

    // Simulate typing delay
    setTimeout(
      () => {
        const botResponse: Message = {
          id: (Date.now() + 1).toString(),
          role: "assistant",
          content: findResponse(text),
          timestamp: new Date(),
        }
        setMessages((prev) => [...prev, botResponse])
        setIsTyping(false)
      },
      500 + Math.random() * 500,
    )
  }

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    handleSendMessage(inputValue)
  }

  const formatTime = (date: Date) => {
    return date.toLocaleTimeString("vi-VN", { hour: "2-digit", minute: "2-digit" })
  }

  return (
    <>
      <button
        onClick={() => setIsOpen(!isOpen)}
        className="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#065f46] text-white shadow-[0_8px_30px_rgba(6,95,70,0.4)] transition-all duration-300 hover:bg-[#047857] hover:scale-110 hover:shadow-[0_12px_40px_rgba(6,95,70,0.5)]"
        aria-label="Chat với trợ lý"
      >
        {isOpen ? (
          <X className="h-6 w-6" />
        ) : (
          <div className="relative">
            <MessageCircle className="h-6 w-6" />
            <span className="absolute -right-1 -top-1 flex h-3 w-3">
              <span className="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-300 opacity-75"></span>
              <span className="relative inline-flex h-3 w-3 rounded-full bg-emerald-400"></span>
            </span>
          </div>
        )}
      </button>

      {isOpen && (
        <div className="fixed bottom-24 right-6 z-50 flex h-[540px] w-[380px] flex-col overflow-hidden rounded-3xl bg-white shadow-[0_25px_60px_-15px_rgba(0,0,0,0.25)] border border-gray-200/50 animate-in slide-in-from-bottom-5 fade-in duration-300">
          <div className="flex items-center justify-between bg-white px-5 py-4 border-b border-gray-100">
            <div className="flex items-center gap-3">
              <div className="relative">
                <div className="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#065f46] text-white shadow-md">
                  <span className="text-base font-bold">B</span>
                </div>
                {/* Online indicator */}
                <span className="absolute -bottom-0.5 -right-0.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-white">
                  <span className="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                </span>
              </div>
              <div>
                <h3 className="text-base font-semibold text-gray-900">BadmintonPro</h3>
                <p className="text-xs text-emerald-600 font-medium">Online - Sẵn sàng hỗ trợ</p>
              </div>
            </div>
            <button
              onClick={() => setIsOpen(false)}
              className="rounded-xl p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-all duration-200"
            >
              <X className="h-5 w-5" />
            </button>
          </div>

          <div
            className="flex-1 space-y-4 overflow-y-auto p-5"
            style={{
              background: "linear-gradient(180deg, #f8faf9 0%, #f1f5f3 100%)",
            }}
          >
            {messages.length === 0 && (
              <div className="space-y-4">
                <div className="flex items-start gap-3">
                  <div className="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-[#065f46] text-white shadow-sm">
                    <span className="text-xs font-bold">B</span>
                  </div>
                  <div className="flex-1">
                    <div className="inline-block rounded-2xl rounded-tl-md bg-white px-4 py-3 text-sm text-gray-700 shadow-sm ring-1 ring-gray-100">
                      Xin chào! Tôi có thể giúp gì cho bạn?
                    </div>
                    <p className="mt-1.5 text-[11px] text-gray-400 font-medium">Bot • Vừa xong</p>
                  </div>
                </div>

                <div className="flex flex-wrap gap-2 pl-12">
                  <button
                    onClick={() => handleSendMessage("Làm sao để đặt sân?")}
                    className="rounded-full bg-white px-4 py-2.5 text-xs font-medium text-[#065f46] shadow-sm ring-1 ring-gray-200 hover:bg-[#065f46] hover:text-white hover:ring-[#065f46] transition-all duration-200"
                  >
                    Làm sao để đặt sân?
                  </button>
                  <button
                    onClick={() => handleSendMessage("Giá thuê sân là bao nhiêu?")}
                    className="rounded-full bg-white px-4 py-2.5 text-xs font-medium text-[#065f46] shadow-sm ring-1 ring-gray-200 hover:bg-[#065f46] hover:text-white hover:ring-[#065f46] transition-all duration-200"
                  >
                    Giá thuê sân bao nhiêu?
                  </button>
                  <button
                    onClick={() => handleSendMessage("Khách cố định có ưu đãi gì?")}
                    className="rounded-full bg-white px-4 py-2.5 text-xs font-medium text-[#065f46] shadow-sm ring-1 ring-gray-200 hover:bg-[#065f46] hover:text-white hover:ring-[#065f46] transition-all duration-200"
                  >
                    Ưu đãi khách cố định?
                  </button>
                  <button
                    onClick={() => handleSendMessage("Có bao nhiêu sân?")}
                    className="rounded-full bg-white px-4 py-2.5 text-xs font-medium text-[#065f46] shadow-sm ring-1 ring-gray-200 hover:bg-[#065f46] hover:text-white hover:ring-[#065f46] transition-all duration-200"
                  >
                    Có bao nhiêu sân?
                  </button>
                </div>
              </div>
            )}

            {messages.map((message) => (
              <div key={message.id}>
                {message.role === "assistant" ? (
                  <div className="flex items-start gap-3">
                    <div className="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-[#065f46] text-white shadow-sm">
                      <span className="text-xs font-bold">B</span>
                    </div>
                    <div className="max-w-[85%]">
                      <div className="rounded-2xl rounded-tl-md bg-white px-4 py-3 text-sm text-gray-700 shadow-sm ring-1 ring-gray-100 whitespace-pre-line leading-relaxed">
                        {message.content}
                      </div>
                      <p className="mt-1.5 text-[11px] text-gray-400 font-medium">
                        Bot • {formatTime(message.timestamp)}
                      </p>
                    </div>
                  </div>
                ) : (
                  <div className="flex justify-end">
                    <div className="max-w-[85%]">
                      <div className="rounded-2xl rounded-tr-md bg-[#065f46] px-4 py-3 text-sm text-white whitespace-pre-line leading-relaxed shadow-md">
                        {message.content}
                      </div>
                      <p className="mt-1.5 text-right text-[11px] text-gray-400 font-medium">
                        {formatTime(message.timestamp)}
                      </p>
                    </div>
                  </div>
                )}
              </div>
            ))}

            {isTyping && (
              <div className="flex items-start gap-3">
                <div className="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-[#065f46] text-white shadow-sm">
                  <span className="text-xs font-bold">B</span>
                </div>
                <div className="rounded-2xl rounded-tl-md bg-white px-5 py-3.5 shadow-sm ring-1 ring-gray-100">
                  <div className="flex items-center gap-1.5">
                    <div className="h-2 w-2 animate-bounce rounded-full bg-gray-400 [animation-delay:-0.3s]"></div>
                    <div className="h-2 w-2 animate-bounce rounded-full bg-gray-400 [animation-delay:-0.15s]"></div>
                    <div className="h-2 w-2 animate-bounce rounded-full bg-gray-400"></div>
                  </div>
                </div>
              </div>
            )}

            <div ref={messagesEndRef} />
          </div>

          <form onSubmit={handleSubmit} className="border-t border-gray-100 bg-white p-4">
            <div className="flex items-center gap-3">
              <input
                type="text"
                value={inputValue}
                onChange={(e) => setInputValue(e.target.value)}
                placeholder="Nhập tin nhắn..."
                disabled={isTyping}
                className="flex-1 rounded-2xl border-0 bg-gray-100 px-5 py-3 text-sm placeholder-gray-400 focus:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#065f46]/20 disabled:opacity-50 transition-all duration-200"
              />
              <button
                type="submit"
                disabled={isTyping || !inputValue.trim()}
                className="flex h-11 w-11 items-center justify-center rounded-xl bg-[#065f46] text-white shadow-md transition-all duration-200 hover:bg-[#047857] hover:shadow-lg hover:scale-105 disabled:opacity-40 disabled:hover:scale-100"
              >
                <Send className="h-4 w-4" />
              </button>
            </div>
          </form>
        </div>
      )}
    </>
  )
}
