QuanLySanCauLongNienThieu - Frontend Monorepo

Cấu trúc
- frontend/customer: FE dành cho khách hàng (Vue 3 + TSX + Vite)
- frontend/admin: FE dành cho admin (Vue 3 + TSX + Vite)

Build output
- customer build ra: public/frontend/customer
- admin build ra: public/frontend/admin

Chạy dev
1) Customer
   cd frontend/customer
   npm i
   npm run dev
   -> http://localhost:5173

2) Admin
   cd frontend/admin
   npm i
   npm run dev
   -> http://localhost:5174

Build production
- Customer: cd frontend/customer && npm run build
- Admin: cd frontend/admin && npm run build

Truy cập sau khi build (thông qua Laravel public/)
- Customer: /frontend/customer/
- Admin: /frontend/admin/

Ghi chú chuyển đổi từ Blade PHP sang TSX
- Các view Blade ở platform/themes/quanlysancaulong/views sẽ dần được chuyển thành trang Vue TSX.
- Ví dụ: index.blade.php -> frontend/customer/src/pages/Home.tsx (đã tạo tương đương)
- Các helper PHP như theme_option(...) sẽ được thay thế bằng dữ liệu lấy từ API backend (cần bổ sung endpoint).

