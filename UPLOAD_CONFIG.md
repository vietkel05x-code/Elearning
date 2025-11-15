# Cấu hình Upload File Lớn (Hỗ trợ 1.3GB)

## Vấn đề
Khi upload file video hoặc tài liệu lớn (lên đến 1.3GB), bạn có thể gặp lỗi "The POST data is too large".

## Giải pháp

### 1. Cấu hình PHP (php.ini)

Tìm file `php.ini` (thường ở `C:\xampp\php\php.ini` hoặc `C:\wamp\bin\php\php8.x\php.ini`) và chỉnh sửa:

```ini
upload_max_filesize = 1500M
post_max_size = 1500M
max_execution_time = 3600
max_input_time = 3600
memory_limit = 2048M
```

**Lưu ý:** 
- `post_max_size` phải lớn hơn hoặc bằng `upload_max_filesize`
- Cấu hình này hỗ trợ upload file lên đến **1.3GB**
- `max_execution_time` được tăng lên 3600 giây (1 giờ) để xử lý file lớn

Sau khi chỉnh sửa, khởi động lại web server (Apache/Nginx).

### 2. Sử dụng .htaccess (Apache)

Nếu dùng Apache, file `.htaccess` đã được tạo trong project root. Đảm bảo Apache cho phép override PHP values:

Trong `httpd.conf` hoặc virtual host config:
```apache
AllowOverride All
```

### 3. Sử dụng .user.ini (PHP-FPM/CGI)

Nếu dùng PHP-FPM hoặc CGI, tạo file `.user.ini` trong project root với nội dung:

```ini
upload_max_filesize = 1500M
post_max_size = 1500M
max_execution_time = 3600
max_input_time = 3600
memory_limit = 2048M
```

### 4. Kiểm tra cấu hình hiện tại

Chạy lệnh:
```bash
php -i | findstr /i "upload_max_filesize post_max_size"
```

Hoặc tạo file `phpinfo.php`:
```php
<?php phpinfo(); ?>
```

Truy cập `http://localhost/phpinfo.php` để xem cấu hình hiện tại.

### 5. Giới hạn trong Laravel

Hiện tại, giới hạn upload trong code:
- Video: **1.3GB** (1331200 KB)
- Attachment: **1.3GB** (1331200 KB)

Cấu hình này đã được thiết lập trong:
- `app/Http/Controllers/Admin/LessonController.php`

### 6. Nginx Configuration

Nếu dùng Nginx, thêm vào server block:

```nginx
client_max_body_size 1500M;
client_body_timeout 3600s;
```

## Kiểm tra sau khi cấu hình

1. Khởi động lại web server
2. Kiểm tra lại bằng `phpinfo()` hoặc `php -i`
3. Thử upload file lớn lại

