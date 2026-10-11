<?php
require_once __DIR__ . "/../../config/database.php";

class BookModel
{
    // Khai báo các thuộc tính tương ứng với các cột trong bảng books
    public string $title = '';
    public string $author = '';
    public string $category = '';
    public ?string $publisher = null;
    public ?int $publish_year = null;
    public int $quantity = 0;
    public int $available = 0;
    public ?string $description = null;
    public ?string $cover_image = null;

    private Database $db;                                           // Khai báo thuộc tính $db có kiểu dữ liệu là Database

    public function __construct()                                   // Constructor: tự động chạy khi tạo đối tượng BookModel
    {
        $this->db = new Database();                                 // Tạo một đối tượng Database và lưu vào thuộc tính $db
    }

    // Hàm selectAll() dùng để lấy toàn bộ sách
    public function selectAll(): array
    {
        $sql = "SELECT * FROM books ORDER BY id ASC";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy 1 sách theo ID (dùng cho form sửa)
    public function getBookByID(int $id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    // Thêm sách mới
    public function add(): bool
    {
        $sql = "INSERT INTO books
                (title, author, category, publisher, publish_year, quantity, available, description, cover_image)
                VALUES
                (:title, :author, :category, :publisher, :publish_year, :quantity, :available, :description, :cover_image)";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute([
            'title'        => $this->title,
            'author'       => $this->author,
            'category'     => $this->category,
            'publisher'    => $this->publisher,
            'publish_year' => $this->publish_year,
            'quantity'     => $this->quantity,
            'available'    => $this->available,
            'description'  => $this->description,
            'cover_image'  => $this->cover_image,
        ]);
    }

    // Cập nhật sách theo ID
    public function update(int $id): bool
    {
        $sql = "UPDATE books SET
                    title = :title,
                    author = :author,
                    category = :category,
                    publisher = :publisher,
                    publish_year = :publish_year,
                    quantity = :quantity,
                    available = :available,
                    description = :description,
                    cover_image = :cover_image
                WHERE id = :id";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute([
            'title'        => $this->title,
            'author'       => $this->author,
            'category'     => $this->category,
            'publisher'    => $this->publisher,
            'publish_year' => $this->publish_year,
            'quantity'     => $this->quantity,
            'available'    => $this->available,
            'description'  => $this->description,
            'cover_image'  => $this->cover_image,
            'id'           => $id,
        ]);
    }

    // Xóa sách theo ID
    public function delete(int $id): bool
    {
        $stm = $this->db->pdo->prepare("DELETE FROM books WHERE id = :id");
        return $stm->execute(['id' => $id]);
    }

    // Điều chỉnh số bản còn lại (delta âm khi cho mượn, dương khi trả).
    // Luôn kẹp trong khoảng [0, quantity] để tránh âm kho hoặc vượt tồn.
    public function adjustAvailable(int $id, int $delta): bool
    {
        $sql = "UPDATE books
                SET available = LEAST(quantity, GREATEST(0, available + :delta))
                WHERE id = :id";
        $stm = $this->db->pdo->prepare($sql);
        return $stm->execute(['delta' => $delta, 'id' => $id]);
    }

    // Đếm tổng số đầu sách
    public function countAllBook(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
    }

    // Tổng số bản (tổng quantity)
    public function countTotalQuantity(): int
    {
        return (int)$this->db->pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM books")->fetchColumn();
    }

    // Tổng số bản còn lại (tổng available)
    public function countAvailable(): int
    {
        return (int)$this->db->pdo->query("SELECT COALESCE(SUM(available), 0) FROM books")->fetchColumn();
    }

    // Số đầu sách đã hết hàng
    public function countOutOfStock(): int
    {
        return (int)$this->db->pdo->query("SELECT COUNT(*) FROM books WHERE available <= 0")->fetchColumn();
    }

    // Danh sách thể loại (phục vụ bộ lọc ở View)
    public function getCategories(): array
    {
        $sql = "SELECT DISTINCT category FROM books
                WHERE category IS NOT NULL AND category <> ''
                ORDER BY category ASC";
        $stm = $this->db->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_COLUMN);
    }
}
