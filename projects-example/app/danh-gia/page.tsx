"use client"

import type React from "react"
import { useState } from "react"
import {
  Star,
  ThumbsUp,
  MessageSquare,
  CheckCircle,
  Filter,
  ChevronLeft,
  ChevronRight,
  Upload,
  X,
  Reply,
  Send,
  Trash2,
} from "lucide-react"
import { Button } from "@/components/ui/button"
import { Textarea } from "@/components/ui/textarea"
import { Input } from "@/components/ui/input"
import Image from "next/image"

// Mock data đánh giá - giả sử user hiện tại là "Bạn" (id = 999)
const currentUserId = 999
const currentUserName = "Bạn"

const initialReviews = [
  {
    id: 1,
    name: "Nguyễn Văn A",
    rating: 5,
    date: "15/01/2025",
    comment: "Sân cầu lông rất tốt, sạch sẽ, ánh sáng đầy đủ. Nhân viên phục vụ nhiệt tình. Tôi sẽ quay lại!",
    helpful: 24,
    images: ["/badminton-court-clean.jpg"],
    replies: [
      {
        id: 1,
        name: "BadmintonPro Admin",
        date: "16/01/2025",
        comment: "Cảm ơn bạn đã đánh giá! Chúng tôi rất vui vì bạn hài lòng với dịch vụ.",
      },
    ],
  },
  {
    id: 2,
    name: "Trần Thị B",
    rating: 5,
    date: "12/01/2025",
    comment: "Đặt sân online rất tiện lợi, giá cả hợp lý. Sân chất lượng cao, phù hợp thi đấu.",
    helpful: 18,
    images: [],
    replies: [],
  },
  {
    id: 3,
    name: "Lê Văn C",
    rating: 4,
    date: "10/01/2025",
    comment: "Sân đẹp, thoáng mát. Dịch vụ tốt. Chỉ có điều bãi đỗ xe hơi hơi nhỏ vào giờ cao điểm.",
    helpful: 12,
    images: ["/badminton-court-spacious.jpg", "/busy-city-parking-lot.png"],
    replies: [],
  },
  {
    id: 4,
    name: "Phạm Thị D",
    rating: 5,
    date: "08/01/2025",
    comment: "Mình là thành viên cố định, rất hài lòng với chất lượng sân và ưu đãi đặc biệt. Recommend!",
    helpful: 32,
    images: [],
    replies: [],
  },
  {
    id: 5,
    name: "Hoàng Văn E",
    rating: 4,
    date: "05/01/2025",
    comment: "Sân tốt, giá ổn. Có thể cải thiện thêm về chỗ ngồi chờ cho người chơi.",
    helpful: 9,
    images: [],
    replies: [],
  },
  {
    id: 6,
    name: "Võ Thị F",
    rating: 5,
    date: "03/01/2025",
    comment: "Cơ sở vật chất hiện đại, nhân viên thân thiện. Giá thành viên rất ưu đãi!",
    helpful: 15,
    images: ["/modern-badminton-facility.jpg"],
    replies: [],
  },
  {
    id: 7,
    name: "Đỗ Văn G",
    rating: 3,
    date: "01/01/2025",
    comment: "Sân tạm ổn nhưng giờ cao điểm hơi đông, khó book được sân.",
    helpful: 5,
    images: [],
    replies: [],
  },
  {
    id: 8,
    name: "Ngô Thị H",
    rating: 5,
    date: "28/12/2024",
    comment: "Tuyệt vời! Đây là sân cầu lông tốt nhất mà tôi từng chơi. Ánh sáng chuẩn thi đấu.",
    helpful: 28,
    images: ["/professional-badminton-lighting.jpg", "/competition-court.jpg"],
    replies: [
      {
        id: 1,
        name: "BadmintonPro Admin",
        date: "29/12/2024",
        comment: "Cảm ơn bạn rất nhiều! Hy vọng được phục vụ bạn trong những lần tiếp theo.",
      },
    ],
  },
]

const allReviews = initialReviews; // Declare the allReviews variable

