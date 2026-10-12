# WebQLThuVien — Hệ thống quản lý thư viện

Ứng dụng web quản lý thư viện viết bằng **PHP thuần** theo mô hình **MVC**, dùng **MySQL** và giao diện **Tailwind CSS**. Hệ thống hỗ trợ phân quyền quản trị viên / độc giả, quản lý kho sách, nghiệp vụ mượn – trả và cho phép độc giả tự đăng ký tài khoản.

> Dự án phục vụ mục đích học tập: minh hoạ cách xây dựng một ứng dụng CRUD hoàn chỉnh với PHP/PDO mà không dùng framework.

---

## Tính năng

### Dùng chung
- Đăng nhập / Đăng ký / Đăng xuất; mật khẩu mã hoá bằng `password_hash()`.
- Phân quyền `admin` / `user`; chặn truy cập khi chưa đăng nhập.
- Trang **Thông tin cá nhân**: xem, cập nhật thông tin và đổi mật khẩu.
- **Thông báo** (chuông): cảnh báo phiếu quá hạn và sắp đến hạn.
- Giao diện responsive, sidebar cố định, thông báo flash.

### Quản trị viên (admin)
- **Dashboard** thống kê: số đầu sách, tổng bản, độc giả, phiếu đang mượn / quá hạn / đã trả, người dùng.
- **Quản lý độc giả**: thêm / sửa / xoá, hệ thống tự sinh mã `DGxxx`.
- **Quản lý sách**: thêm / sửa / xoá, upload ảnh bìa, theo dõi tồn kho (`quantity` / `available`).
- **Mượn / Trả**: ghi nhận phiếu mượn, xác nhận trả sách, tự động cập nhật tồn kho.
- **Quản lý tài khoản**: sửa thông tin, đặt lại mật khẩu (khi quên), khoá / khôi phục tài khoản (khi vi phạm).

### Độc giả (user)
- Tự đăng ký tài khoản gắn với hồ sơ độc giả.
- Xem **danh mục sách**, tìm kiếm và lọc theo thể loại.
- **Tự mượn sách** (tự trừ tồn kho, hạn trả 14 ngày), xem và tự trả phiếu của mình.
- Cập nhật thông tin cá nhân và đổi mật khẩu.

---

## Công nghệ sử dụng

| Thành phần | Công nghệ |
|---|---|
| Ngôn ngữ | PHP 8.x (thuần, không framework) |
| Kiến trúc | MVC — Router → Controller → Model → View |
| Cơ sở dữ liệu | MySQL / MariaDB, truy vấn qua PDO |
| Giao diện | Tailwind CSS (CDN), Font Awesome, Google Fonts (Inter) |
| Bảo mật | `password_hash` / `password_verify`, session, `htmlspecialchars` |

---

## Cấu trúc thư mục

```
WebQLThuVien/
├── index.php                 # Router trung tâm (điều hướng module + action)
├── database.sql              # Script tạo CSDL + dữ liệu mẫu
├── config/
│   └── database.php          # Cấu hình kết nối CSDL (PDO)
├── app/
│   ├── Controller/           # Auth, Dashboard, DocGia, Book, Loan, User, Profile
│   ├── Models/               # DocGia, Book, Loan, User, Notification
│   └── Views/                # header.php, footer.php và các thư mục theo module
└── img/
    └── product/              # Ảnh bìa sách
```

---

## Cài đặt

### Yêu cầu
- PHP >= 8.0 (khuyến nghị 8.2)
- MySQL / MariaDB
- Gợi ý: XAMPP hoặc Laragon

### Các bước

1. Clone dự án:
   ```bash
   git clone https://github.com/ngchrz/WebQLThuVien.git
   ```

2. Đặt thư mục vào web root (XAMPP: `C:\xampp\htdocs\WebQLThuVien`).

3. Tạo cơ sở dữ liệu: mở `http://localhost/phpmyadmin` → **Import** → chọn file `database.sql`.
   Script sẽ tự tạo database `thuvien_db` cùng các bảng và dữ liệu mẫu.

4. Kiểm tra cấu hình kết nối trong `config/database.php` (mặc định: `localhost:3306`, user `root`, mật khẩu rỗng).

5. Truy cập: `http://localhost/WebQLThuVien`

---

## Tài khoản mẫu

| Vai trò | Tên đăng nhập | Mật khẩu |
|---|---|---|
| Quản trị viên | `admin` | `admin123` |
| Độc giả | `an`, `anh`, `nam`, `ha`, `quan`, `thang` | `123456` |

Hoặc vào trang **Đăng ký** để tự tạo tài khoản độc giả mới.

---

## Phân quyền

| Chức năng | Quản trị viên | Độc giả |
|---|:---:|:---:|
| Dashboard thống kê | ✔ | — |
| Quản lý độc giả | ✔ | — |
| Quản lý sách (thêm/sửa/xoá) | ✔ | — |
| Xem danh mục sách | ✔ | ✔ |
| Ghi nhận mượn / trả | ✔ | — |
| Tự mượn / trả sách | — | ✔ |
| Quản lý tài khoản | ✔ | — |
| Thông tin cá nhân | ✔ | ✔ |

---

## Ghi chú kỹ thuật

- Ảnh bìa lưu trong `img/product/`, tên file được ghi vào cột `cover_image`.
- Hệ thống dùng **khoá mềm** (`users.status = 0`) thay vì xoá tài khoản, nên luôn khôi phục được.
- Khoá ngoại: `users.id_doc_gia` → `doc_gia`, `loans.user_id` → `users`, `loans.book_id` → `books`.
- ID không tái sử dụng: các bảng dùng `AUTO_INCREMENT` chỉ tăng, không đặt lại.

---

## Giấy phép

Dự án được chia sẻ cho mục đích học tập.
