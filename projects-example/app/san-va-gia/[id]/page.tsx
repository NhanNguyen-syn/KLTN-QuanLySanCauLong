"use client"

import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { useState } from "react"
import Link from "next/link"
import Image from "next/image"
import { useParams } from "next/navigation"
import {
  ArrowLeft,
  ArrowRight,
  MapPin,
  Clock,
  Star,
  Shield,
  Thermometer,
  Lightbulb,
  RulerIcon,
  Users,
  Wifi,
  Car,
  ShowerHeadIcon,
} from "lucide-react"

const courtsData: Record<
  string,
  {
    id: number
    name: string
    surface: string
    size: string
    lighting: string
    airConditioned: boolean
    description: string
    features: string[]
    images: string[]
    availability: string
    rating: number
    reviews: number
  }
> = {
  "1": {
    id: 1,
    name: "San 1",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 1 la san dau tien cua he thong, duoc trang bi day du tien nghi voi san go cao cap nhap khau tu chau Au, he thong chieu sang LED chuyen nghiep 500 lux va dieu hoa nhiet do. Day la san ly tuong cho cac tran dau chuyen nghiep va tap luyen hang ngay.",
    features: [
      "San go cao cap nhap khau chau Au",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Luoi cau long Yonex chinh hang",
      "Khong gian rong rai, thoang mat",
      "Camera giam sat an toan",
    ],
    images: [
      "/modern-badminton-court-interior-professional-light.jpg",
      "/badminton-court-clean.jpg",
      "/badminton-court-spacious.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.8,
    reviews: 124,
  },
  "2": {
    id: 2,
    name: "San 2",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 2 nam ke ben San 1, cung duoc trang bi he thong san go chuan quoc te. San nay thuong duoc lua chon cho cac buoi tap luyen nhom va giao luu giua cac doi.",
    features: [
      "San go cao cap chuan quoc te",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Luoi cau long Yonex chinh hang",
      "Phu hop tap luyen nhom",
      "Camera giam sat an toan",
    ],
    images: [
      "/badminton-court-clean.jpg",
      "/modern-badminton-facility.jpg",
      "/professional-badminton-lighting.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.7,
    reviews: 98,
  },
  "3": {
    id: 3,
    name: "San 3",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 3 la mot trong nhung san duoc yeu thich nhat voi vi tri trung tam, thuan tien di chuyen. San duoc thiet ke dac biet phu hop cho cac tran dau doi kang.",
    features: [
      "San go cao cap chuan quoc te",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Vi tri trung tam thuan tien",
      "Phu hop thi dau doi khang",
      "Camera giam sat an toan",
    ],
    images: [
      "/badminton-court-spacious.jpg",
      "/competition-court.jpg",
      "/modern-badminton-court-interior-professional-light.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.9,
    reviews: 156,
  },
  "4": {
    id: 4,
    name: "San 4",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 4 co khong gian rieng tu, phu hop cho cac buoi huan luyen ca nhan hoac tap luyen rieng. He thong thong gio hien dai dam bao khong khi luon trong lanh.",
    features: [
      "San go cao cap chuan quoc te",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Khong gian rieng tu",
      "Phu hop huan luyen ca nhan",
      "Camera giam sat an toan",
    ],
    images: [
      "/modern-badminton-facility.jpg",
      "/badminton-court-clean.jpg",
      "/professional-badminton-lighting.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.6,
    reviews: 87,
  },
  "5": {
    id: 5,
    name: "San 5",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 5 duoc nang cap moi voi he thong chieu sang tien tien nhat, mang lai trai nghiem choi cau long tot nhat cho nguoi choi o moi trinh do.",
    features: [
      "San go nang cap moi",
      "He thong LED 500 lux the he moi",
      "Dieu hoa nhiet do 24-26°C",
      "He thong chieu sang tien tien",
      "Phu hop moi trinh do",
      "Camera giam sat an toan",
    ],
    images: [
      "/professional-badminton-lighting.jpg",
      "/competition-court.jpg",
      "/badminton-court-spacious.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.8,
    reviews: 112,
  },
  "6": {
    id: 6,
    name: "San 6",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 6 la san duoc lua chon nhieu nhat cho cac giai dau noi bo va su kien cau long. Khong gian rong rai voi kha nang phuc vu khan gia theo doi tran dau.",
    features: [
      "San go cao cap chuan quoc te",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Phu hop to chuc giai dau",
      "Khu vuc khan gia",
      "Camera giam sat an toan",
    ],
    images: [
      "/competition-court.jpg",
      "/modern-badminton-court-interior-professional-light.jpg",
      "/badminton-court-clean.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.7,
    reviews: 103,
  },
  "7": {
    id: 7,
    name: "San 7",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 7 duoc thiet ke danh rieng cho viec huan luyen va cai thien ky nang. Day la lua chon tuyet voi cho nguoi moi bat dau cung nhu nguoi choi muon nang cao trinh do.",
    features: [
      "San go cao cap chuan quoc te",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Khu vuc huan luyen rieng",
      "Phu hop nguoi moi bat dau",
      "Camera giam sat an toan",
    ],
    images: [
      "/badminton-court-clean.jpg",
      "/modern-badminton-facility.jpg",
      "/badminton-court-spacious.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.5,
    reviews: 76,
  },
  "8": {
    id: 8,
    name: "San 8",
    surface: "San go cao cap nhap khau",
    size: "13.4m x 6.1m (Chuan BWF)",
    lighting: "He thong LED 500 lux",
    airConditioned: true,
    description:
      "San 8 la san cuoi cung trong he thong, mang den trai nghiem yen tinh va thu gian nhat. San nay phu hop cho nhung ai muon tap luyen trong khong gian rieng tu va thoai mai.",
    features: [
      "San go cao cap chuan quoc te",
      "He thong LED 500 lux chuyen nghiep",
      "Dieu hoa nhiet do 24-26°C",
      "Khong gian yen tinh",
      "Phu hop tap luyen thu gian",
      "Camera giam sat an toan",
    ],
    images: [
      "/badminton-court-spacious.jpg",
      "/modern-badminton-court-interior-professional-light.jpg",
      "/competition-court.jpg",
    ],
    availability: "5:00 - 23:00 hang ngay",
    rating: 4.6,
    reviews: 91,
  },
}

export default function CourtDetailPage() {
  const params = useParams()
  const courtId = params.id as string
  const court = courtsData[courtId]
  const [selectedImage, setSelectedImage] = useState(0)

  if (!court) {
    return (
      <div className="min-h-screen flex flex-col bg-background">
        <Navigation />
        <main className="flex-1 flex items-center justify-center">
          <div className="text-center space-y-4">
            <h1 className="text-3xl font-bold text-foreground">{"Khong tim thay san"}</h1>
            <p className="text-muted-foreground">{"San ban dang tim khong ton tai."}</p>
            <Link
              href="/san-va-gia"
              className="inline-flex items-center gap-2 bg-[#065f46] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#065f46]/90 transition-all"
            >
              <ArrowLeft className="w-4 h-4" />
              {"Quay lai danh sach san"}
            </Link>
          </div>
        </main>
        <Footer />
      </div>
    )
  }

  const amenities = [
    { icon: Wifi, label: "WiFi mien phi" },
    { icon: Car, label: "Bai do xe rong" },
    { icon: ShowerHeadIcon, label: "Phong tam & thay do" },
    { icon: Users, label: "Khu vuc nghi chan" },
  ]

  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        {/* Breadcrumb */}
        <div className="bg-muted/30 border-b border-border">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav className="flex items-center gap-2 text-sm text-muted-foreground">
              <Link href="/" className="hover:text-foreground transition-colors">
                {"Trang chu"}
              </Link>
              <span>/</span>
              <Link href="/san-va-gia" className="hover:text-foreground transition-colors">
                {"San & Gia"}
              </Link>
              <span>/</span>
              <span className="text-foreground font-medium">{court.name}</span>
            </nav>
          </div>
        </div>

        {/* Court Header */}
        <section className="bg-muted/20 py-8 md:py-10">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
              <div className="space-y-2">
                <div className="flex items-center gap-3">
                  <h1 className="text-3xl md:text-4xl font-extrabold text-foreground font-serif">{court.name}</h1>
                  <span className="bg-[#059669] text-white text-xs font-bold px-3 py-1.5 rounded-full">
                    {"Dang hoat dong"}
                  </span>
                </div>
                <div className="flex items-center gap-4">
                  <div className="flex items-center gap-1.5">
                    <MapPin className="w-4 h-4 text-muted-foreground" />
                    <span className="text-sm text-muted-foreground">{"123 Duong Badminton, Quan Cau Giay, Ha Noi"}</span>
                  </div>
                  <div className="flex items-center gap-1">
                    <Star className="w-4 h-4 text-yellow-500 fill-yellow-500" />
                    <span className="text-sm font-bold text-foreground">{court.rating}</span>
                    <span className="text-sm text-muted-foreground">({court.reviews} danh gia)</span>
                  </div>
                </div>
              </div>
              <Link
                href="/dat-san"
                className="hidden md:inline-flex items-center gap-2 bg-[#065f46] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#065f46]/90 transition-all shadow-lg hover:shadow-xl hover:scale-105"
              >
                {"Dat San Ngay"}
                <ArrowRight className="w-5 h-5" />
              </Link>
            </div>

            {/* Image Gallery */}
            <div className="space-y-3">
              {/* Main Image */}
              <div className="relative w-full h-[300px] md:h-[450px] rounded-2xl overflow-hidden">
                <Image
                  src={court.images[selectedImage]}
                  alt={`${court.name} - Anh ${selectedImage + 1}`}
                  fill
                  className="object-cover transition-all duration-500"
                />
              </div>

              {/* Thumbnail Row */}
              <div className="flex gap-3">
                {court.images.map((img, index) => (
                  <button
                    key={index}
                    onClick={() => setSelectedImage(index)}
                    className={`relative w-24 h-16 md:w-32 md:h-20 rounded-xl overflow-hidden transition-all duration-200 ${
                      selectedImage === index
                        ? "ring-2 ring-[#059669] ring-offset-2 opacity-100"
                        : "opacity-60 hover:opacity-90"
                    }`}
                  >
                    <Image
                      src={img}
                      alt={`${court.name} - Thumbnail ${index + 1}`}
                      fill
                      className="object-cover"
                    />
                  </button>
                ))}
              </div>
            </div>
          </div>
        </section>

        {/* Content */}
        <section className="py-10 md:py-14">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid lg:grid-cols-3 gap-8">
              {/* Main Content */}
              <div className="lg:col-span-2 space-y-8">
                {/* Description */}
                <div className="bg-white rounded-2xl border border-border p-6 md:p-8 space-y-4">
                  <h2 className="text-2xl font-bold text-foreground font-serif">{"Gioi thieu"}</h2>
                  <p className="text-muted-foreground leading-relaxed">{court.description}</p>
                </div>

                {/* Specifications */}
                <div className="bg-white rounded-2xl border border-border p-6 md:p-8">
                  <h2 className="text-2xl font-bold text-foreground font-serif mb-6">{"Thong so ky thuat"}</h2>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="flex items-start gap-4 p-4 bg-muted/30 rounded-xl">
                      <div className="w-10 h-10 rounded-lg bg-[#059669]/10 flex items-center justify-center flex-shrink-0">
                        <RulerIcon className="w-5 h-5 text-[#059669]" />
                      </div>
                      <div>
                        <p className="text-sm font-semibold text-foreground">{"Kich thuoc san"}</p>
                        <p className="text-sm text-muted-foreground">{court.size}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-4 p-4 bg-muted/30 rounded-xl">
                      <div className="w-10 h-10 rounded-lg bg-[#059669]/10 flex items-center justify-center flex-shrink-0">
                        <Shield className="w-5 h-5 text-[#059669]" />
                      </div>
                      <div>
                        <p className="text-sm font-semibold text-foreground">{"Mat san"}</p>
                        <p className="text-sm text-muted-foreground">{court.surface}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-4 p-4 bg-muted/30 rounded-xl">
                      <div className="w-10 h-10 rounded-lg bg-[#059669]/10 flex items-center justify-center flex-shrink-0">
                        <Lightbulb className="w-5 h-5 text-[#059669]" />
                      </div>
                      <div>
                        <p className="text-sm font-semibold text-foreground">{"Chieu sang"}</p>
                        <p className="text-sm text-muted-foreground">{court.lighting}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-4 p-4 bg-muted/30 rounded-xl">
                      <div className="w-10 h-10 rounded-lg bg-[#059669]/10 flex items-center justify-center flex-shrink-0">
                        <Thermometer className="w-5 h-5 text-[#059669]" />
                      </div>
                      <div>
                        <p className="text-sm font-semibold text-foreground">{"Dieu hoa"}</p>
                        <p className="text-sm text-muted-foreground">
                          {court.airConditioned ? "Co - Nhiet do 24-26°C" : "Khong co"}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Amenities */}
                <div className="bg-white rounded-2xl border border-border p-6 md:p-8">
                  <h2 className="text-2xl font-bold text-foreground font-serif mb-6">{"Tien ich chung"}</h2>
                  <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    {amenities.map((amenity, index) => (
                      <div key={index} className="flex flex-col items-center gap-3 p-4 bg-muted/30 rounded-xl text-center">
                        <div className="w-12 h-12 rounded-full bg-[#059669]/10 flex items-center justify-center">
                          <amenity.icon className="w-6 h-6 text-[#059669]" />
                        </div>
                        <span className="text-sm font-medium text-foreground">{amenity.label}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </div>

              {/* Sidebar */}
              <div className="lg:col-span-1">
                <div className="sticky top-28 space-y-6">
                  {/* Pricing Card */}
                  <div className="bg-white rounded-2xl border border-border p-6 space-y-6">
                    <div className="space-y-2">
                      <h3 className="text-lg font-bold text-foreground">{"Bang gia"}</h3>
                      <div className="border-b border-border pb-4 space-y-3">
                        <div className="flex items-center justify-between">
                          <span className="text-sm text-muted-foreground">{"Khach vang lai"}</span>
                          <span className="text-lg font-bold text-foreground">
                            150.000d<span className="text-sm font-normal text-muted-foreground">/gio</span>
                          </span>
                        </div>
                        <div className="flex items-center justify-between">
                          <div className="flex items-center gap-2">
                            <span className="text-sm text-muted-foreground">{"Khach co dinh"}</span>
                            <span className="bg-[#059669]/10 text-[#059669] text-xs font-bold px-2 py-0.5 rounded-full">
                              -20%
                            </span>
                          </div>
                          <span className="text-lg font-bold text-[#059669]">
                            120.000d<span className="text-sm font-normal text-muted-foreground">/gio</span>
                          </span>
                        </div>
                      </div>
                    </div>

                    {/* Operating Hours */}
                    <div className="space-y-3">
                      <h3 className="text-lg font-bold text-foreground">{"Gio hoat dong"}</h3>
                      <div className="flex items-center gap-3 p-3 bg-muted/30 rounded-xl">
                        <Clock className="w-5 h-5 text-[#059669]" />
                        <div>
                          <p className="text-sm font-semibold text-foreground">{court.availability}</p>
                          <p className="text-xs text-muted-foreground">{"Bao gom ca ngay le va cuoi tuan"}</p>
                        </div>
                      </div>
                    </div>

                    {/* CTA Buttons */}
                    <div className="space-y-3 pt-2">
                      <Link
                        href="/dat-san"
                        className="group flex items-center justify-center gap-2 w-full bg-[#065f46] text-white py-3.5 rounded-xl font-bold text-base hover:bg-[#065f46]/90 transition-all shadow-lg hover:shadow-xl"
                      >
                        {"Dat San Ngay"}
                        <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                      </Link>
                      <Link
                        href="/san-va-gia"
                        className="flex items-center justify-center gap-2 w-full bg-transparent text-foreground border-2 border-border py-3.5 rounded-xl font-bold text-base hover:border-[#059669] hover:text-[#059669] transition-all"
                      >
                        <ArrowLeft className="w-4 h-4" />
                        {"Xem tat ca san"}
                      </Link>
                    </div>
                  </div>

                  {/* Quick Navigation - also sticky */}
                  <div className="bg-white rounded-2xl border border-border p-6 space-y-4">
                    <h3 className="text-lg font-bold text-foreground">{"Chuyen nhanh sang san khac"}</h3>
                    <div className="grid grid-cols-4 gap-2">
                      {Array.from({ length: 8 }, (_, i) => i + 1).map((id) => (
                        <Link
                          key={id}
                          href={`/san-va-gia/${id}`}
                          className={`flex items-center justify-center py-2.5 rounded-lg text-sm font-bold transition-all ${
                            id === court.id
                              ? "bg-[#065f46] text-white shadow-md"
                              : "bg-muted/50 text-foreground hover:bg-[#059669]/10 hover:text-[#059669]"
                          }`}
                        >
                          {`S${id}`}
                        </Link>
                      ))}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* Mobile CTA */}
        <div className="fixed bottom-0 left-0 right-0 bg-white border-t border-border p-4 md:hidden z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">
          <div className="flex items-center gap-3">
            <div className="flex-1">
              <p className="text-xs text-muted-foreground">{"Gia tu"}</p>
              <p className="text-lg font-bold text-foreground">
                120.000d<span className="text-sm font-normal text-muted-foreground">/gio</span>
              </p>
            </div>
            <Link
              href="/dat-san"
              className="flex items-center gap-2 bg-[#065f46] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#065f46]/90 transition-all"
            >
              {"Dat San"}
              <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  )
}
