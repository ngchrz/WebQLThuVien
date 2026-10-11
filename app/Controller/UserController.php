<?php

require_once __DIR__ . "/../Models/UserModel.php";
require_once __DIR__ . "/../Models/DocGiaModel.php";

class UserController
{
    private UserModel $user;
    private DocGiaModel $doc_gia;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->doc_gia = new DocGiaModel();
    }

    // Ghi thông báo tạm (flash) để hiển thị sau khi redirect
    private function flash(string $type, string $msg): void
    {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    }

    // Danh sách tài khoản
    public function index()
    {
        $dsUser = $this->user->selectAll();
        $tongAdmin = 0;
        $tongUser = 0;
        $tongKhoa = 0;
        foreach ($dsUser as $u) {
            if ($u->role === 'admin') $tongAdmin++;
            else $tongUser++;
            if ((int)$u->status === 0) $tongKhoa++;
        }
        require_once __DIR__ . "/../Views/user/userview.php";
    }

    // Chỉ tạo được tài khoản QUẢN TRỊ.
    // Tài khoản độc giả do người dùng TỰ ĐĂNG KÝ (trang đăng ký công khai).
    public function create()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $password === '') {
                $error = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($this->user->usernameExists($username)) {
                $error = 'Tên đăng nhập đã tồn tại.';
            } else {
                $this->user->username   = $username;
                $this->user->password   = password_hash($password, PASSWORD_DEFAULT);
                $this->user->role       = 'admin';   // luôn là quản trị
                $this->user->status     = 1;
                $this->user->id_doc_gia = null;

                if ($this->user->add()) {
                    $this->flash('success', 'Đã thêm tài khoản quản trị "' . $username . '".');
                    header('Location: index.php?modun=User');
                    exit();
                }
                $error = 'Thêm tài khoản thất bại, vui lòng thử lại.';
            }
        }

        require_once __DIR__ . "/../Views/user/formthem.php";
    }

    // Sửa thông tin tài khoản (không đổi mật khẩu tại đây)
    public function update(int $id)
    {
        $user = $this->user->getByID($id);
        if (!$user) {
            require_once __DIR__ . "/../Views/user/formsua.php";
            return;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = trim($_POST['username'] ?? '');
            $role     = ($_POST['role'] ?? 'user') === 'admin' ? 'admin' : 'user';
            $idDocGia = (($_POST['id_doc_gia'] ?? '') !== '') ? (int)$_POST['id_doc_gia'] : null;

            $isSelf = ((int)$id === (int)($_SESSION['user']['id'] ?? 0));

            if ($username === '') {
                $error = 'Tên đăng nhập không được để trống.';
            } elseif ($this->user->usernameExistsExcept($username, $id)) {
                $error = 'Tên đăng nhập đã bị tài khoản khác sử dụng.';
            } elseif ($idDocGia !== null && !$this->doc_gia->exists($idDocGia)) {
                $error = 'Hồ sơ độc giả liên kết không tồn tại.';
            } elseif ($isSelf && $role !== 'admin') {
                $error = 'Bạn không thể tự hạ quyền quản trị của chính mình.';
            } else {
                $this->user->username   = $username;
                $this->user->password   = $user->password;   // giữ nguyên mật khẩu cũ
                $this->user->role       = $role;
                $this->user->status     = (int)$user->status; // trạng thái đổi qua nút Khóa/Khôi phục
                $this->user->id_doc_gia = $idDocGia;

                if ($this->user->update($id)) {
                    if ($isSelf) {
                        $_SESSION['user']['username'] = $username;
                        $_SESSION['user']['role']     = $role;
                    }
                    $this->flash('success', 'Đã cập nhật tài khoản "' . $username . '".');
                    header('Location: index.php?modun=User');
                    exit();
                }
                $error = 'Cập nhật tài khoản thất bại, vui lòng thử lại.';
            }

            // Giữ lại dữ liệu vừa nhập để hiển thị khi có lỗi
            $user = (object)array_merge((array)$user, [
                'username'   => $username,
                'role'       => $role,
                'id_doc_gia' => $idDocGia,
            ]);
        }

        $dsDocGia = $this->doc_gia->selectAll();
        require_once __DIR__ . "/../Views/user/formsua.php";
    }

    // Đặt lại mật khẩu (khi độc giả quên mật khẩu)
    public function resetPassword(int $id)
    {
        $user = $this->user->getByID($id);
        if (!$user) {
            header('Location: index.php?modun=User');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $newPass = $_POST['new_password'] ?? '';
            if (strlen($newPass) < 6) {
                $this->flash('error', 'Mật khẩu mới phải có ít nhất 6 ký tự.');
            } elseif ($this->user->updatePassword($id, password_hash($newPass, PASSWORD_DEFAULT))) {
                $this->flash('success', 'Đã đặt lại mật khẩu cho "' . $user->username . '".');
            } else {
                $this->flash('error', 'Đặt lại mật khẩu thất bại.');
            }
        }

        header('Location: index.php?modun=User&action=update&id=' . $id);
        exit();
    }

    // Khóa tài khoản (khi vi phạm)
    public function lock(int $id)
    {
        $user = $this->user->getByID($id);
        $isSelf = ((int)$id === (int)($_SESSION['user']['id'] ?? 0));

        if (!$user) {
            $this->flash('error', 'Không tìm thấy tài khoản.');
        } elseif ($isSelf) {
            $this->flash('error', 'Bạn không thể tự khóa tài khoản đang đăng nhập.');
        } elseif ($user->role === 'admin' && $this->user->countAdmins() <= 1) {
            $this->flash('error', 'Không thể khóa quản trị viên cuối cùng của hệ thống.');
        } else {
            $this->user->setStatus($id, 0);
            $this->flash('success', 'Đã khóa tài khoản "' . $user->username . '".');
        }

        header('Location: index.php?modun=User');
        exit();
    }

    // Khôi phục tài khoản (mở khóa)
    public function unlock(int $id)
    {
        $user = $this->user->getByID($id);

        if (!$user) {
            $this->flash('error', 'Không tìm thấy tài khoản.');
        } else {
            $this->user->setStatus($id, 1);
            $this->flash('success', 'Đã khôi phục tài khoản "' . $user->username . '".');
        }

        header('Location: index.php?modun=User');
        exit();
    }
}
