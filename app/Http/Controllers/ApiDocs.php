<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "KLTN Quan Ly San Cau Long API",
    description: "API documentation for Court Booking Management System"
)]
#[OA\Contact(
    email: "admin@example.com"
)]
#[OA\Server(
    url: "http://kltn-quan-ly-san-cau-long.test",
    description: "Development Server (Laragon)"
)]
#[OA\Tag(name: "Courts", description: "API quản lý sân cầu lông")]
#[OA\Tag(name: "Availability", description: "API kiểm tra lịch trống")]
#[OA\Tag(name: "Bookings", description: "API đặt sân")]
#[OA\Tag(name: "Lookup", description: "API tra cứu đơn hàng")]
#[OA\Tag(name: "Blog", description: "API quản lý bài viết")]
#[OA\Tag(name: "Pages", description: "API quản lý trang")]
class ApiDocs extends Controller
{
    // =====================
    // COURTS API
    // =====================

    #[OA\Get(
        path: "/api/court-booking/courts",
        tags: ["Courts"],
        summary: "Lấy danh sách tất cả sân",
        description: "Trả về danh sách tất cả các sân cầu lông đang hoạt động"
    )]
    #[OA\Response(
        response: 200,
        description: "Thành công",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "data", type: "array", items: new OA\Items(
                    properties: [
                        new OA\Property(property: "id", type: "string", example: "1"),
                        new OA\Property(property: "name", type: "string", example: "Sân 1"),
                        new OA\Property(property: "price", type: "integer", example: 150000),
                        new OA\Property(property: "memberPrice", type: "integer", example: 120000),
                        new OA\Property(property: "type", type: "string", example: "Sân tiêu chuẩn"),
                        new OA\Property(property: "status", type: "string", example: "published"),
                    ]
                ))
            ]
        )
    )]
    public function courts() {}

    #[OA\Post(
        path: "/api/court-booking/courts",
        tags: ["Courts"],
        summary: "Tạo sân mới (Admin)",
        description: "Tạo một sân cầu lông mới. Cần quyền admin."
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Sân 5"),
                new OA\Property(property: "court_type_id", type: "integer", nullable: true, example: 1),
                new OA\Property(property: "status_id", type: "integer", nullable: true, example: 1),
                new OA\Property(property: "location", type: "string", nullable: true, example: "Tầng 2"),
                new OA\Property(property: "note", type: "string", nullable: true, example: "Sân VIP"),
                new OA\Property(property: "order", type: "integer", nullable: true, example: 5),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft"], example: "published"),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Tạo thành công")]
    #[OA\Response(response: 401, description: "Chưa xác thực")]
    #[OA\Response(response: 422, description: "Validation error")]
    public function createCourt() {}

    #[OA\Put(
        path: "/api/court-booking/courts/{id}",
        tags: ["Courts"],
        summary: "Cập nhật sân (Admin)",
        description: "Cập nhật thông tin sân. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của sân",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", example: "Sân 1 - VIP"),
                new OA\Property(property: "court_type_id", type: "integer", nullable: true, example: 1),
                new OA\Property(property: "status_id", type: "integer", nullable: true, example: 1),
                new OA\Property(property: "location", type: "string", nullable: true),
                new OA\Property(property: "note", type: "string", nullable: true),
                new OA\Property(property: "order", type: "integer", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft"]),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Cập nhật thành công")]
    #[OA\Response(response: 401, description: "Chưa xác thực")]
    #[OA\Response(response: 404, description: "Không tìm thấy sân")]
    public function updateCourt() {}

    #[OA\Delete(
        path: "/api/court-booking/courts/{id}",
        tags: ["Courts"],
        summary: "Xóa sân (Admin)",
        description: "Xóa một sân khỏi hệ thống. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của sân",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Xóa thành công")]
    #[OA\Response(response: 401, description: "Chưa xác thực")]
    #[OA\Response(response: 404, description: "Không tìm thấy sân")]
    public function deleteCourt() {}

    // =====================
    // AVAILABILITY API
    // =====================

    #[OA\Get(
        path: "/api/court-booking/availability",
        tags: ["Availability"],
        summary: "Lấy lịch trống theo ngày",
        description: "Trả về danh sách các slot thời gian và trạng thái (available/booked) cho tất cả các sân trong ngày được chọn"
    )]
    #[OA\Parameter(
        name: "date",
        in: "query",
        required: true,
        description: "Ngày cần kiểm tra (format: YYYY-MM-DD)",
        schema: new OA\Schema(type: "string", format: "date", example: "2026-01-20")
    )]
    #[OA\Response(
        response: 200,
        description: "Thành công",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "data", type: "array", items: new OA\Items(
                    properties: [
                        new OA\Property(property: "court_id", type: "integer", example: 1),
                        new OA\Property(property: "date", type: "string", example: "2026-01-20"),
                        new OA\Property(property: "start_time", type: "string", example: "08:00"),
                        new OA\Property(property: "end_time", type: "string", example: "08:30"),
                        new OA\Property(property: "status", type: "string", enum: ["available", "booked"], example: "available"),
                    ]
                ))
            ]
        )
    )]
    public function availability() {}

    // =====================
    // BOOKING APIs
    // =====================

    #[OA\Post(
        path: "/api/court-booking/bookings/hold",
        tags: ["Bookings"],
        summary: "Giữ chỗ (Hold) các slot",
        description: "Giữ tạm các slot trước khi thanh toán. TTL mặc định 15 phút."
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["slot_ids"],
            properties: [
                new OA\Property(property: "slot_ids", type: "array", items: new OA\Items(type: "integer"), example: [1, 2, 3]),
                new OA\Property(property: "user_id", type: "integer", nullable: true, example: 1),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Giữ chỗ thành công",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "booking", type: "object"),
            ]
        )
    )]
    #[OA\Response(response: 422, description: "Validation error hoặc slot đã bị đặt")]
    public function holdBooking() {}

    #[OA\Post(
        path: "/api/court-booking/bookings/{id}/pay",
        tags: ["Bookings"],
        summary: "Thanh toán booking",
        description: "Xác nhận thanh toán cho booking đã hold"
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của booking",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["provider", "amount"],
            properties: [
                new OA\Property(property: "provider", type: "string", enum: ["vnpay", "momo"], example: "vnpay"),
                new OA\Property(property: "amount", type: "number", example: 300000),
                new OA\Property(property: "meta", type: "object", nullable: true),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Thanh toán thành công")]
    #[OA\Response(response: 422, description: "Lỗi thanh toán")]
    public function payBooking() {}

    #[OA\Post(
        path: "/api/court-booking/bookings/{id}/cancel",
        tags: ["Bookings"],
        summary: "Hủy booking",
        description: "Hủy booking đang ở trạng thái pending"
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của booking",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Hủy thành công")]
    public function cancelBooking() {}

    #[OA\Get(
        path: "/api/court-booking/bookings/{id}",
        tags: ["Bookings"],
        summary: "Xem chi tiết booking",
        description: "Lấy thông tin chi tiết của một booking"
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của booking",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    #[OA\Response(response: 404, description: "Không tìm thấy booking")]
    public function showBooking() {}

    #[OA\Post(
        path: "/api/court-booking/booking-list",
        tags: ["Bookings"],
        summary: "Tạo đơn đặt sân mới",
        description: "Lưu thông tin đặt sân sau khi xác nhận (thông tin khách hàng, slots đã chọn)"
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["customer_name", "contact", "slots"],
            properties: [
                new OA\Property(property: "customer_name", type: "string", example: "Nguyễn Văn A"),
                new OA\Property(property: "contact", type: "string", example: "0901234567"),
                new OA\Property(property: "notes", type: "string", nullable: true, example: "Ghi chú đặc biệt"),
                new OA\Property(property: "slots", type: "array", items: new OA\Items(
                    properties: [
                        new OA\Property(property: "court_id", type: "integer", example: 1),
                        new OA\Property(property: "court_name", type: "string", example: "Sân 1"),
                        new OA\Property(property: "date", type: "string", example: "2026-01-20"),
                        new OA\Property(property: "start_time", type: "string", example: "08:00"),
                        new OA\Property(property: "end_time", type: "string", example: "08:30"),
                        new OA\Property(property: "price", type: "number", example: 150000),
                    ]
                )),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Tạo đơn thành công",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "order_code", type: "string", example: "BD-20260120-001"),
            ]
        )
    )]
    #[OA\Response(response: 422, description: "Validation error")]
    public function storeBookingList() {}

    #[OA\Get(
        path: "/api/court-booking/lookup",
        tags: ["Lookup"],
        summary: "Tra cứu đơn hàng theo mã",
        description: "Tra cứu thông tin đơn đặt sân bằng mã đơn hàng (order_code)"
    )]
    #[OA\Parameter(
        name: "order_code",
        in: "query",
        required: true,
        description: "Mã đơn hàng (VD: BD-20260120-001)",
        schema: new OA\Schema(type: "string", example: "BD-20260120-001")
    )]
    #[OA\Response(
        response: 200,
        description: "Tìm thấy đơn hàng",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "success", type: "boolean", example: true),
                new OA\Property(property: "data", type: "object", properties: [
                    new OA\Property(property: "order_code", type: "string"),
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "customer_name", type: "string"),
                    new OA\Property(property: "contact", type: "string"),
                    new OA\Property(property: "total_price", type: "number"),
                    new OA\Property(property: "items", type: "array", items: new OA\Items(type: "object")),
                ]),
            ]
        )
    )]
    #[OA\Response(response: 404, description: "Không tìm thấy đơn hàng")]
    #[OA\Response(response: 422, description: "Thiếu mã đơn hàng")]
    public function lookup() {}

    // =====================
    // BOOKING MANAGEMENT (Admin)
    // =====================

    #[OA\Put(
        path: "/api/court-booking/booking-list/{orderCode}",
        tags: ["Bookings"],
        summary: "Cập nhật đơn đặt sân (Admin)",
        description: "Cập nhật trạng thái, tiền cọc, ghi chú cho đơn. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "orderCode",
        in: "path",
        required: true,
        description: "Mã đơn hàng",
        schema: new OA\Schema(type: "string", example: "BD-20260120-001")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "status", type: "string", enum: ["pending", "processing", "paid", "completed", "cancelled"], nullable: true, example: "paid"),
                new OA\Property(property: "paid_amount_total", type: "number", nullable: true, example: 300000, description: "Tổng tiền đã thanh toán (phân bổ tự động cho các slot)"),
                new OA\Property(property: "notes", type: "string", nullable: true, example: "Khách VIP"),
                new OA\Property(property: "apply_to_order", type: "boolean", nullable: true, example: true),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Cập nhật thành công")]
    #[OA\Response(response: 401, description: "Chưa xác thực")]
    #[OA\Response(response: 404, description: "Không tìm thấy đơn")]
    public function updateBookingList() {}

    #[OA\Delete(
        path: "/api/court-booking/booking-list/{orderCode}",
        tags: ["Bookings"],
        summary: "Xóa đơn đặt sân (Admin)",
        description: "Xóa toàn bộ đơn theo mã. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "orderCode",
        in: "path",
        required: true,
        description: "Mã đơn hàng",
        schema: new OA\Schema(type: "string", example: "BD-20260120-001")
    )]
    #[OA\Response(response: 200, description: "Xóa thành công")]
    #[OA\Response(response: 401, description: "Chưa xác thực")]
    #[OA\Response(response: 404, description: "Không tìm thấy đơn")]
    public function deleteBookingList() {}

    // =====================
    // BLOG APIs
    // =====================

    #[OA\Get(
        path: "/api/v1/posts",
        tags: ["Blog"],
        summary: "Danh sách bài viết",
        description: "Lấy danh sách tất cả bài viết đã xuất bản"
    )]
    #[OA\Parameter(
        name: "per_page",
        in: "query",
        required: false,
        description: "Số lượng item trên mỗi trang (mặc định: 10)",
        schema: new OA\Schema(type: "integer", example: 10)
    )]
    #[OA\Parameter(
        name: "page",
        in: "query",
        required: false,
        description: "Số trang hiện tại (mặc định: 1)",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    public function blogPosts() {}

    #[OA\Get(
        path: "/api/v1/posts/{slug}",
        tags: ["Blog"],
        summary: "Chi tiết bài viết",
        description: "Lấy thông tin chi tiết bài viết theo slug"
    )]
    #[OA\Parameter(
        name: "slug",
        in: "path",
        required: true,
        description: "Slug của bài viết",
        schema: new OA\Schema(type: "string", example: "sample-post")
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    #[OA\Response(response: 404, description: "Không tìm thấy bài viết")]
    public function blogPostDetail() {}

    #[OA\Get(
        path: "/api/v1/search",
        tags: ["Blog"],
        summary: "Tìm kiếm bài viết",
        description: "Tìm kiếm bài viết theo từ khóa"
    )]
    #[OA\Parameter(
        name: "q",
        in: "query",
        required: true,
        description: "Từ khóa tìm kiếm",
        schema: new OA\Schema(type: "string", example: "cầu lông")
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    #[OA\Response(response: 400, description: "Không tìm thấy kết quả")]
    public function blogSearch() {}

    #[OA\Get(
        path: "/api/v1/categories",
        tags: ["Blog"],
        summary: "Danh sách danh mục",
        description: "Lấy danh sách tất cả danh mục bài viết"
    )]
    #[OA\Parameter(
        name: "per_page",
        in: "query",
        required: false,
        description: "Số lượng item trên mỗi trang",
        schema: new OA\Schema(type: "integer", example: 10)
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    public function blogCategories() {}

    #[OA\Get(
        path: "/api/v1/categories/{slug}",
        tags: ["Blog"],
        summary: "Chi tiết danh mục",
        description: "Lấy thông tin chi tiết danh mục theo slug"
    )]
    #[OA\Parameter(
        name: "slug",
        in: "path",
        required: true,
        description: "Slug của danh mục",
        schema: new OA\Schema(type: "string", example: "tin-tuc")
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    #[OA\Response(response: 404, description: "Không tìm thấy danh mục")]
    public function blogCategoryDetail() {}

    #[OA\Get(
        path: "/api/v1/tags",
        tags: ["Blog"],
        summary: "Danh sách thẻ tag",
        description: "Lấy danh sách tất cả các tag"
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    public function blogTags() {}

    // =====================
    // BLOG MANAGEMENT (Admin)
    // =====================

    #[OA\Post(
        path: "/api/v1/posts",
        tags: ["Blog"],
        summary: "Tạo bài viết mới (Admin)",
        description: "Tạo bài viết mới. Cần quyền admin."
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Bài viết mới"),
                new OA\Property(property: "description", type: "string", nullable: true, example: "Mô tả ngắn"),
                new OA\Property(property: "content", type: "string", nullable: true, example: "Nội dung chi tiết"),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft", "pending"], nullable: true, example: "published"),
                new OA\Property(property: "image", type: "string", nullable: true),
                new OA\Property(property: "categories", type: "array", items: new OA\Items(type: "integer"), nullable: true, example: [1, 2]),
                new OA\Property(property: "tags", type: "array", items: new OA\Items(type: "integer"), nullable: true, example: [1, 2]),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Tạo thành công")]
    #[OA\Response(response: 401, description: "Chưa xác thực")]
    public function createPost() {}

    #[OA\Put(
        path: "/api/v1/posts/{id}",
        tags: ["Blog"],
        summary: "Cập nhật bài viết (Admin)",
        description: "Cập nhật thông tin bài viết. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của bài viết",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", nullable: true),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "content", type: "string", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft", "pending"], nullable: true),
                new OA\Property(property: "image", type: "string", nullable: true),
                new OA\Property(property: "categories", type: "array", items: new OA\Items(type: "integer"), nullable: true),
                new OA\Property(property: "tags", type: "array", items: new OA\Items(type: "integer"), nullable: true),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Cập nhật thành công")]
    public function updateBlogPost() {}

    #[OA\Delete(
        path: "/api/v1/posts/{id}",
        tags: ["Blog"],
        summary: "Xóa bài viết (Admin)",
        description: "Xóa bài viết. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của bài viết",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Xóa thành công")]
    public function deleteBlogPost() {}

    #[OA\Post(
        path: "/api/v1/categories",
        tags: ["Blog"],
        summary: "Tạo danh mục mới (Admin)",
        description: "Tạo danh mục bài viết mới. Cần quyền admin."
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Tin tức"),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft"], nullable: true),
                new OA\Property(property: "parent_id", type: "integer", nullable: true, description: "ID danh mục cha"),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Tạo thành công")]
    public function createCategory() {}

    #[OA\Put(
        path: "/api/v1/categories/{id}",
        tags: ["Blog"],
        summary: "Cập nhật danh mục (Admin)",
        description: "Cập nhật thông tin danh mục. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", nullable: true),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft"], nullable: true),
                new OA\Property(property: "parent_id", type: "integer", nullable: true),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Cập nhật thành công")]
    public function updateBlogCategory() {}

    #[OA\Delete(
        path: "/api/v1/categories/{id}",
        tags: ["Blog"],
        summary: "Xóa danh mục (Admin)",
        description: "Xóa danh mục. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Xóa thành công")]
    public function deleteBlogCategory() {}

    #[OA\Post(
        path: "/api/v1/tags",
        tags: ["Blog"],
        summary: "Tạo tag mới (Admin)",
        description: "Tạo tag mới. Cần quyền admin."
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Cầu lông"),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft"], nullable: true),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Tạo thành công")]
    public function createTag() {}

    #[OA\Put(
        path: "/api/v1/tags/{id}",
        tags: ["Blog"],
        summary: "Cập nhật tag (Admin)",
        description: "Cập nhật thông tin tag. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", nullable: true),
                new OA\Property(property: "description", type: "string", nullable: true),
                new OA\Property(property: "status", type: "string", enum: ["published", "draft"], nullable: true),
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Cập nhật thành công")]
    public function updateBlogTag() {}

    #[OA\Delete(
        path: "/api/v1/tags/{id}",
        tags: ["Blog"],
        summary: "Xóa tag (Admin)",
        description: "Xóa tag. Cần quyền admin."
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Xóa thành công")]
    public function deleteBlogTag() {}

    // =====================
    // PAGES APIs
    // =====================

    #[OA\Get(
        path: "/api/v1/pages",
        tags: ["Pages"],
        summary: "Danh sách trang",
        description: "Lấy danh sách tất cả các trang đã xuất bản"
    )]
    #[OA\Parameter(
        name: "per_page",
        in: "query",
        required: false,
        description: "Số lượng item trên mỗi trang (mặc định: 10)",
        schema: new OA\Schema(type: "integer", example: 10)
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    public function pages() {}

    #[OA\Get(
        path: "/api/v1/pages/{id}",
        tags: ["Pages"],
        summary: "Chi tiết trang",
        description: "Lấy thông tin chi tiết trang theo ID"
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        description: "ID của trang",
        schema: new OA\Schema(type: "integer", example: 1)
    )]
    #[OA\Response(response: 200, description: "Thành công")]
    #[OA\Response(response: 404, description: "Không tìm thấy trang")]
    public function pageDetail() {}
}
