<?php

require_once __DIR__ . "/../Models/UserModel.php";
require_once __DIR__ . "/../Models/DocGiaModel.php";

class ProfileController
{
    private UserModel $user;
    private DocGiaModel $doc_gia;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->doc_gia = new DocGiaModel();
    }

    private function flash(string $type, string $msg): void
    {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    }

    // Trang thông tin tài khoản cá nhân
    public function index()
    {
        $id = (int)($_SESSION['user']['id'] ?? 0);
        $user = $this->user->getByID($id);

        $docgia = null;
        if ($user && !empty($user->id_doc_gia)) {
            $docgia = $this->doc_gia->getDocGiaByID((int)$user->id_doc_gia);
        }

        require_once __DIR__ . "/../Views/profile/profileview.php";
    }

    // Cập nhật thông tin (tên đăng nhập + hồ sơ độc giả nếu có liên kết)
    public function updateInfo()
    {
        $id = (int)($_SESSION['user']['id'] ?? 0);
        $user = $this->user->getByID($id);

        if (!$user) {
            header('Location: index.php?modun=Auth&action=logout');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = trim($_POST['username'] ?? '');

            if ($username === '') {
                $this->flash('error', 'Tên đăng nhập không được để trống.');
            } elseif ($this->user->usernameExistsExcept($username, $id)) {
                $this->flash('error', 'Tên đăng nhập đã bị người khác sử dụng.');
            } else {
                // Cập nhật tên đăng nhập
                $this->user->updateUsername($id, $username);
                $_SESSION['user']['username'] = $username;

                // Cập nhật hồ sơ độc giả (nếu có liên kết)
                if (!empty($user->id_doc_gia)) {
                    $this->doc_gia->ho_ten        = trim($_POST['ho_ten'] ?? '');
                    $this->doc_gia->ngay_sinh     = $_POST['ngay_sinh'] ?? '';
                    $this->doc_gia->gioi_tinh     = $_POST['gioi_tinh'] ?? '';
                    $this->doc_gia->so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
                    $this->doc_gia->dia_chi       = trim($_POST['dia_chi'] ?? '');
                    $this->doc_gia->email         = trim($_POST['email'] ?? '');
                    $this->doc_gia->update((int)$user->id_doc_gia);

                    $_SESSION['user']['ho_ten'] = $this->doc_gia->ho_ten;
                }

                $this->flash('success', 'Đã cập nhật thông tin cá nhân.');
            }
        }

        header('Location: index.php?modun=Profile');
        exit();
    }

    // Đổi mật khẩu (yêu cầu xác thực mật khẩu hiện tại)
    public function changePassword()
    {
        $id = (int)($_SESSION['user']['id'] ?? 0);
        $user = $this->user->getByID($id);

        if (!$user) {
            header('Location: index.php?modun=Auth&action=logout');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $current = $_POST['current_password'] ?? '';
            $new     = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (!password_verify($current, $user->password)) {
                $this->flash('error', 'Mật khẩu hiện tại không đúng.');
            } elseif (strlen($new) < 6) {
                $this->flash('error', 'Mật khẩu mới phải có ít nhất 6 ký tự.');
            } elseif ($new !== $confirm) {
                $this->flash('error', 'Xác nhận mật khẩu mới không khớp.');
            } else {
                $this->user->updatePassword($id, password_hash($new, PASSWORD_DEFAULT));
                $this->flash('success', 'Đã đổi mật khẩu thành công.');
            }
        }

        header('Location: index.php?modun=Profile');
        exit();
    }
}
