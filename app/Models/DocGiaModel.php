<?php
require_once __DIR__ . "/../../config/database.php";
class DocGiaModel
{
    // Khai báo các thuộc tính tương ứng với các cột trong bảng doc_gia
    public int $id_doc_gia;
    public string $ma_doc_gia;
    public string $ho_ten;
    public string $ngay_sinh;
    public string $gioi_tinh;
    public string $so_dien_thoai;
    public string $dia_chi;
    public string $email;
    public string $created_at;

    private Database $db;                                           // Khai báo thuộc tính $db có kiểu dữ liệu là Database
    public function __construct()                                   // Constructor: tự động chạy khi tạo đối tượng DocGiaModel
    {
        $this->db = new Database();                                 // Tạo một đối tượng Database và Sau đó lưu vào thuộc tính $db
    }
    public function selectAll(): array                              // Hàm selectAll() dùng để lấy toàn bộ độc giả
    {
        $sql = "SELECT * FROM doc_gia";                             // Câu lệnh SQL lấy tất cả dữ liệu từ bảng doc_gia
        $stm = $this->db->pdo->prepare($sql);                       // Chuẩn bị câu SQL để thực thi thông qua PDO
        $stm->execute();                                            // Thực thi câu SQL
        $dsDocGia = $stm->fetchAll(PDO::FETCH_OBJ);                 // Lấy toàn bộ kết quả từ Database
        return $dsDocGia;                                           // Trả danh sách độc giả về cho Controller
    }

    public function add(): bool
    {
        // Bước 1: Thêm độc giả trước, chưa cần mã
        $sql = "INSERT INTO doc_gia
            (ho_ten, ngay_sinh, gioi_tinh, so_dien_thoai, dia_chi)
            VALUES
            (:hoTen, :ngaySinh, :gioiTinh, :soDT, :diaChi)";

        $stm = $this->db->pdo->prepare($sql);

        $success = $stm->execute([
            'hoTen' => $this->ho_ten,
            'ngaySinh' => $this->ngay_sinh,
            'gioiTinh' => $this->gioi_tinh,
            'soDT' => $this->so_dien_thoai,
            'diaChi' => $this->dia_chi
        ]);

        if (!$success) {
            return false;
        }

        // Bước 2: Lấy ID vừa được MySQL tự sinh
        $this->id_doc_gia = $this->db->pdo->lastInsertId();

        // Bước 3: Tạo mã độc giả từ ID
        $this->ma_doc_gia = "DG" . str_pad($this->id_doc_gia, 3, "0", STR_PAD_LEFT);

        // Bước 4: Cập nhật mã vào database
        $sql = "UPDATE doc_gia
            SET ma_doc_gia = :maDocGia
            WHERE id_doc_gia = :id";

        $stm = $this->db->pdo->prepare($sql);

        return $stm->execute([
            'maDocGia' => $this->ma_doc_gia,
            'id' => $this->id_doc_gia
        ]);
    }

    public function getDocGiaByID(int $id){
        $sql = "SELECT * FROM doc_gia WHERE id_doc_gia=:id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['id' => $id]);

        return $stm->fetch(PDO::FETCH_OBJ);

    }
}
