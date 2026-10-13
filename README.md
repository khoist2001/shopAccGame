# 🎮 ShopAccGame - Hệ Thống Bán Tài Khoản Game Tự Động

> Website thương mại điện tử chuyên cung cấp và giao dịch tài khoản game tự động (Liên Minh Huyền Thoại, Valorant, Free Fire, Genshin Impact...) với giao diện hiện đại, tối ưu trải nghiệm người dùng và hệ thống quản trị mạnh mẽ.

---

## 🛠️ Công Nghệ Sử Dụng (Tech Stack)

| Thành phần | Công nghệ / Phiên bản | Mô tả |
| :--- | :--- | :--- |
| **Backend Framework** | **PHP 8.2+** / **Laravel 11.x** | Framework PHP hiện đại, kiến trúc MVC, bảo mật cao |
| **Database** | **MySQL 8.0** | Cơ sở dữ liệu quan hệ lưu trữ thông tin sản phẩm, đơn hàng, người dùng |
| **Web Server** | **Nginx (Alpine)** | Web server hiệu năng cao cấu hình reverse proxy chuyển tiếp tới PHP-FPM |
| **Containerization** | **Docker & Docker Compose** | Đóng gói toàn bộ môi trường (PHP, Nginx, MySQL, phpMyAdmin) chạy đồng nhất |
| **Frontend & UI** | **Blade Template + TailwindCSS** | Giao diện tối ưu chuẩn responsive, tương thích mọi thiết bị |
| **Asset Bundler** | **Vite** | Biên dịch CSS/JS nhanh chóng với Hot Module Replacement |
| **Database Tool** | **phpMyAdmin** | Giao diện web trực quan để quản lý cơ sở dữ liệu MySQL |

---

## ✨ Tính Năng Nổi Bật

### 👤 Dành Cho Khách Hàng (User)
- **Trang chủ & Danh mục Game**: Hiển thị các tựa game hot (LMHT, Valorant, Free Fire, Genshin Impact...).
- **Tìm kiếm & Bộ lọc tài khoản**: Lọc theo khoảng giá, cấp bậc (rank), tướng, trang phục (skin).
- **Chi tiết tài khoản**: Xem thông tin chi tiết, hình ảnh, thông số tài khoản trước khi mua.
- **Giỏ hàng & Đặt hàng**: Thêm vào giỏ hàng, mua ngay, áp dụng mã giảm giá (Coupon).
- **Hệ thống Ví & Nạp tiền**: Quản lý số dư, nạp tiền vào tài khoản và thanh toán tự động.
- **Lịch sử giao dịch & Tài khoản đã mua**: Xem lại tài khoản đã thanh toán (nhận thông tin đăng nhập ngay lập tức).
- **Danh sách yêu thích (Wishlist)**: Lưu lại các tài khoản quan tâm.

### 🛡️ Dành Cho Quản Trị Viên (Admin)
- **Admin Dashboard**: Thống kê tổng quan doanh thu, số lượng tài khoản đã bán, người dùng mới.
- **Quản lý Game**: Thêm, sửa, xóa danh mục tựa game.
- **Quản lý Tài khoản Game**: Đăng bán nick, cập nhật giá, trạng thái, hình ảnh và thông tin bí mật (tài khoản/mật khẩu).
- **Quản lý Người dùng**: Phân quyền, khóa/mở tài khoản, điều chỉnh số dư.
- **Quản lý Khuyến mãi (Coupons)**: Tạo mã giảm giá theo % hoặc số tiền cố định, giới hạn số lượt sử dụng.
- **Quản lý Đơn hàng**: Theo dõi lịch sử mua sắm của khách hàng.

### 🔌 REST API Tích Hợp
- Endpoints sẵn sàng cho ứng dụng di động hoặc tích hợp bên thứ ba:
  - `GET /api/games`: Danh sách tựa game.
  - `GET /api/accounts`: Danh sách tài khoản game.
  - `GET /api/accounts/{id}`: Chi tiết tài khoản game.

---

## 🔑 Tài Khoản Trải Nghiệm Mẫu (Sau khi chạy Seeder)

| Vai trò | Email đăng nhập | Mật khẩu | Số dư có sẵn |
| :--- | :--- | :--- | :--- |
| **Quản trị viên (Admin)** | `admin@gameshop.com` | `adminpassword` | 10.000.000 đ |
| **Khách hàng (User)** | `user@gameshop.com` | `userpassword` | 2.500.000 đ |

---

## 🚀 Hướng Dẫn Cài Đặt & Khởi Chạy

