import type React from "react"
import type { Metadata } from "next"

import { Analytics } from "@vercel/analytics/next"
import "./globals.css"

import { Baloo_2, Libre_Baskerville } from "next/font/google"
import { AIChatbot } from "@/components/ai-chatbot"

// Initialize fonts
const baloo = Baloo_2({ subsets: ["latin"], weight: ["400", "500", "600"] })
const libreBaskerville = Libre_Baskerville({ subsets: ["latin"], weight: ["400", "700"] })

export const metadata: Metadata = {
  title: "BadmintonPro - Đặt Sân Cầu Lông Chuyên Nghiệp",
  description:
    "Hệ thống quản lý sân cầu lông chuyên nghiệp với 10 sân chuẩn quốc tế. Giá chuẩn: 150K vãng lai, 120K thường. Đặt sân chỉ 30 giây!",
  icons: {
    icon: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" fontSize="90" fontWeight="bold" fill="%23065f46">B</text></svg>',
  },
  generator: "v0.app",
}

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode
}>) {
  return (
    <html lang="vi">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
      </head>
      <body className={`${baloo.className} antialiased`}>
        {children}
        <AIChatbot />
        <Analytics />
      </body>
    </html>
  )
}
