# Hướng dẫn tích hợp thanh toán MoMo và VNPay

## Cấu hình

### 1. MoMo Payment

Thêm vào file `.env`:

```env
# MoMo Payment Configuration (BẮT BUỘC)
MOMO_PARTNER_CODE=your_partner_code
MOMO_ACCESS_KEY=your_access_key
MOMO_SECRET_KEY=your_secret_key
MOMO_SANDBOX=true

# MoMo URLs (TÙY CHỌN - có thể để trống)
# Nếu để trống, hệ thống sẽ tự động dùng URL từ route
MOMO_RETURN_URL=https://yourdomain.com/payment/momo/return
MOMO_NOTIFY_URL=https://yourdomain.com/payment/momo/notify
```

**Giải thích:**
- **MOMO_RETURN_URL**: URL mà MoMo sẽ redirect user về sau khi thanh toán xong (có thể để trống, hệ thống tự động dùng route)
- **MOMO_NOTIFY_URL**: URL mà MoMo gọi server-to-server để thông báo kết quả thanh toán (có thể để trống, hệ thống tự động dùng route)

**Lưu ý:**
- Nếu test trên localhost: Có thể để trống 2 dòng này, hệ thống sẽ tự động dùng `http://localhost/payment/momo/return` và `http://localhost/payment/momo/notify`
- Nếu deploy lên server: Nên điền đầy đủ với domain thật (phải là HTTPS trong production)
- Trong dashboard MoMo, bạn cũng cần cấu hình IPN URL và Return URL tương ứng

**Cách lấy thông tin:**
1. Đăng ký tài khoản tại: https://developers.momo.vn/
2. Tạo app và lấy Partner Code, Access Key, Secret Key
3. Cấu hình IPN URL và Return URL trong dashboard

### 2. VNPay Payment

Thêm vào file `.env`:

```env
# VNPay Payment Configuration
VNPAY_TMN_CODE=your_tmn_code
VNPAY_HASH_SECRET=your_hash_secret
VNPAY_SANDBOX=true
VNPAY_RETURN_URL=https://yourdomain.com/payment/vnpay/return
```

**Cách lấy thông tin:**
1. Đăng ký tài khoản tại: https://sandbox.vnpayment.vn/
2. Lấy TMN Code và Hash Secret từ dashboard
3. Cấu hình Return URL

## Chế độ hoạt động

### Chế độ giả lập (Mặc định)
- Nếu không có API keys trong `.env`, hệ thống sẽ sử dụng trang thanh toán giả lập
- Phù hợp cho development và testing

### Chế độ thật
- Khi đã cấu hình đầy đủ API keys, hệ thống sẽ tự động redirect đến MoMo/VNPay thật
- Sau khi thanh toán, user sẽ được redirect về website và tự động đăng ký khóa học

## Lưu ý

1. **Sandbox vs Production:**
   - `MOMO_SANDBOX=true` hoặc `VNPAY_SANDBOX=true`: Sử dụng môi trường test
   - `MOMO_SANDBOX=false` hoặc `VNPAY_SANDBOX=false`: Sử dụng môi trường production

2. **Return URL và Notify URL:**
   - Phải là HTTPS trong production
   - Phải được cấu hình trong dashboard của MoMo/VNPay
   - Return URL: User được redirect về sau khi thanh toán
   - Notify URL (MoMo): Server-to-server callback

3. **Testing:**
   - Sử dụng thẻ test từ MoMo/VNPay để test thanh toán
   - Kiểm tra logs trong `storage/logs/laravel.log` để debug

