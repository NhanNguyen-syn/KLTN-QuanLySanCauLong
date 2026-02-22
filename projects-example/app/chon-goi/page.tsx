import { Navigation } from "@/components/navigation"
import { Footer } from "@/components/footer"
import { PageHeader } from "@/components/page-header"
import { SelectionForm } from "./form"

export const metadata = {
  title: "Chọn Gói Đặt Sân - BadmintonPro",
  description: "Chọn loại khách hàng phù hợp với nhu cầu của bạn",
}

export default function PackageSelectionPage() {
  return (
    <div className="min-h-screen flex flex-col bg-background">
      <Navigation />

      <main className="flex-1">
        <PageHeader
          title="Chọn Loại Khách Hàng"
          description="Chọn loại khách hàng phù hợp và bắt đầu đặt sân với hình thức đặt khung giờ cố định và theo ngày"
        />

        <SelectionForm />
      </main>

      <Footer />
    </div>
  )
}