export default function DanhGiaPage() {
  const [rating, setRating] = useState(0)
  const [hoverRating, setHoverRating] = useState(0)
  const [name, setName] = useState("")
  const [comment, setComment] = useState("")
  const [submitted, setSubmitted] = useState(false)

  const [uploadedImages, setUploadedImages] = useState<string[]>([])

  const [currentPage, setCurrentPage] = useState(1)
  const [filterRating, setFilterRating] = useState<number | null>(null)
  const [sortBy, setSortBy] = useState<"newest" | "oldest" | "highest" | "lowest">("newest")

  const [replyingTo, setReplyingTo] = useState<number | null>(null)
  const [replyText, setReplyText] = useState("")

  // State để quản lý reviews (có thể thêm/xóa)
  const [reviews, setReviews] = useState(initialReviews)
  
  // State để track các review đã vote helpful
  const [helpfulVoted, setHelpfulVoted] = useState<number[]>([])

  const reviewsPerPage = 5

  const averageRating = reviews.length > 0 
    ? (reviews.reduce((sum, r) => sum + r.rating, 0) / reviews.length).toFixed(1) 
    : "0"
  const totalReviews = reviews.length

  let filteredReviews = [...reviews]

  if (filterRating !== null) {
    filteredReviews = filteredReviews.filter((r) => r.rating === filterRating)
  }

  filteredReviews.sort((a, b) => {
    switch (sortBy) {
      case "newest":
        return (
          new Date(b.date.split("/").reverse().join("-")).getTime() -
          new Date(a.date.split("/").reverse().join("-")).getTime()
        )
      case "oldest":
        return (
          new Date(a.date.split("/").reverse().join("-")).getTime() -
          new Date(b.date.split("/").reverse().join("-")).getTime()
        )
      case "highest":
        return b.rating - a.rating
      case "lowest":
        return a.rating - b.rating
      default:
        return 0
    }
  })

  const totalPages = Math.ceil(filteredReviews.length / reviewsPerPage)
  const startIndex = (currentPage - 1) * reviewsPerPage
  const endIndex = startIndex + reviewsPerPage
  const currentReviews = filteredReviews.slice(startIndex, endIndex)

  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const files = e.target.files
    if (files) {
      const newImages = Array.from(files).map((file) => URL.createObjectURL(file))
      setUploadedImages((prev) => [...prev, ...newImages].slice(0, 3)) // Tối đa 3 ảnh
    }
  }

  const removeImage = (index: number) => {
    setUploadedImages((prev) => prev.filter((_, i) => i !== index))
  }

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    if (rating > 0 && name && comment) {
      // Thêm đánh giá mới vào đầu danh sách
      const newReview = {
        id: Date.now(),
        name: name,
        rating: rating,
        date: new Date().toLocaleDateString('vi-VN'),
        comment: comment,
        helpful: 0,
        images: uploadedImages,
        replies: [],
        isOwner: true // Đánh dấu là của bản thân
      }
      setReviews(prev => [newReview, ...prev])
      
      setSubmitted(true)
      setTimeout(() => {
        setRating(0)
        setName("")
        setComment("")
        setUploadedImages([])
        setSubmitted(false)
      }, 3000)
    }
  }

  const handleReply = (reviewId: number) => {
    if (replyText.trim()) {
      // Thêm phản hồi vào review
      setReviews(prev => prev.map(review => {
        if (review.id === reviewId) {
          return {
            ...review,
            replies: [...review.replies, {
              id: Date.now(),
              name: currentUserName,
              date: new Date().toLocaleDateString('vi-VN'),
              comment: replyText,
              isOwner: true
            }]
          }
        }
        return review
      }))
      setReplyingTo(null)
      setReplyText("")
    }
  }

  // Xử lý toggle vote hữu ích (có thể like và unlike)
  const handleHelpful = (reviewId: number) => {
    const alreadyVoted = helpfulVoted.includes(reviewId)
    
    setReviews(prev => prev.map(review => {
      if (review.id === reviewId) {
        return { 
          ...review, 
          helpful: alreadyVoted ? review.helpful - 1 : review.helpful + 1 
        }
      }
      return review
    }))
    
    if (alreadyVoted) {
      // Bỏ vote
      setHelpfulVoted(prev => prev.filter(id => id !== reviewId))
    } else {
      // Thêm vote
      setHelpfulVoted(prev => [...prev, reviewId])
    }
  }

  // Xóa đánh giá của bản thân
  const handleDeleteReview = (reviewId: number) => {
    if (confirm('Bạn có chắc muốn xóa đánh giá này?')) {
      setReviews(prev => prev.filter(review => review.id !== reviewId))
    }
  }

  // Xóa phản hồi của bản thân
  const handleDeleteReply = (reviewId: number, replyId: number) => {
    if (confirm('Bạn có chắc muốn xóa phản hồi này?')) {
      setReviews(prev => prev.map(review => {
        if (review.id === reviewId) {
          return {
            ...review,
            replies: review.replies.filter(reply => reply.id !== replyId)
          }
        }
        return review
      }))
    }
  }

  const renderPaginationButtons = () => {
    const pages: (number | string)[] = []
    const maxVisiblePages = 5

    if (totalPages <= maxVisiblePages + 2) {
      // Nếu ít trang thì hiển thị tất cả
      for (let i = 1; i <= totalPages; i++) {
        pages.push(i)
      }
    } else {
      // Logic hiển thị với ellipsis
      if (currentPage <= 3) {
        // Đầu danh sách: 1 2 3 4 ... 10
        for (let i = 1; i <= 4; i++) {
          pages.push(i)
        }
        pages.push("...")
        pages.push(totalPages)
      } else if (currentPage >= totalPages - 2) {
        // Cuối danh sách: 1 ... 7 8 9 10
        pages.push(1)
        pages.push("...")
        for (let i = totalPages - 3; i <= totalPages; i++) {
          pages.push(i)
        }
      } else {
        // Giữa danh sách: 1 ... 4 5 6 ... 10
        pages.push(1)
        pages.push("...")
        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
          pages.push(i)
        }
        pages.push("...")
        pages.push(totalPages)
      }
    }

    return pages
  }

  return (
    <div className="min-h-screen bg-gradient-to-b from-[#f0fdf4] to-white">
      {/* Hero Section */}
      <section className="relative py-16 bg-gradient-to-r from-[#065f46] to-[#059669] text-white overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-3xl"></div>
          <div className="absolute bottom-10 right-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
        </div>
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">Đánh Giá & Nhận Xét</h1>
          <p className="text-lg text-emerald-100">Chia sẻ trải nghiệm của bạn và xem ý kiến từ cộng đồng</p>
        </div>
      </section>

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid lg:grid-cols-3 gap-8">
          {/* Left Column - Overview & Reviews */}
          <div className="lg:col-span-2 space-y-6">
            {/* Rating Overview */}
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
              <div className="flex items-center gap-8">
                <div className="text-center">
                  <div className="text-5xl font-bold text-[#065f46] mb-2">{averageRating}</div>
                  <div className="flex gap-1 mb-2">
                    {[1, 2, 3, 4, 5].map((star) => (
                      <Star
                        key={star}
                        className={`w-5 h-5 ${
                          star <= Math.round(averageRating) ? "fill-amber-400 text-amber-400" : "text-gray-300"
                        }`}
                      />
                    ))}
                  </div>
                  <p className="text-sm text-gray-600">{totalReviews} đánh giá</p>
                </div>
                <div className="flex-1">
                  {[5, 4, 3, 2, 1].map((star) => (
                    <div key={star} className="flex items-center gap-3 mb-2">
                      <span className="text-sm text-gray-600 w-12">{star} sao</span>
                      <div className="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div
                          className="h-full bg-gradient-to-r from-amber-400 to-amber-500"
                          style={{ width: `${star === 5 ? 80 : star === 4 ? 15 : 5}%` }}
                        />
                      </div>
                      <span className="text-sm text-gray-500 w-12 text-right">
                        {star === 5 ? "80%" : star === 4 ? "15%" : "5%"}
                      </span>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
              <div className="flex flex-wrap items-center gap-4">
                <div className="flex items-center gap-2">
                  <Filter className="w-5 h-5 text-[#059669]" />
                  <span className="font-medium text-gray-700">Bộ lọc:</span>
                </div>

                {/* Lọc theo sao */}
                <div className="flex gap-2">
                  <button
                    onClick={() => setFilterRating(null)}
                    className={`px-3 py-1 rounded-full text-sm transition-all ${
                      filterRating === null ? "bg-[#065f46] text-white" : "bg-gray-100 text-gray-600 hover:bg-gray-200"
                    }`}
                  >
                    Tất cả
                  </button>
                  {[5, 4, 3, 2, 1].map((star) => (
                    <button
                      key={star}
                      onClick={() => setFilterRating(star)}
                      className={`px-3 py-1 rounded-full text-sm flex items-center gap-1 transition-all ${
                        filterRating === star
                          ? "bg-[#065f46] text-white"
                          : "bg-gray-100 text-gray-600 hover:bg-gray-200"
                      }`}
                    >
                      {star} <Star className="w-3 h-3 fill-current" />
                    </button>
                  ))}
                </div>

                <div className="h-6 w-px bg-gray-300" />

                {/* Sắp xếp */}
                <select
                  value={sortBy}
                  onChange={(e) => setSortBy(e.target.value as any)}
                  className="px-3 py-1 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-[#059669]"
                >
                  <option value="newest">Mới nhất</option>
                  <option value="oldest">Cũ nhất</option>
                  <option value="highest">Đánh giá cao nhất</option>
                  <option value="lowest">Đánh giá thấp nhất</option>
                </select>
              </div>
            </div>

            {/* Reviews List */}
            <div className="space-y-4">
              <h2 className="text-2xl font-bold text-[#065f46] flex items-center gap-2">
                <MessageSquare className="w-6 h-6" />
                Nhận Xét Từ Khách Hàng ({filteredReviews.length})
              </h2>

              {currentReviews.map((review) => (
                <div
                  key={review.id}
                  className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow"
                >
                  <div className="flex items-start justify-between mb-3">
                    <div>
                      <h3 className="font-semibold text-[#065f46] mb-1">{review.name}</h3>
                      <div className="flex gap-1 mb-2">
                        {[1, 2, 3, 4, 5].map((star) => (
                          <Star
                            key={star}
                            className={`w-4 h-4 ${
                              star <= review.rating ? "fill-amber-400 text-amber-400" : "text-gray-300"
                            }`}
                          />
                        ))}
                      </div>
                    </div>
                    <span className="text-sm text-gray-500">{review.date}</span>
                  </div>

                  <p className="text-gray-700 leading-relaxed mb-4">{review.comment}</p>

                  {/* Hiển thị hình ảnh nếu có */}
                  {review.images.length > 0 && (
                    <div className="grid grid-cols-3 gap-2 mb-4">
                      {review.images.map((img, idx) => (
                        <div key={idx} className="relative h-32 rounded-lg overflow-hidden">
                          <Image
                            src={img || "/placeholder.svg"}
                            alt={`Review image ${idx + 1}`}
                            fill
                            className="object-cover hover:scale-110 transition-transform duration-300"
                          />
                        </div>
                      ))}
                    </div>
                  )}

                  <div className="flex items-center gap-4">
                    <button 
                      onClick={() => handleHelpful(review.id)}
                      className={`flex items-center gap-2 text-sm transition-all ${
                        helpfulVoted.includes(review.id) 
                          ? 'text-[#059669]' 
                          : 'text-gray-600 hover:text-[#059669]'
                      }`}
                    >
                      <ThumbsUp className={`w-4 h-4 transition-all duration-200 ${
                        helpfulVoted.includes(review.id) ? 'fill-[#059669] scale-110' : 'hover:scale-105'
                      }`} />
                      <span className={`transition-all ${helpfulVoted.includes(review.id) ? 'font-medium' : ''}`}>
                        Hữu ích ({review.helpful})
                      </span>
                    </button>

                    <button
                      onClick={() => setReplyingTo(replyingTo === review.id ? null : review.id)}
                      className="flex items-center gap-2 text-sm text-gray-600 hover:text-[#059669] transition-colors"
                    >
                      <Reply className="w-4 h-4" />
                      <span>Phản hồi</span>
                    </button>

                    {/* Nút xóa nếu là bài đánh giá của bản thân */}
                    {review.isOwner && (
                      <button
                        onClick={() => handleDeleteReview(review.id)}
                        className="flex items-center gap-2 text-sm text-gray-400 hover:text-red-500 transition-colors ml-auto"
                      >
                        <Trash2 className="w-4 h-4" />
                        <span>Xóa</span>
                      </button>
                    )}
                  </div>

                  {/* Form phản hồi */}
                  {replyingTo === review.id && (
                    <div className="mt-4 bg-gray-50 rounded-lg p-4">
                      <div className="flex gap-2">
                        <Input
                          value={replyText}
                          onChange={(e) => setReplyText(e.target.value)}
                          placeholder="Viết phản hồi..."
                          className="flex-1"
                        />
                        <Button
                          onClick={() => handleReply(review.id)}
                          size="sm"
                          className="bg-[#059669] hover:bg-[#065f46]"
                        >
                          <Send className="w-4 h-4" />
                        </Button>
                      </div>
                    </div>
                  )}

                  {/* Hiển thị phản hồi */}
                  {review.replies.length > 0 && (
                    <div className="mt-4 space-y-3">
                      {review.replies.map((reply) => (
                        <div key={reply.id} className="bg-emerald-50 rounded-lg p-4 ml-8 group">
                          <div className="flex items-start justify-between mb-2">
                            <div className="flex items-center gap-2">
                              <h4 className="font-semibold text-[#065f46] text-sm">{reply.name}</h4>
                              {reply.isOwner && (
                                <span className="text-xs bg-emerald-200 text-emerald-700 px-2 py-0.5 rounded-full">Bạn</span>
                              )}
                            </div>
                            <div className="flex items-center gap-2">
                              <span className="text-xs text-gray-500">{reply.date}</span>
                              {/* Nút xóa phản hồi nếu là của bản thân */}
                              {reply.isOwner && (
                                <button
                                  onClick={() => handleDeleteReply(review.id, reply.id)}
                                  className="opacity-0 group-hover:opacity-100 text-gray-400 hover:text-red-500 transition-all"
                                  title="Xóa phản hồi"
                                >
                                  <Trash2 className="w-3.5 h-3.5" />
                                </button>
                              )}
                            </div>
                          </div>
                          <p className="text-gray-700 text-sm">{reply.comment}</p>
                        </div>
                      ))}
                    </div>
                  )}
                </div>
              ))}

              {totalPages > 1 && (
                <div className="flex items-center justify-center gap-2 mt-8">
                  <button
                    onClick={() => setCurrentPage((prev) => Math.max(1, prev - 1))}
                    disabled={currentPage === 1}
                    className="p-2 rounded-lg border border-gray-300 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                  >
                    <ChevronLeft className="w-5 h-5" />
                  </button>

                  <div className="flex gap-2">
                    {renderPaginationButtons().map((page, index) => {
                      if (page === "...") {
                        return (
                          <span key={`ellipsis-${index}`} className="px-4 py-2 text-gray-400">
                            ...
                          </span>
                        )
                      }
                      return (
                        <button
                          key={page}
                          onClick={() => setCurrentPage(page as number)}
                          className={`px-4 py-2 rounded-lg font-medium transition-colors ${
                            currentPage === page
                              ? "bg-[#065f46] text-white"
                              : "bg-white border border-gray-300 text-gray-700 hover:bg-gray-50"
                          }`}
                        >
                          {page}
                        </button>
                      )
                    })}
                  </div>

                  <button
                    onClick={() => setCurrentPage((prev) => Math.min(totalPages, prev + 1))}
                    disabled={currentPage === totalPages}
                    className="p-2 rounded-lg border border-gray-300 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                  >
                    <ChevronRight className="w-5 h-5" />
                  </button>
                </div>
              )}
            </div>
          </div>

          {/* Right Column - Submit Review Form */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
              <h2 className="text-xl font-bold text-[#065f46] mb-6">Gửi Đánh Giá Của Bạn</h2>

              {submitted ? (
                <div className="text-center py-8">
                  <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <CheckCircle className="w-8 h-8 text-green-600" />
                  </div>
                  <h3 className="text-lg font-semibold text-[#065f46] mb-2">Cảm ơn bạn!</h3>
                  <p className="text-gray-600 text-sm">Đánh giá của bạn đã được gửi thành công</p>
                </div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-4">
                  {/* Star Rating */}
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Đánh giá của bạn</label>
                    <div className="flex gap-2">
                      {[1, 2, 3, 4, 5].map((star) => (
                        <button
                          key={star}
                          type="button"
                          onClick={() => setRating(star)}
                          onMouseEnter={() => setHoverRating(star)}
                          onMouseLeave={() => setHoverRating(0)}
                          className="focus:outline-none transition-transform hover:scale-110"
                        >
                          <Star
                            className={`w-8 h-8 ${
                              star <= (hoverRating || rating) ? "fill-amber-400 text-amber-400" : "text-gray-300"
                            }`}
                          />
                        </button>
                      ))}
                    </div>
                  </div>

                  {/* Name Input */}
                  <div>
                    <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                      Tên của bạn
                    </label>
                    <Input
                      id="name"
                      type="text"
                      value={name}
                      onChange={(e) => setName(e.target.value)}
                      placeholder="Nhập tên của bạn"
                      required
                      className="focus:ring-2 focus:ring-[#059669]"
                    />
                  </div>

                  {/* Comment Textarea */}
                  <div>
                    <label htmlFor="comment" className="block text-sm font-medium text-gray-700 mb-2">
                      Nhận xét
                    </label>
                    <Textarea
                      id="comment"
                      value={comment}
                      onChange={(e) => setComment(e.target.value)}
                      placeholder="Chia sẻ trải nghiệm của bạn..."
                      rows={5}
                      required
                      className="focus:ring-2 focus:ring-[#059669] resize-none"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Thêm hình ảnh (Tối đa 3 ảnh)</label>

                    {/* Preview uploaded images */}
                    {uploadedImages.length > 0 && (
                      <div className="grid grid-cols-3 gap-2 mb-3">
                        {uploadedImages.map((img, idx) => (
                          <div key={idx} className="relative group">
                            <img
                              src={img || "/placeholder.svg"}
                              alt={`Upload ${idx + 1}`}
                              className="w-full h-24 object-cover rounded-lg"
                            />
                            <button
                              type="button"
                              onClick={() => removeImage(idx)}
                              className="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                              <X className="w-3 h-3" />
                            </button>
                          </div>
                        ))}
                      </div>
                    )}

                    {uploadedImages.length < 3 && (
                      <label className="flex items-center justify-center gap-2 px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-[#059669] hover:bg-emerald-50 cursor-pointer transition-colors">
                        <Upload className="w-5 h-5 text-gray-500" />
                        <span className="text-sm text-gray-600">Chọn hình ảnh</span>
                        <input type="file" accept="image/*" multiple onChange={handleImageUpload} className="hidden" />
                      </label>
                    )}
                  </div>

                  {/* Submit Button */}
                  <Button
                    type="submit"
                    className="w-full bg-gradient-to-r from-[#065f46] to-[#059669] hover:from-[#059669] hover:to-[#10b981] text-white py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all"
                    disabled={rating === 0 || !name || !comment}
                  >
                    Gửi Đánh Giá
                  </Button>
                </form>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
