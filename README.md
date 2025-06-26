# Web Marathon Project

Một ứng dụng quản lý marathon toàn diện trên nền tảng web được thiết kế dành cho học sinh và giáo viên tham gia các sự kiện marathon.

## 📝 Mô tả ngắn gọn

Hệ thống quản lý marathon trực tuyến cho phép học sinh và giáo viên đăng ký tham gia các sự kiện marathon, theo dõi kết quả và quản lý thông tin người tham gia.

## 📖 Giới thiệu chi tiết

Dự án này được phát triển để phục vụ việc tổ chức và quản lý các sự kiện marathon trong môi trường giáo dục. Hệ thống cung cấp một nền tảng tổng hợp cho phép:

- **Học sinh và giáo viên** có thể đăng ký tham gia các sự kiện marathon khác nhau
- **Ban tổ chức** quản lý thông tin người tham gia, cập nhật kết quả và theo dõi bảng xếp hạng
- **Cộng đồng** theo dõi kết quả thi đấu real-time

Đối tượng người dùng chính bao gồm học sinh, giáo viên, ban tổ chức sự kiện marathon trong các trường học và cơ sở giáo dục.

## ⭐ Tính năng nổi bật

### Dành cho Người tham gia (Học sinh & Giáo viên)
- 📋 Xem thông tin chi tiết các sự kiện marathon
- ✍️ Đăng ký tham gia trực tuyến với form validation
- 📊 Theo dõi kết quả cá nhân và bảng xếp hạng
- 🗺️ Xem lịch trình và bản đồ đường chạy

### Dành cho Ban tổ chức
- 📊 Dashboard quản trị viên để quản lý thông tin người tham gia
- 🏷️ Cập nhật số áo (entry number) cho vận động viên
- ⏱️ Ghi nhận thời gian hoàn thành thi đấu
- 🏆 Tự động tính toán và cập nhật bảng xếp hạng
- ➕ Tạo sự kiện marathon mới
- 🗑️ Xóa thông tin người tham gia nếu cần thiết

### 🌟 Tính năng chung
- 🔄 Hiển thị kết quả và bảng xếp hạng real-time
- 🔐 Hệ thống bảo mật với đăng nhập admin
- 📱 Giao diện responsive cho mobile và desktop
- 🔄 Tự động refresh dữ liệu mỗi 30 giây

## 🛠️ Công nghệ sử dụng (Tech Stack)

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap Icons
- AJAX cho cập nhật real-time

### ⚙️ Backend
- PHP 
- MySQL

### 🗄️ Database
- 🗃️ MySQL với các bảng:
  - `admin_marathon`: Quản lý tài khoản admin
  - `name_marathon`: Thông tin các sự kiện marathon
  - `user_marathon`: Thông tin người tham gia

### 🔒 Security
- 🔐 Password hashing với `password_hash()`
- 🛡️ Prepared statements để tránh SQL injection
- ✅ Input validation và sanitization
- 🚫 XSS prevention

## 📋 Yêu cầu cài đặt (Prerequisites)

-  XAMPP
-  PHP  
-  MySQL  

## 🚀 Cài đặt và Chạy dự án (Getting Started)

### 1. 📥 Clone Repository
```bash
git clone <repository-url>
cd web-new
```

### 2. ⚙️ Cấu hình kết nối Database
Chỉnh sửa file [`webmarathon/backend/db_connect.php`](webmarathon/backend/db_connect.php):
```php
$server = "localhost";
$username = "yourusename";         
$password = "yourpassword";              
$database = "marathon";
```

### 3. ▶️ Khởi động dự án

1. 🚀 Khởi động XAMPP
2. 🗄️ Tạo Database 
  - Mở trình duyệt và truy cập: `http://localhost/phpmyadmin`

### 4. 📚 Hướng dẫn sử dụng

**Cho học sinh/giáo viên:**
1. Truy cập trang chủ để xem các sự kiện marathon
2. Click vào sự kiện để xem chi tiết
3. Nhấn "Register" để đăng ký tham gia
4. Theo dõi kết quả tại trang "Result"

**Cho admin:**
1.  Truy cập trang đăng nhập admin
2.  Sử dụng dashboard để quản lý người tham gia
3.  Cập nhật số áo và thời gian hoàn thành
4.  Tạo sự kiện marathon mới nếu cần

## Hướng dẫn chạy Kiểm thử (Running Tests)

### Kiểm thử chức năng chính:
1. **Đăng ký tham gia**: Test với dữ liệu hợp lệ và không hợp lệ
2. **Quản lý admin**: Đăng nhập, cập nhật thông tin, xóa người tham gia
3. **Hiển thị kết quả**: Kiểm tra real-time updates và bảng xếp hạng
4. **Tạo sự kiện**: Tạo marathon mới và kiểm tra hiển thị

### 🔒 Kiểm thử bảo mật:
1. Thử truy cập trang admin mà không đăng nhập
2. Test SQL injection với các input fields
3. Kiểm tra XSS prevention

## 📁 Cấu trúc thư mục (Folder Structure)

```
web-new/
├── README.md
└── webmarathon/                 # Marathon Management System
    ├── index.php               # Trang chủ hiển thị sự kiện
    ├── register.html           # Form đăng ký tham gia
    ├── result.html             # Hiển thị kết quả real-time
    ├── success.html            # Trang xác nhận đăng ký thành công
    ├── backend/                # Server-side logic
    │   ├── admin_login.php     # Đăng nhập admin
    │   ├── create_admin.php    # Tạo tài khoản admin
    │   ├── management.php      # Dashboard quản lý
    │   ├── register_process.php # Xử lý đăng ký
    │   ├── get_data.php        # API lấy dữ liệu kết quả
    │   ├── delete_user.php     # Xóa người tham gia
    │   ├── create_race.php     # Tạo sự kiện mới
    │   ├── hanoimarathon.php   # Trang Hà Nội Marathon
    │   ├── mydinhmarathon.php  # Trang Mỹ Đình Marathon
    │   └── db_connect.php      # Kết nối database
    ├── css/                    # Stylesheets
    │   ├── style.css           # CSS trang chủ
    │   ├── register.css        # CSS form đăng ký
    │   ├── result.css          # CSS trang kết quả
    │   ├── management.css      # CSS dashboard admin
    │   ├── admin_login.css     # CSS trang đăng nhập admin
    │   ├── hanoimarathon.css   # CSS trang Hà Nội Marathon
    │   ├── mydinhmarathon.css  # CSS trang Mỹ Đình Marathon
    │   └── success.css         # CSS trang thành công
    ├── js/                     # JavaScript files
    │   ├── index.js            # JS trang chủ
    │   ├── register.js         # JS form validation
    │   └── management.js       # JS dashboard admin
    └── images/                 # Assets và hình ảnh
```