<?php
require_once __DIR__ . "/../../config/database.php";
class BookModel
{
    private Database $db;                                           // Khai báo thuộc tính $db có kiểu dữ liệu là Database
    public function __construct()                                   // Constructor: tự động chạy khi tạo đối tượng DocGiaModel
    {
        $this->db = new Database();                                 // Tạo một đối tượng Database và Sau đó lưu vào thuộc tính $db
    }

    public function countAllBook() {
        return 500;  
    }

    public function selectAll(): array                              // Hàm selectAll() dùng để lấy toàn bộ độc giả
    {
        $sql = "SELECT * FROM books";                             // Câu lệnh SQL lấy tất cả dữ liệu từ bảng doc_gia
        $stm = $this->db->pdo->prepare($sql);                       // Chuẩn bị câu SQL để thực thi thông qua PDO
        $stm->execute();                                            // Thực thi câu SQL
        $dsbook = $stm->fetchAll(PDO::FETCH_OBJ);                 // Lấy toàn bộ kết quả từ Database
        return $dsbook;                                           // Trả danh sách độc giả về cho Controller
    }
}




?>