# Elearning — Hướng Dẫn Sử Dụng / Chạy Chương Trình / Test
Link Github: https://github.com/vietkel05x-code/Elearning
Tài liệu này giúp bạn cài đặt, chạy và kiểm thử nhanh ứng dụng trên Windows (PowerShell 5.1).
## Yêu cầu môi trường
- PHP 8.1+
- Composer 2.x
- Node.js 18+ và npm 8+
- MySQL/MariaDB (hoặc một DB tương thích mà Laravel hỗ trợ)
**Chi tiết:
	Tải và cài đặt Laragon: 	https://laragon.org/download
	Mở laragon, nhấn mở apache và mysql
	Thiết lập phpmyadmin: Chuột phải>tools>quick add>mysql 8.4, sau đó mở phpmyadmin và đăng nhập, Import file elearning.sql 
## Thiết lập dự án lần đầu
1) Cài dependencies PHP và JS
```powershell
composer install
npm install
```

2) Tạo file cấu hình `.env` và key ứng dụng
```powershell
Copy-Item .env.example .env
php artisan key:generate
```

3) Cấu hình kết nối CSDL trong `.env`
- Sửa các biến `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` theo máy bạn.

4) Chạy migration và seed (nếu có)
```powershell
php artisan migrate
# Tuỳ chọn: nếu có seeder
# php artisan db:seed
```

5) Tạo symbolic link cho storage (ảnh, file tĩnh do app sinh ra)
```powershell
php artisan storage:link
```

6) Build assets (Vite)
- Dev (watch):
```powershell
npm run dev
```
- Production build:
```powershell
npm run build
```

## Chạy ứng dụng
1) Khởi động server Laravel
```powershell
php artisan serve
```
- Mặc định truy cập: `http://127.0.0.1:8000`

2) (Tuỳ chọn) Khởi chạy queue worker nếu bạn dùng các tác vụ nền (thông báo, chuyển video, v.v.)
```powershell
php artisan queue:work
```

## Tài khoản & phân quyền
- Người dùng frontend: đăng ký tại `http://127.0.0.1:8000/register`.
- Tài khoản admin / quản lý khóa học: đăng nhập tại `http://127.0.0.1:8000/admin/login`.
- Nếu cần tạo admin thủ công:
```powershell
php artisan tinker
```
Trong Tinker:
```php
$user = \App\Models\User::where('email', 'you@example.com')->first();
$user->role = 'admin';
$user->save();
```

## Mô phỏng thanh toán
- Hệ thống hỗ trợ gateway MoMo/VNPay. Nếu chưa cấu hình API keys, `PaymentController@gateway` sẽ tự chuyển sang trang giả lập thanh toán.
- Quy trình test thanh toán (giả lập):
  1. Thêm khoá học vào giỏ → vào trang `Checkout`.
  2. Chọn phương thức (momo/vnpay/bank_transfer) → tiếp tục.
  3. Với momo/vnpay (giả lập): từ trang gateway giả lập → bấm thanh toán thành công.
  4. Kiểm tra `Orders` và truy cập học tập.

## Hướng dẫn sử dụng nhanh theo Use Case
- UC1 — Xác thực: Đăng ký/Đăng nhập/Đăng xuất từ menu (hoặc `/login`, `/register`).
- UC2 — Khám phá khoá học: `/courses` (lọc, sắp xếp), xem chi tiết `/courses/{slug}`.
- UC3 — Ghi danh & Đơn hàng: thêm vào giỏ, vào `/checkout`, thanh toán (giả lập), xem `/orders`.
- UC4 — Học tập: `/my-courses` → vào `/learn/{course}` → chọn bài, đánh dấu hoàn thành.
- UC5 — Hỏi đáp: `/courses/{course}/questions` → tạo câu hỏi, xem/đánh dấu giải quyết.
- UC6 — Quản trị Khoá học: `/admin/courses` CRUD, sections/lessons, review moderation.
- UC7 — Quản trị Người dùng: `/admin/users` CRUD.
- UC8 — Mã giảm giá: `/admin/coupons` CRUD; áp dụng ở `/checkout`.
- UC9 — Thông báo: người dùng `/notifications`; admin `/admin/notifications`.
- UC10 — Danh mục: `/admin/categories` CRUD (chặn xoá khi có khoá học/con).
- UC11 — Thống kê: `/admin/statistics/revenue|courses|students`.

## Kiểm thử (Test) dự án
1) Chạy PHPUnit/Laravel Test
```powershell
php artisan test
# hoặc
vendor/bin/phpunit
```

2) Smoke test theo chức năng (thủ công)
- UC1: Đăng ký/đăng nhập/đăng xuất → thấy redirect đúng.
- UC2: Tìm kiếm khoá học, lọc theo danh mục → danh sách cập nhật.
- UC3: Thêm giỏ/checkout → thanh toán giả lập → đơn hàng `paid`, user được ghi danh.
- UC4: Vào bài học → đánh dấu hoàn thành → sidebar cập nhật tiến độ.
- UC5: Tạo câu hỏi → chọn câu trả lời tốt nhất → trạng thái thay đổi.
- UC6–UC10: CRUD admin (khóa học, danh mục, mã giảm giá, người dùng, thông báo) → mỗi thao tác có flash message, DB cập nhật.
- UC11: Vào trang thống kê → thấy biểu đồ/số liệu theo khoảng thời gian.

## Sự cố thường gặp
- Không truy cập được `/admin/*`: đảm bảo tài khoản có `role = 'admin'`.
- Lỗi DB/migration: kiểm tra cấu hình `.env`, quyền user DB, đã tạo database chưa.
- Assets không tải: chạy `npm run dev` hoặc `npm run build`; kiểm tra `vite.config.js`.
- Ảnh/storage không hiển thị: đảm bảo đã `php artisan storage:link`.

