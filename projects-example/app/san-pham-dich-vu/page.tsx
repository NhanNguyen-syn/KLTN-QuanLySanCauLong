"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState } from "react"

export default function Products() {
  const [selectedCategory, setSelectedCategory] = useState("all")

  const products = [
    {
      id: 1,
      name: "Vợt Cầu Lông Chuyên Nghiệp",
      category: "equipment",
      price: 450000,
      image: "/badminton-racket.png",
      description: "Vợt cầu lông cao cấp, phù hợp cho các vận động viên",
    },
    {
      id: 2,
      name: "Quấn Cán Cầu Lông",
      category: "supplies",
      price: 35000,
      image: "/badminton-grip.jpg",
      description: "Quấn cán chất lượng, thoáng khí, chống trơn",
    },
    {
      id: 3,
      name: "Giày Cầu Lông",
      category: "clothing",
      price: 550000,
      image: "/badminton-shoes.jpg",
      description: "Giày chuyên dụng cho cầu lông, nhẹ và bền",
    },
    {
      id: 4,
      name: "Quần Áo Cầu Lông",
      category: "clothing",
      price: 250000,
      image: "/badminton-clothing.jpg",
      description: "Quần áo thể thao chất liệu thoáng khí",
    },
    {
      id: 5,
      name: "Nước Uống Năng Lượng",
      category: "beverage",
      price: 45000,
      image: "/vibrant-energy-drink.png",
      description: "Nước uống bổ sung điện giải cho vận động viên",
    },
    {
      id: 6,
      name: "Khăn Thể Thao",
      category: "supplies",
      price: 85000,
      image: "/sports-towel.jpg",
      description: "Khăn thấm hút mồ hôi chuyên dụng",
    },
  ]

  const categories = [
    { id: "all", label: "Tất Cả" },
    { id: "equipment", label: "Dụng Cụ" },
    { id: "clothing", label: "Quần Áo" },
    { id: "supplies", label: "Phụ Kiện" },
    { id: "beverage", label: "Nước Uống" },
  ]

  const services = [
    {
      id: 1,
      name: "Cho Thuê Vợt",
      price: "25.000đ/giờ",
      description: "Thuê vợt chuyên nghiệp theo giờ",
    },
    {
      id: 2,
      name: "Hướng Dẫn Đá Bóng",
      price: "150.000đ/giờ",
      description: "Học tập kỹ thuật cầu lông từ HLV chuyên nghiệp",
    },
    {
      id: 3,
      name: "Dịch Vụ Giặt Quần Áo",
      price: "15.000đ/bộ",
      description: "Giặt sấy quần áo thể thao nhanh chóng",
    },
    {
      id: 4,
      name: "Sửa Vợt",
      price: "50.000đ - 200.000đ",
      description: "Sửa chữa và bảo trì vợt cầu lông",
    },
  ]

  const filteredProducts =
    selectedCategory === "all" ? products : products.filter((p) => p.category === selectedCategory)

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        {/* Header */}
        <section className="bg-gradient-to-r from-primary via-primary to-primary/95 text-white relative overflow-hidden">
          <div className="absolute inset-0 opacity-5">
            <div className="absolute top-0 right-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
            <div className="absolute bottom-0 left-0 w-80 h-80 bg-white rounded-full blur-3xl"></div>
          </div>

          <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div className="space-y-3 max-w-2xl">
              <div className="inline-block bg-white/15 backdrop-blur-sm px-4 py-2 rounded-full">
                <span className="text-xs font-bold tracking-wider uppercase text-secondary">Chuyên Mục Sản Phẩm</span>
              </div>
              <h1 className="text-5xl md:text-6xl font-extrabold leading-tight font-serif">Sản Phẩm & Dịch Vụ</h1>
              <p className="text-lg text-white/85 leading-relaxed pt-2">
                Tất cả những gì bạn cần cho trình độ cầu lông từ cơ bản đến chuyên nghiệp
              </p>
            </div>
          </div>
        </section>

        {/* Products Section */}
        <section className="py-12 max-w-7xl mx-auto px-4">
          <h2 className="text-2xl font-bold text-foreground mb-8">Sản Phẩm</h2>

          {/* Category Filter */}
          <div className="flex gap-2 mb-8 overflow-x-auto pb-2">
            {categories.map((cat) => (
              <button
                key={cat.id}
                onClick={() => setSelectedCategory(cat.id)}
                className={`px-4 py-2 rounded-lg font-semibold whitespace-nowrap transition-all ${
                  selectedCategory === cat.id
                    ? "bg-primary text-white"
                    : "bg-white border-2 border-border text-foreground hover:border-primary"
                }`}
              >
                {cat.label}
              </button>
            ))}
          </div>

          {/* Products Grid */}
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            {filteredProducts.map((product) => (
              <div
                key={product.id}
                className="bg-white rounded-lg border-2 border-border overflow-hidden hover:shadow-lg transition-shadow"
              >
                <img
                  src={product.image || "/placeholder.svg"}
                  alt={product.name}
                  className="w-full h-48 object-cover"
                />
                <div className="p-4">
                  <h3 className="text-lg font-bold text-foreground mb-1">{product.name}</h3>
                  <p className="text-sm text-muted-foreground mb-4">{product.description}</p>
                  <div className="flex justify-between items-center">
                    <p className="text-lg font-bold text-primary">{product.price.toLocaleString("vi-VN")}đ</p>
                    <button className="px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-accent transition-colors">
                      Liên hệ trực tiếp tại quầy
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </section>

        {/* Services Section */}
        <section className="py-12 max-w-7xl mx-auto px-4 bg-white rounded-lg border-2 border-border p-8">
          <h2 className="text-2xl font-bold text-foreground mb-8">Dịch Vụ Thêm</h2>
          <div className="grid md:grid-cols-2 gap-6">
            {services.map((service) => (
              <div
                key={service.id}
                className="p-6 border-2 border-border rounded-lg hover:border-primary transition-colors"
              >
                <h3 className="text-lg font-bold text-foreground mb-2">{service.name}</h3>
                <p className="text-sm text-muted-foreground mb-3">{service.description}</p>
                <p className="text-lg font-bold text-primary mb-3">{service.price}</p>
                <button className="w-full px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-accent transition-colors">
                  Liên hệ tại quầy
                </button>
              </div>
            ))}
          </div>
        </section>
      </main>

      <Footer />
    </div>
  )
}
