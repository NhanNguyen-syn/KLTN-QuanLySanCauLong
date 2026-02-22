import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"

export default function PolicyPage() {
  const policies = [
    {
      title: "CHÍNH SÁCH HỦY SÂN",
      items: [
        {
          condition: "Hủy trước 2 giờ",
          fee: "Miễn phí 100%",
          description: "Hoàn tiền toàn bộ vào tài khoản ngay lập tức",
        },
        {
          condition: "Hủy 1-2 giờ trước",
          fee: "Phí 50%",
          description: "Hoàn tiền 50% vào tài khoản trong 24 giờ",
        },
        {
          condition: "Hủy dưới 1 giờ",
          fee: "Không hoàn tiền",
          description: "Chi phí không được hoàn lại do thời gian quá ngắn",
        },
        {
          condition: "Hủy sau khi sử dụng",
          fee: "Không hoàn tiền",
          description: "Không được hoàn lại khi đã sử dụng sân",
        },
      ],
    },
    {
      title: "CHÍNH SÁCH ĐỔI SÂN",
      items: [
        {
          condition: "Đổi trước 2 giờ",
          fee: "Miễn phí",
          description: "Được phép đổi sang sân hoặc giờ khác không tính phí",
        },
        {
          condition: "Đổi 1-2 giờ trước",
          fee: "Phí 50.000đ",
          description: "Tính phí 50.000đ cho mỗi lần đổi",
        },
        {
          condition: "Đổi dưới 1 giờ",
          fee: "Không được đổi",
          description: "Không cho phép đổi sân khi còn dưới 1 giờ",
        },
        {
          condition: "Đổi lên sân cao hơn",
          fee: "Tính chênh lệch",
          description: "Thanh toán thêm chênh lệch giá giữa hai sân",
        },
      ],
    },
    {
      title: "CHÍNH SÁCH HOÀN TIỀN",
      items: [
        {
          condition: "Thời gian hoàn tiền",
          fee: "1-3 ngày làm việc",
          description: "Tiền hoàn về tài khoản ngân hàng hoặc ví điện tử",
        },
        {
          condition: "Hoàn tiền quá mức",
          fee: "Hoàn đầy đủ",
          description: "Nếu tính sai, hoàn lại phần chênh lệch ngay",
        },
        {
          condition: "Chưa nhận hoàn tiền",
          fee: "Liên hệ hỗ trợ",
          description: "Quá 5 ngày chưa nhận, liên hệ bộ phận CSKH",
        },
        {
          condition: "Thành viên",
          fee: "+50% điểm thưởng",
          description: "Thành viên nhận thêm 50% dưới dạng điểm tích lũy",
        },
      ],
    },
  ]

  const exceptions = [
    "Hủy/Đổi do BadmintonPro không có sân: Hoàn 100% + 20% bồi thường",
    "Hủy/Đổi vì sự cố kỹ thuật: Hoàn 100% + 50% bồi thường",
    "Hủy/Đổi do lý do bất khả kháng: Hoàn 100% + giữ để đặt lần sau",
    "Trường hợp khẩn cấp: Liên hệ trực tiếp để thảo luận giải pháp",
  ]

  const notes = [
    {
      title: "Thời gian tính từ khi nào?",
      desc: "Thời gian hủy/đổi được tính từ khoảng cách giữa lúc bạn hủy và giờ bắt đầu đặt sân.",
    },
    {
      title: "Hủy qua điện thoại",
      desc: "Thời gian hủy tính từ lúc thông báo cho nhân viên, không phải lúc gọi.",
    },
    {
      title: "Phương thức hoàn tiền",
      desc: "Tiền hoàn về chính phương thức thanh toán ban đầu.",
    },
    {
      title: "Điểm tích lũy",
      desc: "Nếu hủy mà đã tích điểm, điểm sẽ được hoàn lại hoàn toàn.",
    },
    {
      title: "Gói thành viên",
      desc: "Chính sách này cho đặt sân lẻ. Gói thành viên có chính sách riêng.",
    },
    {
      title: "Cam kết",
      desc: "Xử lý nhanh chóng, minh bạch và ưu tiên quyền lợi khách hàng.",
    },
  ]

  return (
    <div className="min-h-screen flex flex-col">
      <Navigation />

      <main className="flex-1">
        <section className="bg-gradient-to-br from-primary to-secondary text-white py-16 md:py-20">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 className="text-4xl md:text-5xl font-bold mb-4">Chính Sách Hủy / Đổi / Hoàn</h1>
            <p className="text-lg text-white/90 max-w-2xl mx-auto">Quy định rõ ràng về hủy, đổi và hoàn tiền</p>
          </div>
        </section>

        <section className="py-16 md:py-20 bg-background">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid lg:grid-cols-3 gap-8">
              {policies.map((policy, idx) => (
                <div
                  key={idx}
                  className="bg-white rounded-xl border-2 border-border hover:border-primary transition-all"
                >
                  <div className="border-b-2 border-border p-6">
                    <h2 className="text-xl font-bold text-primary">{policy.title}</h2>
                  </div>

                  <div className="divide-y divide-border">
                    {policy.items.map((item, itemIdx) => (
                      <div key={itemIdx} className="p-5">
                        <p className="font-bold text-foreground mb-1">{item.condition}</p>
                        <p className="text-lg font-bold text-primary mb-2">{item.fee}</p>
                        <p className="text-sm text-muted-foreground">{item.description}</p>
                      </div>
                    ))}
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        <section className="py-16 md:py-20 bg-muted/30">
          <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h2 className="text-3xl md:text-4xl font-bold mb-4">Trường Hợp Ngoại Lệ</h2>
              <p className="text-muted-foreground">Các trường hợp đặc biệt được xử lý linh hoạt</p>
            </div>
            <div className="space-y-4">
              {exceptions.map((exception, idx) => (
                <div
                  key={idx}
                  className="bg-white p-6 rounded-xl border-l-4 border-primary hover:shadow-md transition-all"
                >
                  <p className="text-foreground leading-relaxed">{exception}</p>
                </div>
              ))}
            </div>
          </div>
        </section>

        <section className="py-16 md:py-20 bg-background">
          <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 className="text-3xl md:text-4xl font-bold mb-12 text-center">Lưu Ý Quan Trọng</h2>
            <div className="grid md:grid-cols-2 gap-6">
              {notes.map((item, idx) => (
                <div
                  key={idx}
                  className="bg-white p-6 rounded-xl border-2 border-border hover:border-primary hover:shadow-md transition-all"
                >
                  <p className="font-bold text-foreground text-lg mb-2">{item.title}</p>
                  <p className="text-sm text-muted-foreground leading-relaxed">{item.desc}</p>
                </div>
              ))}
            </div>
          </div>
        </section>

        <section className="py-16 md:py-20 bg-muted/30">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Cần Hỗ Trợ?</h2>
            <p className="text-muted-foreground mb-10 text-lg">Liên hệ nếu có thắc mắc về chính sách</p>
            <div className="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto">
              <div className="bg-white p-6 rounded-xl border-2 border-primary">
                <p className="font-bold text-lg mb-1">Điện Thoại</p>
                <p className="text-primary font-bold text-xl">(84) 0886 264 644</p>
              </div>
              <div className="bg-white p-6 rounded-xl border-2 border-secondary">
                <p className="font-bold text-lg mb-1">Email</p>
                <p className="text-secondary font-bold text-xl">info@badmintonpro.vn</p>
              </div>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
