<?php

require_once __DIR__ . "/../Models/UserModel.php";
require_once __DIR__ . "/../Models/DocGiaModel.php";

class AuthController
{
    private UserModel $user;
    private DocGiaModel $doc_gia;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->doc_gia = new DocGiaModel();
    }

    // ---- ĐĂNG NHẬP ----
    public function login()
    {
        // Đã đăng nhập rồi thì về trang chủ
        if (!empty($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $u = $this->user->findByUsername($username);

            if ($u && (int)$u->status === 1 && password_verify($password, $u->password)) {
                // Lấy họ tên độc giả liên kết (nếu có)
                $hoTen = $u->username;
                if (!empty($u->id_doc_gia)) {
                    $dg = $this->doc_gia->getDocGiaByID((int)$u->id_doc_gia);
                    if ($dg) {
                        $hoTen = $dg->ho_ten;
                    }
                }

                $_SESSION['user'] = [
                    'id'         => (int)$u->id,
                    'username'   => $u->username,
                    'role'       => $u->role,
                    'id_doc_gia' => $u->id_doc_gia !== null ? (int)$u->id_doc_gia : null,
                    'ho_ten'     => $hoTen,
                ];

                // Quay lại trang khách muốn tới trước khi bị chặn (nếu có)
                $redirect = $_SESSION['redirect_after_login'] ?? 'index.php';
                unset($_SESSION['redirect_after_login']);

                // An toàn: chỉ chấp nhận đường dẫn nội bộ
                if ($redirect === '' || strpos($redirect, '://') !== false || $redirect[0] !== '/') {
                    $redirect = 'index.php';
                }
                // Mượn sách là hành động GET có tác dụng phụ -> không phát lại, đưa về trang sách
                if (strpos($redirect, 'action=borrow') !== false) {
                    $redirect = 'index.php?modun=Book';
                }

                header('Location: ' . $redirect);
                exit();
            }

            $error = 'Tên đăng nhập hoặc mật khẩu không đúng (hoặc tài khoản đã bị khóa).';
        }

        require_once __DIR__ . "/../Views/auth/login.php";
    }

    // ---- ĐĂNG KÝ (tạo hồ sơ độc giả + tài khoản liên kết) ----
    public function register()
    {
        if (!empty($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm'] ?? '';
            $hoTen    = trim($_POST['hoten'] ?? '');

            if ($hoTen === '' || $username === '' || $password === '') {
                $error = 'Vui lòng nhập đầy đủ họ tên, tên đăng nhập và mật khẩu.';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($password !== $confirm) {
                $error = 'Xác nhận mật khẩu không khớp.';
            } elseif ($this->user->usernameExists($username)) {
                $error = 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.';
            } else {
                // Bước 1: tạo hồ sơ độc giả
                $this->doc_gia->ho_ten        = $hoTen;
                $this->doc_gia->ngay_sinh     = $_POST['ngaysinh'] ?? '';
                $this->doc_gia->gioi_tinh     = $_POST['gioitinh'] ?? '';
                $this->doc_gia->so_dien_thoai = trim($_POST['sdt'] ?? '');
                $this->doc_gia->dia_chi       = trim($_POST['diachi'] ?? '');
                $this->doc_gia->email         = trim($_POST['email'] ?? '');

                if ($this->doc_gia->add()) {
                    // Bước 2: tạo tài khoản gắn với độc giả vừa tạo
                    $this->user->username   = $username;
                    $this->user->password   = password_hash($password, PASSWORD_DEFAULT);
                    $this->user->role       = 'user';
                    $this->user->status     = 1;
                    $this->user->id_doc_gia = $this->doc_gia->id_doc_gia;

                    if ($this->user->add()) {
                        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Đăng ký thành công! Bạn có thể đăng nhập ngay.'];
                        header('Location: index.php?modun=Auth&action=login');
                        exit();
                    }
                    $error = 'Tạo tài khoản thất bại, vui lòng thử lại.';
                } else {
                    $error = 'Tạo hồ sơ độc giả thất bại, vui lòng thử lại.';
                }
            }
        }

        require_once __DIR__ . "/../Views/auth/register.php";
    }

    // ---- ĐĂNG XUẤT ----
    public function logout()
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: index.php?modun=Auth&action=login');
        exit();
    }
}
