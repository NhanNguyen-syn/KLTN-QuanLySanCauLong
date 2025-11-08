Backend (PHP - Laravel)

Hiện tại toàn bộ mã nguồn backend Laravel đang ở thư mục gốc của dự án (cấu trúc chuẩn của Botble/Laravel).

Kế hoạch tách hẳn vào backend/ (đề xuất, cần bạn xác nhận):
1) Di chuyển toàn bộ file/folder ở root (app, bootstrap, config, database, public, resources, routes, vendor, ...) vào backend/
2) Cập nhật đường dẫn trong server (Laragon) để document_root trỏ tới backend/public
3) Kiểm tra và cập nhật script/build (nếu có), đường dẫn storage, symlink public/storage
4) Chạy lại composer install trong backend/ và verify .env

Lưu ý: Việc di chuyển này ảnh hưởng khá lớn, cần downtime ngắn và kiểm thử đầy đủ. Nếu bạn đồng ý, mình sẽ tạo checklist + script di chuyển an toàn.

Tích hợp với frontend (Vue TSX):
- Frontend build ra: public/frontend/customer và public/frontend/admin (đã cấu hình Vite)
- Có thể cấu hình route Laravel để render các SPA này, ví dụ:

  // routes/web.php (ví dụ route cho customer SPA)
  Route::get('/frontend/customer/{any?}', function () {
      return response()->file(public_path('frontend/customer/index.html'));
  })->where('any', '.*');

- Tương tự cho admin: /frontend/admin/{any?}

Chuyển Blade -> TSX:
- Các view Blade thuộc theme frontend sẽ được chuyển dần sang component/page Vue TSX và lấy dữ liệu qua API.
- Cần bổ sung các API trả về dữ liệu: theme_option, recent posts, v.v.