### Cách 1: Sử Dụng Docker (Khuyên Dùng - Nhanh & Tiện Nhất)

> **Yêu cầu**: Máy tính đã cài đặt [Docker Desktop](https://www.docker.com/products/docker-desktop/).

#### 1. Clone mã nguồn về máy:
```bash
git clone https://github.com/khoist2001/shopAccGame.git
cd shopAccGame
```

#### 2. Cấu hình file môi trường:
Sao chép file `.env.example` thành `.env`:
```bash
cp .env.example .env
```
*(Nếu dùng Windows PowerShell: `copy .env.example .env`)*

File `.env` đã được cấu hình sẵn các thông số kết nối tương thích với Docker Compose:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=shop_acc_game
DB_USERNAME=root
DB_PASSWORD=root
APP_URL=http://localhost:8000
```

#### 3. Khởi động hệ thống Docker:
```bash
docker compose up -d --build
```

#### 4. Khởi tạo dữ liệu (Chỉ cần chạy lần đầu):
```bash
# Chạy migration tạo các bảng trong database
docker compose exec app php artisan migrate

# Nạp dữ liệu mẫu (game, tài khoản, user test)
docker compose exec app php artisan db:seed

# Tạo liên kết lưu trữ tệp tin upload
docker compose exec app php artisan storage:link
```

#### 5. Truy cập ứng dụng:
- 🌐 **Website**: [http://localhost:8000](http://localhost:8000)
- 🗄️ **phpMyAdmin**: [http://localhost:8080](http://localhost:8080)
  - *Server*: `mysql`
  - *Username*: `root`
  - *Password*: `root`

---

### Cách 2: Cài Đặt Thủ Công Trên Máy (Local Environment)

> **Yêu cầu**: PHP >= 8.2, Composer, MySQL >= 8.0, Node.js & NPM.

```bash
# 1. Cài đặt các thư viện PHP
composer install

# 2. Tạo file cấu hình và sinh APP_KEY
cp .env.example .env
php artisan key:generate

# 3. Cấu hình DB_HOST=127.0.0.1 và tài khoản MySQL của bạn trong file .env
# 4. Chạy migration và seed dữ liệu
php artisan migrate --seed
php artisan storage:link

# 5. Cài đặt các thư viện frontend và build assets
npm install
npm run build

# 6. Khởi động server
php artisan serve
```
Truy cập: [http://localhost:8000](http://localhost:8000)

---

## 📌 Các Lệnh Docker Thường Dùng

- **Xem trạng thái các container**:
  ```bash
  docker compose ps
  ```
- **Xem nhật ký (logs)**:
  ```bash
  docker compose logs -f
  ```
- **Dừng toàn bộ hệ thống**:
  ```bash
  docker compose down
  ```
- **Chạy lệnh Artisan bên trong container**:
  ```bash
  docker compose exec app php artisan <lệnh>
  ```
- **Chạy Composer bên trong container**:
  ```bash
  docker compose exec app composer <lệnh>
  ```
- **Truy cập vào terminal của container PHP**:
  ```bash
  docker compose exec app bash
  ```

---

## 📂 Cấu Trúc Thư Mục Dự Án

```
shopAccGame/
├── app/                  # Chứa Controllers, Models, Middlewares
├── bootstrap/            # Khởi tạo ứng dụng Laravel
├── config/               # Các file cấu hình hệ thống
├── database/
│   ├── factories/        # Factories tạo dữ liệu giả lập
│   ├── migrations/       # Định nghĩa lược đồ cơ sở dữ liệu
│   └── seeders/          # Seeder dữ liệu mẫu cho game, acc, coupon
├── docker/
│   ├── nginx/conf.d/     # Cấu hình Nginx reverse proxy
│   └── php/              # Cấu hình tuỳ biến php.ini
├── public/               # Điểm truy cập gốc (index.php, static assets)
├── resources/
│   ├── views/            # Giao diện Blade templates
│   ├── css/              # Mã nguồn CSS / Tailwind
│   └── js/               # Mã nguồn JavaScript
├── routes/               # Định nghĩa các tuyến đường web & api
├── storage/              # Lưu trữ logs, cache, uploads
├── Dockerfile            # Chỉ thị build image PHP 8.2-FPM
├── docker-compose.yml    # Định nghĩa cấu hình các container dịch vụ
├── .dockerignore         # Loại trừ file khi build Docker
└── README.md             # Hướng dẫn chi tiết dự án
```

---

## 📄 Bản Quyền
Dự án được xây dựng phục vụ mục đích học tập và phát triển mã nguồn mở theo chuẩn [MIT License](LICENSE).
