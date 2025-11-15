# Hướng dẫn cài đặt để tự động tính thời lượng video

## Vấn đề
Hệ thống cần công cụ để tự động tính thời lượng (duration) của video file. Hiện tại có 3 phương pháp:

## Phương pháp 1: FFprobe (Khuyến nghị - Chính xác nhất)

### Windows:
1. Tải FFmpeg từ: https://www.gyan.dev/ffmpeg/builds/
2. Giải nén vào thư mục (ví dụ: `C:\ffmpeg`)
3. Thêm vào PATH:
   - Mở "Environment Variables"
   - Thêm `C:\ffmpeg\bin` vào PATH
4. Khởi động lại terminal và test:
   ```bash
   ffprobe -version
   ```

### Linux/Mac:
```bash
# Ubuntu/Debian
sudo apt-get install ffmpeg

# Mac (với Homebrew)
brew install ffmpeg
```

## Phương pháp 2: getID3 Library (PHP)

Cài đặt qua Composer:
```bash
composer require james-heinrich/getid3
```

## Phương pháp 3: Nhập thủ công

Nếu không cài đặt công cụ nào, bạn có thể:
- Nhập thời lượng thủ công trong form
- Hoặc để mặc định 0 (sẽ không ảnh hưởng đến chức năng)

## Kiểm tra

Sau khi cài đặt, upload một video file và kiểm tra log:
```bash
tail -f storage/logs/laravel.log
```

Bạn sẽ thấy log như:
- "Duration calculated via ffprobe" - Nếu dùng ffprobe
- "Duration calculated via getID3" - Nếu dùng getID3
- "Could not calculate video duration" - Nếu không tính được

## Lưu ý

- Với video URL (YouTube, Vimeo): Không thể tự động tính, cần nhập thủ công
- Duration được tính bằng **phút** (minutes)
- Nếu không tính được, mặc định là 0 (không gây lỗi)



