<?php
require_once __DIR__ . "/../../config/database.php";

class DocGiaModel
{
    // Khai báo các thuộc tính tương ứng với các cột trong bảng doc_gia
    public int $id_doc_gia = 0;
    public string $ma_doc_gia = '';
    public string $ho_ten = '';
    public string $ngay_sinh = '';
    public string $gioi_tinh = '';
    public string $so_dien_thoai = '';
    public string $dia_chi = '';
    public string $email = '';
    public string $created_at = '';

    private Database $db;                                           // Khai báo thuộc tính $db có kiểu dữ liệu là Database

    public function __construct()                                   // Constructor: tự động chạy khi tạo đối tượng DocGiaModel
    {
        $this->db = new Database();                                 // Tạo một đối tượng Database và lưu vào thuộc tính $db
    }

    // Hàm selectAll() dùng để lấy toàn bộ độc giả
    public function selectAll(): array
    {
        $sql = "SELECT * FROM doc_gia ORDER BY id_doc_gia ASC";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Đếm tổng số độc giả (phục vụ Dashboard)
    public function countAll(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM doc_gia")->fetchColumn();
    }

    // Thêm độc giả mới: chèn trước, sinh mã DGxxx từ ID vừa tạo
    public function add(): bool
    {
        // Bước 1: Thêm độc giả trước, chưa cần mã
        $sql = "INSERT INTO doc_gia
            (ho_ten, ngay_sinh, gioi_tinh, so_dien_thoai, dia_chi, email)
            VALUES
            (:hoTen, :ngaySinh, :gioiTinh, :soDT, :diaChi, :email)";

        $stm = $this->db->pdo->prepare($sql);

        $success = $stm->execute([
            'hoTen'    => $this->ho_ten,
            'ngaySinh' => $this->ngay_sinh !== '' ? $this->ngay_sinh : null,
            'gioiTinh' => $this->gioi_tinh,
            'soDT'     => $this->so_dien_thoai,
            'diaChi'   => $this->dia_chi,
            'email'    => $this->email !== '' ? $this->email : null,
        ]);

        if (!$success) {
            return false;
        }

        // Bước 2: Lấy ID vừa được MySQL tự sinh
        $this->id_doc_gia = (int)$this->db->pdo->lastInsertId();

        // Bước 3: Tạo mã độc giả từ ID
        $this->ma_doc_gia = "DG" . str_pad((string)$this->id_doc_gia, 3, "0", STR_PAD_LEFT);

        // Bước 4: Cập nhật mã vào database
        $sql = "UPDATE doc_gia
            SET ma_doc_gia = :maDocGia
            WHERE id_doc_gia = :id";

        $stm = $this->db->pdo->prepare($sql);

        return $stm->execute([
            'maDocGia' => $this->ma_doc_gia,
            'id'       => $this->id_doc_gia,
        ]);
    }

    // Lấy 1 độc giả theo ID (dùng cho form sửa)
    public function getDocGiaByID(int $id)
    {
        $sql = "SELECT * FROM doc_gia WHERE id_doc_gia = :id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    // Kiểm tra hồ sơ độc giả có tồn tại (dùng khi liên kết tài khoản)
    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) FROM doc_gia WHERE id_doc_gia = :id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
        return (int)$stm->fetchColumn() > 0;
    }

    // Cập nhật thông tin độc giả (không đổi mã độc giả)
    public function update(int $id): bool
    {
        $sql = "UPDATE doc_gia SET
                    ho_ten = :hoTen,
                    ngay_sinh = :ngaySinh,
                    gioi_tinh = :gioiTinh,
                    so_dien_thoai = :soDT,
                    dia_chi = :diaChi,
                    email = :email
                WHERE id_doc_gia = :id";

        $stm = $this->db->pdo->prepare($sql);

        return $stm->execute([
            'hoTen'    => $this->ho_ten,
            'ngaySinh' => $this->ngay_sinh !== '' ? $this->ngay_sinh : null,
            'gioiTinh' => $this->gioi_tinh,
            'soDT'     => $this->so_dien_thoai,
            'diaChi'   => $this->dia_chi,
            'email'    => $this->email !== '' ? $this->email : null,
            'id'       => $id,
        ]);
    }

    // Xóa độc giả theo ID
    public function delete(int $id): bool
    {
        $stm = $this->db->pdo->prepare("DELETE FROM doc_gia WHERE id_doc_gia = :id");
        return $stm->execute(['id' => $id]);
    }
}
