"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState } from "react"
import { LogOut, Settings } from "lucide-react"

export default function AccountPage() {
  const [activeTab, setActiveTab] = useState("profile")
  const [user, setUser] = useState({
    name: "Nguyễn Văn A",
    email: "nguyenvana@email.com",
    phone: "0886 264 644",
    membership: "Khách Hàng Thường",
    joinDate: "2024-01-15",
    membershipExpiryDate: "2024-12-31",
  })

  const tabs = [
    { id: "profile", label: "Thông tin cá nhân" },
    { id: "membership", label: "Gói thành viên" },
    { id: "bookings", label: "Lịch sử đặt sân" },
    { id: "settings", label: "Cài đặt" },
  ]

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        {/* Hero Section - Shorter */}
        <section className="bg-gradient-to-r from-primary via-primary to-primary/90 text-primary-foreground py-10 md:py-12">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex items-center gap-4">
              <div className="w-14 h-14 bg-gradient-to-br from-accent to-secondary rounded-full flex items-center justify-center text-lg font-bold text-white">
                {user.name.charAt(0)}
              </div>
              <div>
                <h1 className="text-2xl md:text-3xl font-bold">{user.name}</h1>
                <p className="text-primary-foreground/90 text-sm">{user.membership}</p>
              </div>
            </div>
          </div>
        </section>

        {/* Content */}
        <section className="py-12 md:py-16">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid lg:grid-cols-4 gap-6">
              {/* Sidebar - Compact */}
              <div className="lg:col-span-1">
                <div className="bg-card rounded-lg border border-border p-2 sticky top-24 space-y-1">
                  {tabs.map((tab) => (
                    <button
                      key={tab.id}
                      onClick={() => setActiveTab(tab.id)}
                      className={`w-full text-left px-4 py-3 rounded-md font-medium transition-all text-sm ${
                        activeTab === tab.id ? "bg-primary text-primary-foreground" : "text-foreground hover:bg-muted"
                      }`}
                    >
                      {tab.label}
                    </button>
                  ))}
                </div>
              </div>

              {/* Main Content */}
              <div className="lg:col-span-3 space-y-6">
                {/* Profile Tab */}
                {activeTab === "profile" && (
                  <div className="bg-card rounded-lg border border-border p-6 md:p-8">
                    <h2 className="text-2xl font-bold mb-6 text-foreground">Thông tin cá nhân</h2>
                    <form className="space-y-5">
                      <div className="grid md:grid-cols-2 gap-5">
                        <div>
                          <label className="block text-sm font-semibold text-foreground mb-2">Họ và tên</label>
                          <input
                            type="text"
                            value={user.name}
                            onChange={(e) => setUser({ ...user, name: e.target.value })}
                            className="w-full px-4 py-2.5 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-input text-foreground"
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-semibold text-foreground mb-2">Email</label>
                          <input
                            type="email"
                            value={user.email}
                            onChange={(e) => setUser({ ...user, email: e.target.value })}
                            className="w-full px-4 py-2.5 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-input text-foreground"
                          />
                        </div>
                      </div>
                      <div>
                        <label className="block text-sm font-semibold text-foreground mb-2">Số điện thoại</label>
                        <input
                          type="tel"
                          value={user.phone}
                          onChange={(e) => setUser({ ...user, phone: e.target.value })}
                          className="w-full px-4 py-2.5 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-input text-foreground"
                        />
                      </div>
                      <button
                        type="submit"
                        className="px-6 py-2.5 bg-primary text-primary-foreground rounded-lg font-semibold hover:bg-primary/90 transition-colors"
                      >
                        Lưu thay đổi
                      </button>
                    </form>
                  </div>
                )}

                {/* Membership Tab */}
                {activeTab === "membership" && (
                  <div className="space-y-6">
                    <div className="bg-gradient-to-br from-secondary/10 to-accent/10 rounded-lg border-2 border-secondary p-6 md:p-8">
                      <div className="flex items-start justify-between mb-6">
                        <div>
                          <h3 className="text-xl font-bold text-primary mb-1">Gói {user.membership}</h3>
                          <p className="text-sm text-muted-foreground">
                            Ngày tham gia: {new Date(user.joinDate).toLocaleDateString("vi-VN")}
                          </p>
                        </div>
                        <span className="px-3 py-1 bg-secondary/20 text-secondary rounded-full text-xs font-semibold">
                          Đang hoạt động
                        </span>
                      </div>

                      <div className="grid sm:grid-cols-3 gap-4 mb-6 pb-6 border-b border-secondary/20">
                        <div className="bg-white dark:bg-card rounded-lg p-4">
                          <p className="text-xs text-muted-foreground uppercase font-semibold mb-1">Giá sân</p>
                          <p className="text-2xl font-bold text-primary">120.000đ</p>
                          <p className="text-xs text-accent font-semibold mt-1">/ giờ</p>
                        </div>
                        <div className="bg-white dark:bg-card rounded-lg p-4">
                          <p className="text-xs text-muted-foreground uppercase font-semibold mb-1">Tiết kiệm</p>
                          <p className="text-2xl font-bold text-secondary">30.000đ</p>
                          <p className="text-xs text-muted-foreground mt-1">/ giờ</p>
                        </div>
                        <div className="bg-white dark:bg-card rounded-lg p-4">
                          <p className="text-xs text-muted-foreground uppercase font-semibold mb-1">Hạn sử dụng</p>
                          <p className="text-lg font-bold text-foreground">
                            {new Date(user.membershipExpiryDate).toLocaleDateString("vi-VN")}
                          </p>
                        </div>
                      </div>

                      <div className="space-y-2">
                        <p className="font-semibold text-foreground mb-3">Quyền lợi:</p>
                        <div className="grid sm:grid-cols-2 gap-2">
                          <p className="text-sm text-foreground">✓ Giá ưu đãi 120.000đ/giờ</p>
                          <p className="text-sm text-foreground">✓ Ưu tiên đặt sân cao điểm</p>
                          <p className="text-sm text-foreground">✓ Hỗ trợ 24/7 VIP</p>
                          <p className="text-sm text-foreground">✓ Miễn phí nước và khăn</p>
                          <p className="text-sm text-foreground">✓ Điểm thành viên</p>
                          <p className="text-sm text-foreground">✓ Hủy miễn phí 1 giờ</p>
                        </div>
                      </div>
                    </div>

                    <button className="w-full bg-secondary text-secondary-foreground py-3 rounded-lg font-semibold hover:bg-secondary/90 transition-colors">
                      Gia hạn thành viên
                    </button>
                  </div>
                )}

                {/* Bookings Tab */}
                {activeTab === "bookings" && (
                  <div className="bg-card rounded-lg border border-border p-6 md:p-8">
                    <h2 className="text-2xl font-bold mb-6 text-foreground">Lịch sử đặt sân</h2>
                    <div className="space-y-4">
                      {[
                        {
                          date: "15/11/2024",
                          court: "Sân 1",
                          time: "19:00 - 21:00",
                          status: "Hoàn thành",
                          price: "120.000đ",
                        },
                        {
                          date: "10/11/2024",
                          court: "Sân 3",
                          time: "18:00 - 20:00",
                          status: "Hoàn thành",
                          price: "120.000đ",
                        },
                        { date: "05/11/2024", court: "Sân 5", time: "20:00 - 22:00", status: "Đã hủy", price: "0đ" },
                      ].map((booking, idx) => (
                        <div
                          key={idx}
                          className="border border-border rounded-lg p-4 hover:border-primary/50 transition-colors"
                        >
                          <div className="flex items-center justify-between flex-wrap gap-4">
                            <div className="flex-1">
                              <h3 className="font-semibold text-foreground">{booking.court}</h3>
                              <p className="text-sm text-muted-foreground">
                                {booking.date} • {booking.time}
                              </p>
                            </div>
                            <div className="text-right">
                              <p className="font-semibold text-foreground">{booking.price}</p>
                              <span
                                className={`inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1 ${
                                  booking.status === "Hoàn thành"
                                    ? "bg-secondary/20 text-secondary"
                                    : "bg-destructive/20 text-destructive"
                                }`}
                              >
                                {booking.status}
                              </span>
                            </div>
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>
                )}

                {/* Settings Tab */}
                {activeTab === "settings" && (
                  <div className="space-y-6">
                    <div className="bg-card rounded-lg border border-border p-6 md:p-8">
                      <h3 className="text-2xl font-bold text-foreground mb-6 flex items-center gap-2">
                        <Settings className="w-6 h-6" />
                        Cài đặt tài khoản
                      </h3>

                      <div className="space-y-5">
                        <div>
                          <label className="block text-sm font-semibold text-foreground mb-2">Mật khẩu hiện tại</label>
                          <input
                            type="password"
                            className="w-full px-4 py-2.5 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-input text-foreground"
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-semibold text-foreground mb-2">Mật khẩu mới</label>
                          <input
                            type="password"
                            className="w-full px-4 py-2.5 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-input text-foreground"
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-semibold text-foreground mb-2">Xác nhận mật khẩu</label>
                          <input
                            type="password"
                            className="w-full px-4 py-2.5 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary bg-input text-foreground"
                          />
                        </div>
                        <button className="px-6 py-2.5 bg-primary text-primary-foreground rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                          Đổi mật khẩu
                        </button>
                      </div>
                    </div>

                    <div className="bg-card rounded-lg border border-border p-6 md:p-8">
                      <h3 className="font-bold text-foreground mb-4 flex items-center gap-2">
                        <LogOut className="w-5 h-5 text-destructive" />
                        Nguy hiểm
                      </h3>
                      <button className="px-6 py-2.5 border-2 border-destructive text-destructive rounded-lg font-semibold hover:bg-destructive/10 transition-colors">
                        Đăng xuất
                      </button>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
