<?php
require_once __DIR__ . "/../../config/database.php";

class UserModel
{
    // Thuộc tính tương ứng các cột trong bảng users
    public ?int $id = null;
    public string $username = '';
    public string $password = '';
    public string $role = 'user';
    public int $status = 1;
    public ?int $id_doc_gia = null;

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Tìm tài khoản theo username (dùng cho đăng nhập / kiểm tra trùng)
    public function findByUsername(string $username)
    {
        $sql = "SELECT * FROM users WHERE username = :u LIMIT 1";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['u' => $username]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    // Kiểm tra username đã tồn tại chưa
    public function usernameExists(string $username): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :u";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['u' => $username]);
        return (int)$stm->fetchColumn() > 0;
    }

    // Kiểm tra username đã bị tài khoản KHÁC dùng chưa (dùng khi sửa)
    public function usernameExistsExcept(string $username, int $exceptId): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :u AND id <> :id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['u' => $username, 'id' => $exceptId]);
        return (int)$stm->fetchColumn() > 0;
    }

    // Lấy 1 tài khoản theo ID
    public function getByID(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    // Thêm tài khoản mới
    public function add(): bool
    {
        $sql = "INSERT INTO users (username, password, role, status, id_doc_gia)
                VALUES (:username, :password, :role, :status, :id_doc_gia)";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute([
            'username'   => $this->username,
            'password'   => $this->password,
            'role'       => $this->role,
            'status'     => $this->status,
            'id_doc_gia' => $this->id_doc_gia,
        ]);
    }

    // Cập nhật thông tin tài khoản (username, role, liên kết độc giả)
    public function update(int $id): bool
    {
        $sql = "UPDATE users SET
                    username = :username,
                    password = :password,
                    role = :role,
                    status = :status,
                    id_doc_gia = :id_doc_gia
                WHERE id = :id";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute([
            'username'   => $this->username,
            'password'   => $this->password,
            'role'       => $this->role,
            'status'     => $this->status,
            'id_doc_gia' => $this->id_doc_gia,
            'id'         => $id,
        ]);
    }

    // Đặt lại mật khẩu (admin dùng khi độc giả quên mật khẩu)
    public function updatePassword(int $id, string $hash): bool
    {
        $stm = $this->db->pdo->prepare("UPDATE users SET password = :p WHERE id = :id");
        return $stm->execute(['p' => $hash, 'id' => $id]);
    }

    // Đổi tên đăng nhập (dùng cho trang thông tin cá nhân)
    public function updateUsername(int $id, string $username): bool
    {
        $stm = $this->db->pdo->prepare("UPDATE users SET username = :u WHERE id = :id");
        return $stm->execute(['u' => $username, 'id' => $id]);
    }

    // Khóa / khôi phục tài khoản (1 = hoạt động, 0 = bị khóa)
    public function setStatus(int $id, int $status): bool
    {
        $stm = $this->db->pdo->prepare("UPDATE users SET status = :s WHERE id = :id");
        return $stm->execute(['s' => $status, 'id' => $id]);
    }

    // Danh sách tài khoản (kèm họ tên độc giả liên kết)
    public function selectAll(): array
    {
        $sql = "SELECT u.*, d.ho_ten, d.ma_doc_gia
                FROM users u
                LEFT JOIN doc_gia d ON d.id_doc_gia = u.id_doc_gia
                ORDER BY u.id ASC";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Đếm tổng số tài khoản (phục vụ Dashboard)
    public function countAll(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    // Đếm số tài khoản quản trị (tránh tự hạ quyền / khóa admin cuối cùng)
    public function countAdmins(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
    }
}
